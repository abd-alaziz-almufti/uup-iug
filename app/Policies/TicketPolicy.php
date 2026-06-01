<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Ticket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Ticket');
    }

    public function view(AuthUser $authUser, Ticket $ticket): bool
    {
        if (!$authUser->can('View:Ticket')) {
            return false;
        }

        if ($authUser->hasRole(['Super Admin', 'super_admin'])) {
            return true;
        }

        // Dean check
        if ($authUser->hasRole('Dean')) {
            return $ticket->target_type === 'dean' && $ticket->department_id === $authUser->department_id;
        }

        // Academic Supervisor check
        if ($authUser->hasRole('Academic Supervisor')) {
            return $ticket->department_id === $authUser->department_id;
        }

        // Instructor check
        if ($authUser->hasRole('Instructor')) {
            return $ticket->target_type === 'instructor' && 
                   ($ticket->assigned_to === $authUser->id || $ticket->assigned_to === null);
        }

        // Admission Officer check
        if ($authUser->hasRole('Admission Officer')) {
            return $ticket->target_type === 'admission';
        }

        // Support Agent check
        if ($authUser->hasRole('Support Agent')) {
            return $ticket->assigned_to === $authUser->id || 
                   ($ticket->assigned_to === null && $ticket->department_id === $authUser->department_id);
        }

        // Student check
        if ($authUser->hasRole('Student')) {
            return $ticket->student_id === $authUser->id;
        }

        return false;
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Ticket');
    }

    public function update(AuthUser $authUser, Ticket $ticket): bool
    {
        if (!$authUser->can('Update:Ticket')) {
            return false;
        }

        // Same logic as view for simplicity in this context, or stricter if needed
        return $this->view($authUser, $ticket);
    }

    public function delete(AuthUser $authUser, Ticket $ticket): bool
    {
        return $authUser->hasRole(['Super Admin', 'super_admin']);
    }

    public function restore(AuthUser $authUser, Ticket $ticket): bool
    {
        return $authUser->hasRole(['Super Admin', 'super_admin']);
    }

    public function forceDelete(AuthUser $authUser, Ticket $ticket): bool
    {
        return $authUser->hasRole(['Super Admin', 'super_admin']);
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Ticket');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Ticket');
    }

    public function replicate(AuthUser $authUser, Ticket $ticket): bool
    {
        return $authUser->can('Replicate:Ticket');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Ticket');
    }

}