<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getSettings();
        return view('backend.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_title' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contact_email' => 'required|email|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'maintenance_mode' => 'boolean',
            'enable_registration' => 'boolean',
            'enable_comments' => 'boolean',
        ]);

        if ($request->hasFile('site_logo')) {
            $currentLogo = Setting::where('key', 'site_logo')->value('value');

            if ($currentLogo && file_exists(public_path('images/' . $currentLogo))) {
                unlink(public_path('images/' . $currentLogo));
            }

            $extension = $request->file('site_logo')->extension();
            $filename = Str::random(40) . '.' . $extension;

            $request->file('site_logo')->move(public_path('images'), $filename);

            $validated['site_logo'] = $filename;
        }

        $validated['maintenance_mode'] = $request->has('maintenance_mode');
        $validated['enable_registration'] = $request->has('enable_registration');
        $validated['enable_comments'] = $request->has('enable_comments');

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    protected function removeExistingLogo()
    {
        $currentLogo = Setting::where('key', 'site_logo')->value('value');
        if ($currentLogo && file_exists(public_path('images/' . $currentLogo))) {
            unlink(public_path('images/' . $currentLogo));
        }
    }

    protected function removeLogo()
    {
        $currentLogo = Setting::where('key', 'site_logo')->value('value');
        if ($currentLogo) {
            if (file_exists(public_path('images/' . $currentLogo))) {
                unlink(public_path('images/' . $currentLogo));
            }
            Setting::where('key', 'site_logo')->delete();
        }
    }
}
