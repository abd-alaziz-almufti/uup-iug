<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ProfileEditRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfileEditRequestPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ProfileEditRequest');
    }

    public function view(AuthUser $authUser, ProfileEditRequest $profileEditRequest): bool
    {
        return $authUser->can('View:ProfileEditRequest');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ProfileEditRequest');
    }

    public function update(AuthUser $authUser, ProfileEditRequest $profileEditRequest): bool
    {
        return $authUser->can('Update:ProfileEditRequest');
    }

    public function delete(AuthUser $authUser, ProfileEditRequest $profileEditRequest): bool
    {
        return $authUser->can('Delete:ProfileEditRequest');
    }

    public function restore(AuthUser $authUser, ProfileEditRequest $profileEditRequest): bool
    {
        return $authUser->can('Restore:ProfileEditRequest');
    }

    public function forceDelete(AuthUser $authUser, ProfileEditRequest $profileEditRequest): bool
    {
        return $authUser->can('ForceDelete:ProfileEditRequest');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ProfileEditRequest');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ProfileEditRequest');
    }

    public function replicate(AuthUser $authUser, ProfileEditRequest $profileEditRequest): bool
    {
        return $authUser->can('Replicate:ProfileEditRequest');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ProfileEditRequest');
    }

}