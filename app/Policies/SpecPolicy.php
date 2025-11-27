<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Spec;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Spec');
    }

    public function view(AuthUser $authUser, Spec $spec): bool
    {
        return $authUser->can('View:Spec');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Spec');
    }

    public function update(AuthUser $authUser, Spec $spec): bool
    {
        return $authUser->can('Update:Spec');
    }

    public function delete(AuthUser $authUser, Spec $spec): bool
    {
        return $authUser->can('Delete:Spec');
    }

    public function restore(AuthUser $authUser, Spec $spec): bool
    {
        return $authUser->can('Restore:Spec');
    }

    public function forceDelete(AuthUser $authUser, Spec $spec): bool
    {
        return $authUser->can('ForceDelete:Spec');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Spec');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Spec');
    }

    public function replicate(AuthUser $authUser, Spec $spec): bool
    {
        return $authUser->can('Replicate:Spec');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Spec');
    }

}