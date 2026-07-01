@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">

                <div>
                    <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-1">Real Estate Management</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                        Township Directory
                    </h1>
                    <p class="mt-1.5 text-sm text-gray-500">
                        Manage all townships under builders
                    </p>
                </div>


                <div class="flex items-center gap-3">

                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-900 hover:text-white transition-all">

                        <x-icons.arrow-left class="w-4 h-4" />

                        <span class="hidden sm:inline">Dashboard</span>

                    </a>


                    <a href="{{ route('township.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">

                        <x-icons.plus class="w-4 h-4" />

                        <span class="hidden sm:inline">Add Township</span>

                    </a>

                </div>

            </div>


            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm px-5 py-4 mb-5">


                <form method="GET" action="{{ route('township.index') }}" class="flex flex-col md:flex-row gap-3 w-full">


                    <div class="relative w-full">

                        <x-icons.search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" />

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search township name"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    </div>


                    <button class="w-full md:w-auto px-5 py-2.5 bg-gray-900 text-white text-sm rounded-xl">
                        Search
                    </button>


                    <a href="{{ route('township.index') }}"
                        class="w-full md:w-auto px-5 py-2.5 border border-gray-200 text-gray-600 text-sm rounded-xl hover:bg-gray-50 text-center">

                        Reset

                    </a>


                </form>


                <div class="mt-4 text-sm text-gray-500">

                    Total:
                    <span class="font-semibold text-gray-900">
                        {{ $townships->total() }}
                    </span>
                    Townships

                </div>


            </div>


            <div id="townshipTable" class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">


                <div class="overflow-x-auto">


                    <table class="w-full whitespace-nowrap">


                        <thead>

                            <tr class="bg-gray-900">

                                <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">#</th>

                                <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">
                                    Township
                                </th>

                                <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">
                                    Builder
                                </th>

                                <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">
                                    Location
                                </th>

                                <th class="px-4 py-3.5 text-left text-xs font-bold text-gray-400 uppercase">
                                    Status
                                </th>

                                <th class="px-5 py-3.5 text-right text-xs font-bold text-gray-400 uppercase">
                                    Actions
                                </th>


                            </tr>


                        </thead>


                        <tbody class="divide-y divide-gray-100">


                            @forelse($townships as $township)
                                <tr class="hover:bg-indigo-50/40">


                                    <td class="px-5 py-3.5 text-xs text-gray-400">
                                        {{ $loop->iteration }}
                                    </td>


                                    <td class="px-4 py-3.5">

                                        <div class="flex items-center gap-3">

                                            <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center">

                                                <span class="text-xs font-bold text-white">
                                                    {{ strtoupper(substr($township->name, 0, 2)) }}
                                                </span>

                                            </div>


                                            <div>

                                                <p class="text-sm font-semibold text-gray-900">
                                                    {{ $township->name }}
                                                </p>

                                                <p class="text-xs text-gray-400">
                                                    {{ $township->slug }}
                                                </p>

                                            </div>


                                        </div>


                                    </td>


                                    <td class="px-4 py-3.5 text-sm text-gray-600">

                                        {{ $township->builder->name ?? 'No Builder' }}

                                    </td>


                                    <td class="px-4 py-3.5 text-sm text-gray-500">

                                        {{ $township->location }}

                                    </td>


                                    <td class="px-4 py-3.5">

                                        @if ($township->status)
                                            <span class="px-2.5 py-1 rounded-full text-xs bg-emerald-50 text-emerald-700">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs bg-gray-100 text-gray-500">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    


                                    <td class="px-5 py-3.5">

                                        <div class="flex justify-end gap-2">


                                            <a href="{{ route('township.edit', $township->id) }}"
                                                class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-600 text-xs">

                                                <x-icons.edit class="w-3.5 h-3.5" />

                                            </a>


                                            <form action="{{ route('township.delete', $township->id) }}" method="POST">

                                                @csrf
                                                @method('DELETE')


                                                <button onclick="return confirm('Delete {{ $township->name }}?')"
                                                    class="px-3 py-1.5 rounded-lg bg-red-50 text-red-500 text-xs">

                                                    <x-icons.trash class="w-3.5 h-3.5" />

                                                </button>


                                            </form>


                                        </div>


                                    </td>


                                </tr>


                            @empty

                                <tr>

                                    <td colspan="6" class="text-center py-20 text-gray-400">

                                        No townships found

                                    </td>

                                </tr>
                            @endforelse


                        </tbody>


                    </table>


                </div>


            </div>


            @if ($townships->hasPages())
                <div class="mt-6 flex justify-end">

                    {{ $townships->links() }}

                </div>
            @endif


        </div>

    </div>
@endsection
