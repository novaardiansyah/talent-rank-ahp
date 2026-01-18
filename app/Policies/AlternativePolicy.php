<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Alternative;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlternativePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Alternative');
    }

    public function view(AuthUser $authUser, Alternative $alternative): bool
    {
        return $authUser->can('View:Alternative');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Alternative');
    }

    public function update(AuthUser $authUser, Alternative $alternative): bool
    {
        return $authUser->can('Update:Alternative');
    }

    public function delete(AuthUser $authUser, Alternative $alternative): bool
    {
        return $authUser->can('Delete:Alternative');
    }

    public function restore(AuthUser $authUser, Alternative $alternative): bool
    {
        return $authUser->can('Restore:Alternative');
    }

    public function forceDelete(AuthUser $authUser, Alternative $alternative): bool
    {
        return $authUser->can('ForceDelete:Alternative');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Alternative');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Alternative');
    }

    public function replicate(AuthUser $authUser, Alternative $alternative): bool
    {
        return $authUser->can('Replicate:Alternative');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Alternative');
    }

}