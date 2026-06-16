<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SuccessNumber;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuccessNumberPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SuccessNumber');
    }

    public function view(AuthUser $authUser, SuccessNumber $successNumber): bool
    {
        return $authUser->can('View:SuccessNumber');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SuccessNumber');
    }

    public function update(AuthUser $authUser, SuccessNumber $successNumber): bool
    {
        return $authUser->can('Update:SuccessNumber');
    }

    public function delete(AuthUser $authUser, SuccessNumber $successNumber): bool
    {
        return $authUser->can('Delete:SuccessNumber');
    }

    public function restore(AuthUser $authUser, SuccessNumber $successNumber): bool
    {
        return $authUser->can('Restore:SuccessNumber');
    }

    public function forceDelete(AuthUser $authUser, SuccessNumber $successNumber): bool
    {
        return $authUser->can('ForceDelete:SuccessNumber');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SuccessNumber');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SuccessNumber');
    }

    public function replicate(AuthUser $authUser, SuccessNumber $successNumber): bool
    {
        return $authUser->can('Replicate:SuccessNumber');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SuccessNumber');
    }

}