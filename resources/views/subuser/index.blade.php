@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">

                <div>
                    <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-1">Users Management</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">Sub User
                        Directory</h1>
                    <p class="mt-1.5 text-sm text-gray-500">Manage all sub users of your real estate system</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-900 hover:text-white transition-all">
                        <x-icons.arrow-left class="w-4 h-4" />
                        <span class="hidden sm:inline">Dashboard</span>
                    </a>

                    <a href="{{ route('subuser.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
                        <x-icons.plus class="w-4 h-4" />
                        <span class="hidden sm:inline">Add Sub User</span>
                    </a>
                </div>

            </div>


            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-5 py-4 mb-5">

                <div class="flex flex-col sm:flex-row justify-between gap-4">

                    <form method="GET" action="{{ route('subuser.index') }}" class="flex gap-3">

                        <div class="relative">
                            <x-icons.search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search name or email"
                                class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>

                        <button class="px-5 py-2.5 bg-gray-900 text-white text-sm rounded-xl">
                            Search
                        </button>

                    </form>


                    <div class="text-sm text-gray-500">
                        Total: <span class="font-semibold text-gray-900">{{ $subusers->total() }}</span> Users
                    </div>

                </div>

            </div>



            <div class="hidden sm:block bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>
                            <tr class="bg-gray-900">
                                <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">#</th>
                                <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">User</th>
                                <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Phone</th>
                                <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Designation</th>
                                <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Role</th>
                                <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">Status</th>
                                <th class="px-5 py-3.5 text-right text-xs font-bold text-gray-400 uppercase">Actions</th>
                            </tr>
                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @forelse($subusers as $user)
                                <tr class="hover:bg-indigo-50/40">

                                    <td class="px-5 py-3.5 text-xs text-gray-400">{{ $loop->iteration }}</td>

                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center">
                                                <span
                                                    class="text-xs font-bold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3.5 text-sm text-gray-500">{{ $user->phone }}</td>

                                    <td class="px-4 py-3.5">
                                        <span
                                            class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-semibold">
                                            {{ $user->designation }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3.5 text-sm text-gray-600">{{ ucfirst($user->role) }}</td>

                                    <td class="px-4 py-3.5">
                                        @if ($user->status == 'active')
                                            <span
                                                class="px-2.5 py-1 rounded-lg bg-green-50 text-green-700 text-xs font-semibold">Active</span>
                                        @else
                                            <span
                                                class="px-2.5 py-1 rounded-lg bg-red-50 text-red-600 text-xs font-semibold">Inactive</span>
                                        @endif
                                    </td>


                                    <td class="px-5 py-3.5">
                                        <div class="flex justify-end gap-2">

                                            {{-- <a href="{{ route('subuser.edit', $user->id) }}"
                                                class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-xs">
                                                <x-icons.edit class="w-3.5 h-3.5" /> Edit
                                            </a> --}}

                                            {{-- <form action="{{ route('subuser.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Delete {{ $user->name }}?')"
                                                    class="px-3 py-1.5 rounded-lg bg-red-50 text-red-500 text-xs">
                                                    <x-icons.trash class="w-3.5 h-3.5" /> Delete
                                                </button>
                                            </form> --}}

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center py-20 text-gray-400">
                                        No sub users found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            @if ($subusers->hasPages())
                <div class="mt-6 flex justify-end">
                    {{ $subusers->links() }}
                </div>
            @endif


        </div>
    </div>
@endsection
