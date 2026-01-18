<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AlternativeComparison;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlternativeComparisonPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AlternativeComparison');
    }

    public function view(AuthUser $authUser, AlternativeComparison $alternativeComparison): bool
    {
        return $authUser->can('View:AlternativeComparison');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AlternativeComparison');
    }

    public function update(AuthUser $authUser, AlternativeComparison $alternativeComparison): bool
    {
        return $authUser->can('Update:AlternativeComparison');
    }

    public function delete(AuthUser $authUser, AlternativeComparison $alternativeComparison): bool
    {
        return $authUser->can('Delete:AlternativeComparison');
    }

    public function restore(AuthUser $authUser, AlternativeComparison $alternativeComparison): bool
    {
        return $authUser->can('Restore:AlternativeComparison');
    }

    public function forceDelete(AuthUser $authUser, AlternativeComparison $alternativeComparison): bool
    {
        return $authUser->can('ForceDelete:AlternativeComparison');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AlternativeComparison');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AlternativeComparison');
    }

    public function replicate(AuthUser $authUser, AlternativeComparison $alternativeComparison): bool
    {
        return $authUser->can('Replicate:AlternativeComparison');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AlternativeComparison');
    }

}