<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\CriterionComparison;
use Illuminate\Auth\Access\HandlesAuthorization;

class CriterionComparisonPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:CriterionComparison');
    }

    public function view(AuthUser $authUser, CriterionComparison $criterionComparison): bool
    {
        return $authUser->can('View:CriterionComparison');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:CriterionComparison');
    }

    public function update(AuthUser $authUser, CriterionComparison $criterionComparison): bool
    {
        return $authUser->can('Update:CriterionComparison');
    }

    public function delete(AuthUser $authUser, CriterionComparison $criterionComparison): bool
    {
        return $authUser->can('Delete:CriterionComparison');
    }

    public function restore(AuthUser $authUser, CriterionComparison $criterionComparison): bool
    {
        return $authUser->can('Restore:CriterionComparison');
    }

    public function forceDelete(AuthUser $authUser, CriterionComparison $criterionComparison): bool
    {
        return $authUser->can('ForceDelete:CriterionComparison');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:CriterionComparison');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:CriterionComparison');
    }

    public function replicate(AuthUser $authUser, CriterionComparison $criterionComparison): bool
    {
        return $authUser->can('Replicate:CriterionComparison');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:CriterionComparison');
    }

}