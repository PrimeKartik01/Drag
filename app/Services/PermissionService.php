<?php

namespace App\Services;

use App\Models\User;
use App\Models\SubUser;

class PermissionService
{
    public function check($user, string $action, string $table): bool
    {
        // Admin - full access
        if ($user instanceof User) {
            return true;
        }

        // SubUser (Role based)
        if ($user instanceof SubUser) {

            if (!$user->role) {
                return false;
            }

            return $user->role->permissions()
                ->where('slug', $action)
                ->get()
                ->contains(function ($permission) use ($table) {
                    $tables = array_filter(array_map('trim', explode(',', $permission->pivot->table_name ?? '')));
                    return in_array($table, $tables, true);
                });
        }

        return false;
    }
}