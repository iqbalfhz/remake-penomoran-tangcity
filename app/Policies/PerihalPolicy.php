<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Perihal;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerihalPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Perihal');
    }

    public function view(AuthUser $authUser, Perihal $perihal): bool
    {
        return $authUser->can('View:Perihal');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Perihal');
    }

    public function update(AuthUser $authUser, Perihal $perihal): bool
    {
        return $authUser->can('Update:Perihal');
    }

    public function delete(AuthUser $authUser, Perihal $perihal): bool
    {
        return $authUser->can('Delete:Perihal');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Perihal');
    }

    public function restore(AuthUser $authUser, Perihal $perihal): bool
    {
        return $authUser->can('Restore:Perihal');
    }

    public function forceDelete(AuthUser $authUser, Perihal $perihal): bool
    {
        return $authUser->can('ForceDelete:Perihal');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Perihal');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Perihal');
    }

    public function replicate(AuthUser $authUser, Perihal $perihal): bool
    {
        return $authUser->can('Replicate:Perihal');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Perihal');
    }

}