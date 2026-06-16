<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Occasion;
use Illuminate\Auth\Access\HandlesAuthorization;

class OccasionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Occasion');
    }

    public function view(AuthUser $authUser, Occasion $occasion): bool
    {
        return $authUser->can('View:Occasion');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Occasion');
    }

    public function update(AuthUser $authUser, Occasion $occasion): bool
    {
        return $authUser->can('Update:Occasion');
    }

    public function delete(AuthUser $authUser, Occasion $occasion): bool
    {
        return $authUser->can('Delete:Occasion');
    }

    public function restore(AuthUser $authUser, Occasion $occasion): bool
    {
        return $authUser->can('Restore:Occasion');
    }

    public function forceDelete(AuthUser $authUser, Occasion $occasion): bool
    {
        return $authUser->can('ForceDelete:Occasion');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Occasion');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Occasion');
    }

    public function replicate(AuthUser $authUser, Occasion $occasion): bool
    {
        return $authUser->can('Replicate:Occasion');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Occasion');
    }

}