@extends('layouts.admin')

@section('title', 'Sub User Details')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
        <x-icons.users class="w-4 h-4 text-gray-400" />
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <a href="{{ route('subuser.index') }}" class="hover:text-gray-700 transition-colors">
            Sub Users
        </a>
        <x-icons.chevron-right class="w-3 h-3 text-gray-300" />
        <span class="text-gray-900">Details</span>
    </div>
@endsection

@section('content')

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto">

            <div class="flex justify-between items-end mb-6">

                <div>

                    <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-1">
                        Sub User Details
                    </p>

                    <h1 class="text-3xl font-extrabold text-gray-900">
                        {{ $subuser->name }}
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        View sub user information
                    </p>

                </div>

                <a href="{{ route('subuser.index') }}"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">

                    Back

                </a>

            </div>


            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sm:p-8">

                <div class="flex flex-col sm:flex-row gap-6 items-center sm:items-start">

                    @if ($subuser->photo)
                        <img src="{{ asset('storage/' . $subuser->photo) }}"
                            class="w-32 h-32 rounded-2xl object-cover border border-gray-200 shadow">
                    @else
                        <div class="w-32 h-32 rounded-2xl bg-indigo-600 flex items-center justify-center shadow">
                            <span class="text-3xl font-bold text-white">
                                {{ strtoupper(substr($subuser->name, 0, 2)) }}
                            </span>
                        </div>
                    @endif


                    <div class="space-y-3 text-center sm:text-left">

                        <div>

                            <h2 class="text-2xl font-bold text-gray-900">
                                {{ $subuser->name }}
                            </h2>

                            <p class="text-sm text-gray-500">
                                {{ $subuser->email }}
                            </p>

                        </div>

                        <div class="flex flex-wrap gap-2 justify-center sm:justify-start">

                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-600">

                                {{ $subuser->role?->name ?? 'No Role Assigned' }}

                            </span>

                            @if ($subuser->last_activity_at && $subuser->last_activity_at->gt(now()->subMinutes(5)))
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">

                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>

                                    Online

                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">

                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>

                                    Offline

                                </span>
                            @endif

                        </div>

                    </div>

                </div>


                <div class="border-t border-gray-100 my-8"></div>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Full Name
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $subuser->name }}
                        </p>

                    </div>


                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Email Address
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $subuser->email }}
                        </p>

                    </div>


                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Phone Number
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $subuser->phone ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Role
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $subuser->role?->name ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Status
                        </label>

                        <div class="mt-2">

                            @if ($subuser->last_activity_at && $subuser->last_activity_at->gt(now()->subMinutes(5)))
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">

                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>

                                    Online

                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">

                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>

                                    Offline

                                </span>
                            @endif

                        </div>

                    </div>

                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Special ID
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $subuser->special_id?? '-' }}
                        </p>

                    </div>


                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Created At
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $subuser->created_at->format('d M Y, h:i A') }}
                        </p>

                    </div>


                    <div>

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Last Updated
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $subuser->updated_at->format('d M Y, h:i A') }}
                        </p>

                    </div>


                    <div class="rounded-md bg-gray-100 p-2 w-max">

                        <label class="text-xs font-bold uppercase text-gray-400">
                            Last Activity
                        </label>

                        <p class="mt-1 text-sm font-semibold text-gray-900">
                            {{ $subuser->last_activity_at ? $subuser->last_activity_at->format('d M Y, h:i A') : 'Never' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
