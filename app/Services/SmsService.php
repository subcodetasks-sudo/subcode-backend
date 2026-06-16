<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class SmsService
{
      public function sendVerificationCode(User $user): void
    {
        $user->regenerateVerificationCode();
        
        $message = __('sms.verification_message', ['code' => $user->verification_code]);
        
        $this->sendSms($user->mobile, $message, 'verification');
    }

    /**
     * Send password reset code to user
     */
    public function sendResetCode(User $user): void
    {
        $user->generateResetCode();
        
        $message = __('sms.reset_code_message', ['code' => $user->reset_code]);
        
        $this->sendSms($user->mobile, $message, 'reset_password');
    }


    private function sendSms(string $mobile, string $message): void
    {
     
        try {
            // Http::post('https://sms-provider.com/api/send', [...])
            Log::info("📱 SMS sent to {$mobile}: {$message}");
        } catch (\Exception $e) {
            Log::error("Failed to send SMS to {$mobile}", ['error' => $e->getMessage()]);
        }
    }
}
