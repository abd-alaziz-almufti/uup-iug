<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\FAQ;
use Illuminate\Auth\Access\HandlesAuthorization;

class FAQPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:FAQ');
    }

    public function view(AuthUser $authUser, FAQ $fAQ): bool
    {
        if (!$authUser->can('View:FAQ')) {
            return false;
        }

        if ($authUser->hasRole(['Super Admin', 'super_admin', 'Content Manager', 'Support Agent'])) {
            return true;
        }

        // Check if FAQ is related to the user's department or course
        if ($authUser->hasRole('Academic Supervisor')) {
            return $fAQ->course && $fAQ->course->department_id === $authUser->department_id;
        }

        if ($authUser->hasRole('Instructor')) {
            return $fAQ->course_id && \App\Models\Course::where('id', $fAQ->course_id)
                ->where('department_id', $authUser->department_id)->exists();
        }

        return false;
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:FAQ');
    }

    public function update(AuthUser $authUser, FAQ $fAQ): bool
    {
        if (!$authUser->can('Update:FAQ')) {
            return false;
        }

        if ($authUser->hasRole(['Super Admin', 'super_admin', 'Content Manager'])) {
            return true;
        }

        return $this->view($authUser, $fAQ);
    }

    public function delete(AuthUser $authUser, FAQ $fAQ): bool
    {
        if (!$authUser->can('Delete:FAQ')) {
            return false;
        }

        return $authUser->hasRole(['Super Admin', 'super_admin', 'Content Manager']);
    }

    public function restore(AuthUser $authUser, FAQ $fAQ): bool
    {
        return $authUser->can('Restore:FAQ');
    }

    public function forceDelete(AuthUser $authUser, FAQ $fAQ): bool
    {
        return $authUser->can('ForceDelete:FAQ');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:FAQ');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:FAQ');
    }

    public function replicate(AuthUser $authUser, FAQ $fAQ): bool
    {
        return $authUser->can('Replicate:FAQ');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:FAQ');
    }

}