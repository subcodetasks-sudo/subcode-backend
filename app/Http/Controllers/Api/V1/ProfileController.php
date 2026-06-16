<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ApiResponse;

    /**
     * Get authenticated user profile
     */
    public function show(Request $request): JsonResponse
    {
        return $this->success(
            new UserResource($request->user()),
            __('profile.profile_retrieved_successfully')
        );
    }

    /**
     * Update authenticated user profile
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        
        $data = $request->validated();

        if (isset($data['mobile']) && $data['mobile'] !== $user->mobile) {
            $user->update([
                'mobile' => $data['mobile'],
                'mobile_verified_at' => null, 
            ]);
            
            $user->regenerateVerificationCode();
            app(\App\Services\SmsService::class)->sendVerificationCode($user);
            
            return $this->success(
                new UserResource($user),
                __('profile.mobile_changed_verify_required')
            );
        }

        $user->update($data);

        return $this->success(
            new UserResource($user),
            __('profile.profile_updated_successfully')
        );
    }

    /**
     * Change user password
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->error(__('profile.current_password_incorrect'), 422);
        }

        $user->changePassword($request->new_password);

        if ($request->input('logout_other_devices', false)) {
            $user->tokens()->where('id', '!=', $user->currentAccessToken()->id)->delete();
        }

        return $this->success(
            [],
            __('profile.password_changed_successfully')
        );
    }
}