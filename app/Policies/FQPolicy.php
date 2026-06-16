<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\FQ;
use Illuminate\Auth\Access\HandlesAuthorization;

class FQPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FQ');
    }

    public function view(AuthUser $authUser, FQ $fQ): bool
    {
        return $authUser->can('View:FQ');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FQ');
    }

    public function update(AuthUser $authUser, FQ $fQ): bool
    {
        return $authUser->can('Update:FQ');
    }

    public function delete(AuthUser $authUser, FQ $fQ): bool
    {
        return $authUser->can('Delete:FQ');
    }

    public function restore(AuthUser $authUser, FQ $fQ): bool
    {
        return $authUser->can('Restore:FQ');
    }

    public function forceDelete(AuthUser $authUser, FQ $fQ): bool
    {
        return $authUser->can('ForceDelete:FQ');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FQ');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FQ');
    }

    public function replicate(AuthUser $authUser, FQ $fQ): bool
    {
        return $authUser->can('Replicate:FQ');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FQ');
    }

}