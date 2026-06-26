@extends('layouts.admin')

@section('title', 'Builders')

@section('content')

    <div class="min-h-screen bg-gray-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- HEADER -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">

                <div>
                    <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-1">Builder Management</p>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Builder Directory</h1>
                    <p class="mt-1.5 text-sm text-gray-500">Manage all builders of your real estate system</p>
                </div>

                <div class="flex items-center gap-3">

                    <!-- BULK DELETE BUTTON -->
                    <button form="bulkDeleteForm" onclick="return confirm('Are you sure want to delete selected builders?')"
                        class="px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm hover:bg-red-700">

                        Delete Selected
                    </button>

                    <a href="{{ route('builder.create') }}"
                        class="px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm hover:bg-indigo-700">
                        Add Builder
                    </a>

                </div>

            </div>

            <!-- FORM START (BULK DELETE) -->
            <form action="{{ route('builder.bulkDelete') }}" method="POST" id="bulkDeleteForm">
                @csrf
                @method('DELETE')

                <!-- TABLE -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                    <div class="overflow-x-auto">

                        <table class="w-full whitespace-nowrap">

                            <thead>
                                <tr class="bg-gray-900 text-gray-400 text-xs uppercase">

                                    <th class="px-5 py-3.5">
                                        <input type="checkbox" id="selectAll">
                                    </th>

                                    <th class="px-4 py-3.5 text-left">Builder</th>
                                    <th class="px-4 py-3.5 text-left">RERA No</th>
                                    <th class="px-4 py-3.5 text-left">Created</th>
                                    <th class="px-5 py-3.5 text-right">Actions</th>

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100">

                                @forelse($builders as $builder)
                                    <tr class="hover:bg-indigo-50/40">

                                        <!-- CHECKBOX -->
                                        <td class="px-5 py-3.5">
                                            <input type="checkbox" name="ids[]" value="{{ $builder->id }}"
                                                class="rowCheckbox">
                                        </td>

                                        <!-- BUILDER -->
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center gap-3">

                                                @if ($builder->photo)
                                                    <img src="{{ asset('storage/' . $builder->photo) }}"
                                                        class="w-10 h-10 rounded-xl object-cover">
                                                @else
                                                    <div
                                                        class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-xs">
                                                        {{ strtoupper(substr($builder->name, 0, 2)) }}
                                                    </div>
                                                @endif

                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">
                                                        {{ $builder->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-400">
                                                        {{ $builder->slug }}
                                                    </p>
                                                </div>

                                            </div>
                                        </td>

                                        <td class="px-4 py-3.5 text-sm text-gray-500">
                                            {{ $builder->rera_no ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3.5 text-sm text-gray-500">
                                            {{ $builder->created_at->format('d M Y') }}
                                        </td>

                                        <!-- ACTIONS -->
                                        <td class="px-5 py-3.5">
                                            <div class="flex justify-end gap-2">

                                                <a href="{{ route('builder.show', $builder->id) }}"
                                                    class="px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs">View</a>

                                                <a href="{{ route('builder.edit', $builder->id) }}"
                                                    class="px-3 py-1.5 rounded-lg bg-green-50 text-green-600 text-xs">Edit</a>

                                                <form action="{{ route('builder.destroy', $builder->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button onclick="return confirm('Delete {{ $builder->name }}?')"
                                                        class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs">
                                                        Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5" class="text-center py-20 text-gray-400">
                                            No builders found
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </form>
            <!-- FORM END -->

            <!-- PAGINATION -->
            @if ($builders->hasPages())
                <div class="mt-6 flex justify-end">
                    {{ $builders->links() }}
                </div>
            @endif

        </div>

    </div>

    <!-- JS -->
    <script>
        document.getElementById('selectAll').addEventListener('click', function() {
            let checkboxes = document.querySelectorAll('.rowCheckbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>

@endsection
