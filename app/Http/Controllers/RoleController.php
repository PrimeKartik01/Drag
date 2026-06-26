<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

// Model
use App\Models\Role;
use App\Models\Permission;

// Request
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;

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
        try {
            $permissions = Permission::select('id', 'name', 'slug')->orderBy('name')->get();
            $tableNames = config('table_access.tables');

            return view('role.create', compact('permissions', 'tableNames'));
        } catch (Exception $e) {
            Log::error('Role Create Function Failed' . $e->getMessage());
            Session::flash('error', 'Role Create Failed');

            return redirect()->route('role.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        try {
            $input = $request->validated();
            $role = Role::create([
                'name' => $input['name'],
                'description' => $input['description'] ?? null,
            ]);
            $this->syncRolePermissions($role, $input['permissions'] ?? []);
            Session::flash('success', 'Role created Successfully');
        } catch (Exception $e) {
            Log::error('Role Store Function Failed' . $e->getMessage());
            Session::flash('error', 'Role Create Failed');
        }

        return redirect()->route('role.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        try {
            $permissions = Permission::select('id', 'name', 'slug')->orderBy('name')->get();
            $tableNames = config('table_access.tables');
            $selectedPermissions = [];
            foreach ($role->permissions as $permission) {
                foreach (explode(',', $permission->pivot->table_name) as $table) {
                    $table = trim($table);

                    if ($table) {
                        $selectedPermissions[$table][] = $permission->id;
                    }
                }
            }

            return view('role.edit', compact('role', 'permissions', 'tableNames', 'selectedPermissions'));
        } catch (Exception $e) {
            Log::error('Role Edit Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Role Edit Failed');

            return redirect()->route('role.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        try {
            $input = $request->validated();
            $role->update([
                'name' => $input['name'],
                'description' => $input['description'] ?? null,
            ]);
            $this->syncRolePermissions($role, $input['permissions'] ?? []);
            Session::flash('success', 'Role Updated Successfully');
        } catch (Exception $e) {
            Log::error('Role Update Function Failed: ' . $e->getMessage());
            Session::flash('error', 'Role Updation Failed');
        }

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Role $role)
    {
        try {
            $role->delete();
            Session::flash('success', 'Role Delete Successfully');
        } catch (Exception $e) {
            Log::error('Role Delete Function Failed' . $e->getMessage());
            Session::flash('error', 'Role Deletion Failed');
        }

        return redirect()->route('role.index');
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
