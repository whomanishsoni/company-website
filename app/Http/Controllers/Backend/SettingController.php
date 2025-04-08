<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::allCached();
        return view('backend.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $this->validateSettings($request);

        $this->handleFileUploads($request, $validated);
        $this->handleCheckboxes($request, $validated);

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully');
    }

    public function clearCache()
    {
        try {
            Artisan::call('optimize:clear');
            Setting::clearCache();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    protected function validateSettings(Request $request): array
    {
        return $request->validate([
            'site_title' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'contact_email' => 'required|email|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'enable_cookie_consent' => 'boolean',
            'cookie_message' => 'nullable|string|max:500',
            'privacy_policy_url' => 'nullable|url|max:255',
            'maintenance_mode' => 'boolean',
            'enable_registration' => 'boolean',
            'enable_comments' => 'boolean',
            'remove_logo' => 'boolean',
            'remove_favicon' => 'boolean',
        ]);
    }

    protected function handleFileUploads(Request $request, array &$validated): void
    {
        $fileHandlers = [
            'site_logo' => [
                'path' => 'public/images',
                'remove_flag' => 'remove_logo',
                'current' => Setting::getValue('site_logo')
            ],
            'favicon' => [
                'path' => 'public/favicons',
                'remove_flag' => 'remove_favicon',
                'current' => Setting::getValue('favicon')
            ]
        ];

        foreach ($fileHandlers as $field => $config) {
            if ($request->hasFile($field)) {
                $validated[$field] = $this->uploadFile(
                    $request->file($field),
                    $config['path'],
                    $config['current']
                );
            } elseif ($request->has($config['remove_flag'])) {
                $this->deleteFile($config['current']);
                $validated[$field] = null;
            } else {
                unset($validated[$field]);
            }
        }
    }

    protected function handleCheckboxes(Request $request, array &$validated): void
    {
        $checkboxes = [
            'enable_cookie_consent',
            'maintenance_mode',
            'enable_registration',
            'enable_comments'
        ];

        foreach ($checkboxes as $checkbox) {
            $validated[$checkbox] = $request->has($checkbox) ? 1 : 0;
        }
    }

    protected function uploadFile($file, string $path, ?string $current = null): string
    {
        $this->deleteFile($current);

        $filename = date('YmdHis') . '_' . uniqid() . '.' . $file->extension();

        // Store directly in public/images instead of storage
        $destination = public_path(str_replace('public/', '', $path));
        $file->move($destination, $filename);

        return $filename;
    }

    protected function deleteFile(?string $path): void
    {
        if ($path) {
            $fullPath = public_path('images/' . $path);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
