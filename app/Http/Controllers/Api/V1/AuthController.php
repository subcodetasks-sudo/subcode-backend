<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{
    RegisterRequest,
    LoginRequest,
    VerificationRequest,
    ResendVerificationRequest,
    ForgotPasswordRequest,
    VerifyResetCodeRequest,
    ResetPasswordRequest
};
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\SmsService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{Auth, Cache, Hash, Log};
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly SmsService $smsService
    ) {}

    /**
     * Register a new user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->createUser($request->validated());
        
        $this->sendVerificationSms($user);

        return $this->success(
            new UserResource($user),
            __('auth.account_created_successful')
        );
    }

    /**
     * Login user
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::withTrashed()->where('mobile', $request->mobile)->first();

        if ($user?->trashed()) {
            return $this->error(__('auth.account_removed'));
        }

        if (!Auth::attempt($request->only('mobile', 'password'))) {
            return $this->error(__('auth.invalid_credentials'), 401);
        }

        $user = Auth::user();

        if (!$user->isVerified()) {
            $this->sendVerificationSms($user);
            return $this->error(__('auth.mobile_not_verified'), 401, 'mobile_not_verified');
        }

        return $this->success(
            $this->getUserDataWithToken($user),
            __('auth.user_login_successful')
        );
    }

    /**
     * Verify mobile with code
     */
    public function verification(VerificationRequest $request): JsonResponse
    {
        $user = User::where('mobile', $request->mobile)
            ->where('verification_code', $request->verification_code)
            ->first();

        if (!$user) {
            return $this->error(__('auth.invalid_verification_code_mobile'), 422);
        }

        if (!$user->isVerified()) {
            $user->markMobileAsVerified();
        }

        return $this->success(
            $this->getUserDataWithToken($user),
            __('auth.mobile_verified_successfully')
        );
    }

    /**
     * Resend verification code
     */
    public function resendVerification(ResendVerificationRequest $request): JsonResponse
    {
        $user = User::where('mobile', $request->mobile)->firstOrFail();

        if ($user->isVerified()) {
            return $this->error(__('auth.mobile_already_verified'), 202);
        }

        $user->regenerateVerificationCode();
        $this->sendVerificationSms($user);

        return $this->success([], __('auth.verification_code_sent_successfully'));
    }

    /**
     * Send password reset code
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $user = User::where('mobile', $request->mobile)->firstOrFail();

        if (!$user->isVerified()) {
            return $this->error(__('auth.mobile_not_verified'), 403);
        }

        $user->generateResetCode();
        $this->sendResetCodeSms($user);

        return $this->success([], __('auth.reset_code_sent'));
    }

    /**
     * Verify password reset code
     */
    public function verifyResetCode(VerifyResetCodeRequest $request): JsonResponse
    {
        $user = User::where('mobile', $request->mobile)->firstOrFail();

        if (!$user->isValidResetCode($request->code)) {
            return $this->error(__('auth.invalid_reset_code'), 422);
        }

        $token = $this->generateResetToken($user->mobile);

        return $this->success(
            ['token' => $token],
            __('auth.code_verified_successfully')
        );
    }

    /**
     * Reset password with token
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $mobile = Cache::get("reset_token:{$request->token}");

        if (!$mobile) {
            return $this->error(__('auth.invalid_or_expired_token'), 422);
        }

        $user = User::where('mobile', $mobile)->firstOrFail();

        $user->resetPassword($request->password);
        Cache::forget("reset_token:{$request->token}");

        return $this->success([], __('auth.password_reset_success'));
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        
        return $this->success([], __('auth.logout_success'));
    }

    /**
     * Delete user account
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->tokens()->delete();
        $user->delete();

        return $this->success([], __('auth.account_deleted_successfully'));
    }

 
    /**
     * Create a new user
     */
    private function createUser(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Get user data with authentication token
     */
    private function getUserDataWithToken(User $user): array
    {
        $token = $user->createToken('API Token')->plainTextToken;
        $userData = (new UserResource($user))->resolve();
        $userData['token'] = $token;

        return $userData;
    }

    /**
     * Send verification SMS to user
     */
    private function sendVerificationSms(User $user): void
    {
        try {
            $this->smsService->sendVerificationCode($user);
        } catch (\Exception $e) {
            Log::error('Failed to send verification SMS', [
                'user_id' => $user->id,
                'mobile' => $user->mobile,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send reset code SMS to user
     */
    private function sendResetCodeSms(User $user): void
    {
        try {
            $this->smsService->sendResetCode($user);
        } catch (\Exception $e) {
            Log::error('Failed to send reset code SMS', [
                'user_id' => $user->id,
                'mobile' => $user->mobile,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Generate and cache reset token
     */
    private function generateResetToken(string $mobile): string
    {
        $token = Str::random(60);
        Cache::put("reset_token:{$token}", $mobile, now()->addDay(15));

        return $token;
    }
}