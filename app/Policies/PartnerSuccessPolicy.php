<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PartnerSuccess;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerSuccessPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PartnerSuccess');
    }

    public function view(AuthUser $authUser, PartnerSuccess $partnerSuccess): bool
    {
        return $authUser->can('View:PartnerSuccess');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PartnerSuccess');
    }

    public function update(AuthUser $authUser, PartnerSuccess $partnerSuccess): bool
    {
        return $authUser->can('Update:PartnerSuccess');
    }

    public function delete(AuthUser $authUser, PartnerSuccess $partnerSuccess): bool
    {
        return $authUser->can('Delete:PartnerSuccess');
    }

    public function restore(AuthUser $authUser, PartnerSuccess $partnerSuccess): bool
    {
        return $authUser->can('Restore:PartnerSuccess');
    }

    public function forceDelete(AuthUser $authUser, PartnerSuccess $partnerSuccess): bool
    {
        return $authUser->can('ForceDelete:PartnerSuccess');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PartnerSuccess');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PartnerSuccess');
    }

    public function replicate(AuthUser $authUser, PartnerSuccess $partnerSuccess): bool
    {
        return $authUser->can('Replicate:PartnerSuccess');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PartnerSuccess');
    }

}