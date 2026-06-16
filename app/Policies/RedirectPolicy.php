<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Redirect;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class RedirectPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $this->canManage($authUser, 'ViewAny');
    }

    public function view(AuthUser $authUser, Redirect $redirect): bool
    {
        return $this->canManage($authUser, 'View');
    }

    public function create(AuthUser $authUser): bool
    {
        return $this->canManage($authUser, 'Create');
    }

    public function update(AuthUser $authUser, Redirect $redirect): bool
    {
        return $this->canManage($authUser, 'Update');
    }

    public function delete(AuthUser $authUser, Redirect $redirect): bool
    {
        return $this->canManage($authUser, 'Delete');
    }

    public function restore(AuthUser $authUser, Redirect $redirect): bool
    {
        return $this->canManage($authUser, 'Restore');
    }

    public function forceDelete(AuthUser $authUser, Redirect $redirect): bool
    {
        return $this->canManage($authUser, 'ForceDelete');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $this->canManage($authUser, 'ForceDeleteAny');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $this->canManage($authUser, 'RestoreAny');
    }

    public function replicate(AuthUser $authUser, Redirect $redirect): bool
    {
        return $this->canManage($authUser, 'Replicate');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $this->canManage($authUser, 'Reorder');
    }

    private function canManage(AuthUser $authUser, string $action): bool
    {
        return $authUser->can("{$action}:Redirect")
            || $authUser->can("{$action}:SeoSetting")
            || $authUser->can('View:Settings');
    }
}
