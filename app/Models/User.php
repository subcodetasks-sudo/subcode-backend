<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'reset_code',
        'mobile_verified_at',
        'email_verified_at',
        'verification_code',
        'password',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mobile_verified_at' => 'datetime', 
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has a valid verification code
     */
    public function getHasValidVerificationCodeAttribute(): bool
    {
        return $this->verification_code !== null;
    }

    /**
     * Check if mobile is verified
     */
    public function isVerified(): bool
    {
        return $this->mobile_verified_at !== null;
    }

    /**
     * Verify mobile code
     */
    public function verifyMobileCode(string $code): bool
    {
        if (!$this->has_valid_verification_code) {
            return false;
        }

        if ($this->verification_code !== $code) {
            return false;
        }

        if (!$this->isVerified()) {
            $this->update([
                'mobile_verified_at' => now(),
                'verification_code' => null  
            ]);
        }

        return true;
    }

    /**
     * Mark mobile as verified
     */
    public function markMobileAsVerified(): bool
    {
        return $this->forceFill([
            'mobile_verified_at' => $this->freshTimestamp(),
            'verification_code' => null,
        ])->save();
    }

     protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->verification_code)) {
                $user->verification_code = self::generateVerificationCode();
            }
        });
    }

  
    public function hasVerifiedEmail(): bool
    {
        return $this->isVerified();
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Generate a 6-digit verification code.
     *
     * @return string
     */
    public static function generateVerificationCode(): string
    {
        return (string) mt_rand(100000, 999999);
    }

    /**
     * Generate and set a new verification code for the user.
     *
     * @return string
     */
    public function regenerateVerificationCode(): string
    {
        $this->verification_code = self::generateVerificationCode();
        $this->save();
        
        return $this->verification_code;
    }

    /**
     * Generate and set a new reset code for the user.
     *
     * @return string
     */
    public function generateResetCode(): string
    {
        $this->reset_code = (string) mt_rand(100000, 999999);
        $this->save();
        
        return $this->reset_code;
    }

    /**
     * Clear the reset code.
     *
     * @return bool
     */
    public function clearResetCode(): bool
    {
        return $this->forceFill([
            'reset_code' => null,
        ])->save();
    }

    /**
     * Check if reset code is valid
     */
    public function isValidResetCode(string $code): bool
    {
        return $this->reset_code === $code;
    }

    /**
     * Reset password
     */
    public function resetPassword(string $newPassword): void
    {
        $this->update([
            'password' => Hash::make($newPassword),
            'reset_code' => null,
        ]);
    }

    /**
     * to handlde changePassword to make new password hash
     */
    public function changePassword(string $newPassword): void
    {
        $this->update(['password' => Hash::make($newPassword)]);
    }
}

