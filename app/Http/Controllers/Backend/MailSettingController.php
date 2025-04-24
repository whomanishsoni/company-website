<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class MailSettingController extends Controller
{
    public function index()
    {
        Log::info('Accessing mail settings index page.');
        $settings = MailSetting::allCached();
        return view('backend.mail_settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        Log::info('Mail settings update attempt started.', ['input' => $request->all()]);

        try {
            $validated = $request->validate([
                'mailer' => 'required|in:smtp,sendmail,mailgun,ses,postmark,log',
                'host' => 'nullable|string|max:255',
                'port' => 'nullable|integer|min:1|max:65535',
                'username' => 'nullable|string|max:255',
                'password' => 'nullable|string|max:255',
                'encryption' => 'nullable|in:ssl,tls,null',
                'from_address' => 'nullable|email|max:255',
                'from_name' => 'nullable|string|max:255',
            ]);

            // Update or create the mail settings in the database
            $settings = MailSetting::first() ?? new MailSetting();
            $settings->fill($validated)->save();
            Log::info('Mail settings saved to database.', ['settings' => $validated]);

            // Clear cache
            MailSetting::clearCache();

            // Update runtime mail configuration
            $this->updateMailConfig($validated);

            // Test mail configuration
            try {
                Mail::raw('This is a test email to verify mail settings.', function ($message) use ($validated) {
                    $message->to($validated['from_address'])
                        ->subject('Test Email');
                });
                Log::info('Test email sent successfully.', ['to' => $validated['from_address']]);
            } catch (\Exception $e) {
                Log::warning('Test email failed.', ['error' => $e->getMessage()]);
                return redirect()->route('mail-settings.index')
                    ->with('error', 'Mail settings updated, but sending test email failed: ' . $e->getMessage());
            }

            return redirect()->route('mail-settings.index')
                ->with('success', 'Mail settings updated successfully, and test email sent.');
        } catch (\Exception $e) {
            Log::error('Failed to update mail settings.', ['error' => $e->getMessage()]);
            return redirect()->route('mail-settings.index')
                ->with('error', 'Failed to update mail settings: ' . $e->getMessage());
        }
    }

    protected function updateMailConfig(array $data)
    {
        try {
            Config::set('mail.mailer', $data['mailer']);
            Config::set('mail.mailers.smtp.host', $data['host'] ?? '');
            Config::set('mail.mailers.smtp.port', $data['port'] ?? '');
            Config::set('mail.mailers.smtp.username', $data['username'] ?? '');
            Config::set('mail.mailers.smtp.password', $data['password'] ?? '');
            Config::set('mail.mailers.smtp.encryption', $data['encryption'] ?? '');
            Config::set('mail.from.address', $data['from_address'] ?? '');
            Config::set('mail.from.name', $data['from_name'] ?? '');
            Log::info('Runtime mail configuration updated.');
        } catch (\Exception $e) {
            Log::error('Failed to update runtime mail configuration.', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
