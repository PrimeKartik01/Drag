@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ── Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-1">User Management</p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                    Roles & Permissions
                </h1>
                <p class="mt-1.5 text-sm text-gray-500">Manage user roles and their access levels across tables</p>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
               <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-all duration-150">
                    <x-icons.arrow-left class="w-4 h-4" />
                    <span class="hidden sm:inline">Dashboard</span>
                </a>
               
                <a href="{{ route('role.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 transition-all duration-150">
                    <x-icons.plus class="w-4 h-4" />
                    <span class="hidden sm:inline">Add Role</span>
                </a>
                
            </div>
        </div>

      

        {{-- ── Desktop Table ── --}}
        <div class="hidden sm:block bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px]">
                    <thead>
                        <tr class="bg-gray-900">
                            <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest w-12">#</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Role Name</th>
                            <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Table Access</th>
                            <th class="px-5 py-3.5 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($roles as $role)
                            <tr class="hover:bg-indigo-50/40 transition-colors duration-100">
                                <td class="px-5 py-3.5 text-xs font-medium text-gray-400">{{ $loop->iteration }}</td>

                                <td class="px-4 py-3.5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-gray-900">{{ $role->name }}</span>
                                        @if($role->description)
                                            <span class="text-xs text-gray-500 mt-0.5 line-clamp-1 truncate" title="{{ $role->description }}">{{ $role->description }}</span>
                                        @endif
                                    </div>
                                </td>

                              
                                <td class="px-4 py-3.5">
                                    @php
                                        $tables = [];
                                        foreach ($role->permissions as $perm) {
                                            $tables[] = $perm->pivot->table_name;
                                        }
                                        $tables = array_unique($tables);
                                    @endphp
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($tables as $table)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider">
                                                {{ $table }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('role.edit', $role->id) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-medium hover:bg-emerald-500 hover:text-white transition-all duration-150">
                                            <x-icons.edit class="w-3.5 h-3.5" />
                                        </a>
                                        <form action="{{ route('role.delete', $role->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Delete role {{ $role->name }}? This will affect users assigned to this role.')"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 text-red-500 text-xs font-medium hover:bg-red-500 hover:text-white transition-all duration-150 cursor-pointer border-0">
                                                <x-icons.trash class="w-3.5 h-3.5" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-20 text-center text-gray-400">
                                    No roles found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── Mobile Cards ── --}}
        <div class="sm:hidden flex flex-col gap-3">
            @forelse($roles as $role)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4">
                    <div class="flex items-center justify-between mb-2">
                         <span class="text-sm font-bold text-gray-900">{{ $role->name }}</span>
                         <span class="text-xs text-gray-400">#{{ $loop->iteration }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mb-4">{{ $role->description ?: 'No description' }}</p>
                    
                    <div class="flex flex-col gap-3">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tables</p>
                            @php
                                $tables = [];
                                foreach ($role->permissions as $perm) {
                                    $tables[] = $perm->pivot->table_name;
                                }
                                $tables = array_unique($tables);
                            @endphp
                            <div class="flex flex-wrap gap-1">
                                @foreach($tables as $table)
                                    <span class="inline-flex px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase truncate max-w-[100px]">
                                        {{ $table }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 mt-4 pt-3 border-t border-gray-100">
                        <a href="{{ route('role.edit', $role->id) }}"
                           class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 rounded-xl bg-emerald-50 text-emerald-600 text-xs font-semibold hover:bg-emerald-500 hover:text-white transition-all duration-150">
                            
                        </a>
                        <form action="{{ route('role.delete', $role->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Delete role?')"
                                    class="w-full inline-flex items-center justify-center gap-1.5 py-2 rounded-xl bg-red-50 text-red-500 text-xs font-semibold hover:bg-red-500 hover:text-white transition-all duration-150 border-0">
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-6 py-10 text-center text-gray-400 text-sm">
                    No roles found.
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection