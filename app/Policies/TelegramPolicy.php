<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Telegram;
use Illuminate\Auth\Access\HandlesAuthorization;

class TelegramPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Telegram');
    }

    public function view(AuthUser $authUser, Telegram $telegram): bool
    {
        return $authUser->can('View:Telegram');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Telegram');
    }

    public function update(AuthUser $authUser, Telegram $telegram): bool
    {
        return $authUser->can('Update:Telegram');
    }

    public function delete(AuthUser $authUser, Telegram $telegram): bool
    {
        return $authUser->can('Delete:Telegram');
    }

    public function restore(AuthUser $authUser, Telegram $telegram): bool
    {
        return $authUser->can('Restore:Telegram');
    }

    public function forceDelete(AuthUser $authUser, Telegram $telegram): bool
    {
        return $authUser->can('ForceDelete:Telegram');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Telegram');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Telegram');
    }

    public function replicate(AuthUser $authUser, Telegram $telegram): bool
    {
        return $authUser->can('Replicate:Telegram');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Telegram');
    }

}