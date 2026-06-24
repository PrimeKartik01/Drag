@extends('layouts.admin')

@section('title', 'Edit Role')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
        <x-icons.user class="w-4 h-4" stroke-width="2" />
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <a href="{{ route('role.index') }}" class="hover:text-indigo-600 transition-colors">Roles</a>
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <span class="text-gray-900">Edit</span>
    </div>
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Edit Role: {{ $role->name }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Update role details and adjust permissions.
                    </p>
                </div>
                <a href="{{ route('role.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 flex items-center gap-1.5">
                     <x-icons.arrow-left class="w-4 h-4" />
                    Back to List
                </a>
            </div>


            {{-- Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">

                <form action="{{ route('role.update', $role->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Role Name --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Role Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $role->name) }}" placeholder="e.g. Admin"
                                class="w-full border {{ $errors->has('name') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-200' }} rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white shadow-sm transition-all">
                            @error('name')
                                <p class="text-red-600 text-xs mt-1 flex items-center gap-1">
                                    <x-icons.error class="w-3 h-3" />
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Description
                        </label>
                        <textarea name="description" rows="3" placeholder="Describe what this role is for..."
                            class="w-full border {{ $errors->has('description') ? 'border-red-500 ring-1 ring-red-500' : 'border-gray-200' }} rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white shadow-sm transition-all">{{ old('description', $role->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-xs mt-1 flex items-center gap-1">
                                <x-icons.error class="w-3 h-3" />
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Permissions --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Permission Matrix
                        </label>

                        <div class="bg-gray-50 border border-gray-200 rounded-2xl overflow-x-auto">
                            @php
                                $permissionMap = $permissions->keyBy('slug');
                                $actions = [
                                    'View' => 'read',
                                    'Create' => 'create',
                                    'Edit' => 'update',
                                    'Delete' => 'delete',
                                ];
                            @endphp

                            <table class="w-full text-sm">
                                <thead class="bg-gray-900 text-gray-400 uppercase text-xs">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Module</th>
                                        @foreach ($actions as $label => $slug)
                                            <th class="px-4 py-3 text-center">{{ $label }}</th>
                                        @endforeach
                                        <th class="px-4 py-3 text-center">Full Access</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y">
                                    @foreach ($tableNames as $table)
                                        @php
                                            $selected = old('permissions.' . $table, $selectedPermissions[$table] ?? []);
                                        @endphp
                                        <tr class="hover:bg-indigo-50/40 transition">
                                            <td class="px-4 py-3 font-semibold text-gray-900">
                                                {{ ucfirst($table) }}
                                            </td>

                                            @foreach ($actions as $slug)
                                                <td class="px-4 py-3 text-center">
                                                    @if (isset($permissionMap[$slug]))
                                                        <input type="checkbox"
                                                            name="permissions[{{ $table }}][]"
                                                            value="{{ $permissionMap[$slug]->id }}"
                                                            class="perm-checkbox w-4 h-4 text-indigo-600 rounded"
                                                            {{ in_array($permissionMap[$slug]->id, $selected) ? 'checked' : '' }}
                                                            onchange="syncRow(this)">
                                                    @else
                                                        <span class="text-gray-300">—</span>
                                                    @endif
                                                </td>
                                            @endforeach

                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox"
                                                    class="row-checkbox w-4 h-4 text-indigo-600"
                                                    onclick="toggleRow(this)">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @error('permissions')
                            <p class="text-red-600 text-xs mt-2 flex items-center gap-1">
                                <x-icons.error class="w-3 h-3" />
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white py-3 rounded-xl text-sm font-bold hover:from-indigo-700 hover:to-indigo-800 transition shadow-indigo-200 shadow-lg">
                            Update Role
                        </button>
                        
                        <a href="{{ route('role.index') }}"
                           class="px-8 py-3 border border-gray-200 text-gray-500 rounded-xl text-sm font-bold hover:bg-gray-50 transition text-center uppercase tracking-wider">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Full row select
        function toggleRow(el) {
            let row = el.closest('tr');
            let checkboxes = row.querySelectorAll('.perm-checkbox');
            checkboxes.forEach(cb => cb.checked = el.checked);
        }

        // Individual → sync row checkbox
        function syncRow(el) {
            let row = el.closest('tr');
            let all = row.querySelectorAll('.perm-checkbox');
            let checked = row.querySelectorAll('.perm-checkbox:checked');
            let rowCheckbox = row.querySelector('.row-checkbox');

            if (rowCheckbox) {
                rowCheckbox.checked = (all.length > 0 && all.length === checked.length);
            }
        }

        // Initialize state on load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.row-checkbox').forEach(rowCheckbox => {
                let row = rowCheckbox.closest('tr');
                let all = row.querySelectorAll('.perm-checkbox');
                let checked = row.querySelectorAll('.perm-checkbox:checked');
                rowCheckbox.checked = (all.length > 0 && all.length === checked.length);
            });
        });
    </script>
@endsection
