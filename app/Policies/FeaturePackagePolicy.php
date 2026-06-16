<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\FeaturePackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeaturePackagePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FeaturePackage');
    }

    public function view(AuthUser $authUser, FeaturePackage $featurePackage): bool
    {
        return $authUser->can('View:FeaturePackage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FeaturePackage');
    }

    public function update(AuthUser $authUser, FeaturePackage $featurePackage): bool
    {
        return $authUser->can('Update:FeaturePackage');
    }

    public function delete(AuthUser $authUser, FeaturePackage $featurePackage): bool
    {
        return $authUser->can('Delete:FeaturePackage');
    }

    public function restore(AuthUser $authUser, FeaturePackage $featurePackage): bool
    {
        return $authUser->can('Restore:FeaturePackage');
    }

    public function forceDelete(AuthUser $authUser, FeaturePackage $featurePackage): bool
    {
        return $authUser->can('ForceDelete:FeaturePackage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FeaturePackage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FeaturePackage');
    }

    public function replicate(AuthUser $authUser, FeaturePackage $featurePackage): bool
    {
        return $authUser->can('Replicate:FeaturePackage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FeaturePackage');
    }

}