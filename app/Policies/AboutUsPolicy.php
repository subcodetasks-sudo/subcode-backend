<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AboutUs;
use Illuminate\Auth\Access\HandlesAuthorization;

class AboutUsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AboutUs');
    }

    public function view(AuthUser $authUser, AboutUs $aboutUs): bool
    {
        return $authUser->can('View:AboutUs');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AboutUs');
    }

    public function update(AuthUser $authUser, AboutUs $aboutUs): bool
    {
        return $authUser->can('Update:AboutUs');
    }

    public function delete(AuthUser $authUser, AboutUs $aboutUs): bool
    {
        return $authUser->can('Delete:AboutUs');
    }

    public function restore(AuthUser $authUser, AboutUs $aboutUs): bool
    {
        return $authUser->can('Restore:AboutUs');
    }

    public function forceDelete(AuthUser $authUser, AboutUs $aboutUs): bool
    {
        return $authUser->can('ForceDelete:AboutUs');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AboutUs');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AboutUs');
    }

    public function replicate(AuthUser $authUser, AboutUs $aboutUs): bool
    {
        return $authUser->can('Replicate:AboutUs');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AboutUs');
    }

}