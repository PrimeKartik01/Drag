<?php

namespace App\Policies;

use App\Services\PermissionService;

class PermissionPolicy
{
    public function __construct(private PermissionService $permission)
    {
    }

    public function viewAny($user, string $table): bool
    {
        return $this->permission->check($user, 'read', $table);
    }

    public function view($user, string $table): bool
    {
        return $this->permission->check($user, 'read', $table);
    }

    public function create($user, string $table): bool
    {
        
        return $this->permission->check($user, 'create', $table);
    }

    public function update($user, string $table): bool
    {
        return $this->permission->check($user, 'update', $table);
    }

    public function delete($user, string $table): bool
    {
        return $this->permission->check($user, 'delete', $table);
    }
}
