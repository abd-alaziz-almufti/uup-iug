<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Announcement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Announcement');
    }

    public function view(AuthUser $authUser, Announcement $announcement): bool
    {
        if (!$authUser->can('View:Announcement')) {
            return false;
        }

        if ($authUser->hasRole(['Super Admin', 'super_admin', 'Content Manager'])) {
            return true;
        }

        return $announcement->department_id === $authUser->department_id;
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Announcement');
    }

    public function update(AuthUser $authUser, Announcement $announcement): bool
    {
        if (!$authUser->can('Update:Announcement')) {
            return false;
        }

        if ($authUser->hasRole(['Super Admin', 'super_admin', 'Content Manager'])) {
            return true;
        }

        return $announcement->department_id === $authUser->department_id;
    }

    public function delete(AuthUser $authUser, Announcement $announcement): bool
    {
        if (!$authUser->can('Delete:Announcement')) {
            return false;
        }

        if ($authUser->hasRole(['Super Admin', 'super_admin'])) {
            return true;
        }

        return $announcement->department_id === $authUser->department_id;
    }

    public function restore(AuthUser $authUser, Announcement $announcement): bool
    {
        return $authUser->can('Restore:Announcement');
    }

    public function forceDelete(AuthUser $authUser, Announcement $announcement): bool
    {
        return $authUser->can('ForceDelete:Announcement');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Announcement');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Announcement');
    }

    public function replicate(AuthUser $authUser, Announcement $announcement): bool
    {
        return $authUser->can('Replicate:Announcement');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Announcement');
    }

}