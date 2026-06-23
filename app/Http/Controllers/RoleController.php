<?php

namespace App\Http\Controllers;

// Model
use App\Models\Permission;
use App\Models\Role;

// Request
use Illuminate\Http\Request;

// DB
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::select('id', 'name', 'slug')->orderBy('name')->get();
        $tableNames = config('table_access.tables');

        return view('role.create', compact('permissions', 'tableNames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'array',
            'permissions.*.*' => 'exists:permissions,id',
        ]);

        $role = Role::create($request->only(['name', 'description']));

        $this->syncRolePermissions($role, $request->input('permissions', []));

        return redirect()->route('role.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::select('id', 'name', 'slug')->orderBy('name')->get();
        $tableNames = config('table_access.tables');

        $selectedPermissions = [];
        foreach ($role->permissions as $permission) {
            $tables = explode(',', $permission->pivot->table_name);
            foreach ($tables as $table) {
                $table = trim($table);
                if (! $table) {
                    continue;
                }

                $selectedPermissions[$table][] = $permission->id;
            }
        }

        return view('role.edit', compact('role', 'permissions', 'tableNames', 'selectedPermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'array',
            'permissions.*.*' => 'exists:permissions,id',
        ]);

        $role->update($request->only(['name', 'description']));

        $this->syncRolePermissions($role, $request->input('permissions', []));

        return redirect()->route('role.index')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Role $role)
    {
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role deleted successfully');
    }

    private function syncRolePermissions(Role $role, array $permissions): void
    {
        $insertData = $this->preparePermissionData($permissions, $role->id);

        DB::transaction(function () use ($role, $insertData) {
            DB::table('role_permission')
                ->where('role_id', $role->id)
                ->delete();

            if (! empty($insertData)) {
                DB::table('role_permission')->insert($insertData);
            }
        });
    }

    private function preparePermissionData(array $permissions, int $roleId): array
    {
        $now = now();
        $rows = [];

        foreach ($permissions as $table => $permissionIds) {
            if (! is_array($permissionIds)) {
                continue;
            }

            foreach (array_unique($permissionIds) as $permissionId) {
                $permissionId = (int) $permissionId;

                if ($permissionId <= 0) {
                    continue;
                }

                $rows[] = [
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                    'table_name' => $table,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        return array_values(array_unique($rows, SORT_REGULAR));
    }
}
