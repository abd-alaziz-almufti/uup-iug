<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Course');
    }

    public function view(AuthUser $authUser, Course $course): bool
    {
        if (!$authUser->can('View:Course')) {
            return false;
        }

        if ($authUser->hasRole(['Super Admin', 'super_admin', 'Academic Supervisor', 'Content Manager'])) {
            // Supervisors can see if it's their department
            if ($authUser->hasRole('Academic Supervisor')) {
                return $course->department_id === $authUser->department_id;
            }
            return true;
        }

        return false;
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Course');
    }

    public function update(AuthUser $authUser, Course $course): bool
    {
        if (!$authUser->can('Update:Course')) {
            return false;
        }

        if ($authUser->hasRole(['Super Admin', 'super_admin'])) {
            return true;
        }

        return $course->department_id === $authUser->department_id;
    }

    public function delete(AuthUser $authUser, Course $course): bool
    {
        return $authUser->hasRole(['Super Admin', 'super_admin']);
    }

    public function restore(AuthUser $authUser, Course $course): bool
    {
        return $authUser->can('Restore:Course');
    }

    public function forceDelete(AuthUser $authUser, Course $course): bool
    {
        return $authUser->can('ForceDelete:Course');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Course');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Course');
    }

    public function replicate(AuthUser $authUser, Course $course): bool
    {
        return $authUser->can('Replicate:Course');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Course');
    }

}