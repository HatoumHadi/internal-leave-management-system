<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-indigo-800 dark:text-indigo-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="max-w-4xl mx-auto mt-6">
            <div class="bg-green-200 text-green-800 dark:bg-green-600 dark:text-green-200 border border-green-400 px-4 py-3 rounded-lg shadow-md" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Create Button --}}
            <div class="bg-gradient-to-r from-indigo-500 to-blue-700 rounded-lg shadow-lg">
                <a href="{{ route('leave-request.create') }}"
                   class="block p-6 text-white font-semibold text-lg text-center hover:opacity-90 transition">
                    {{ __("➕ Create a Leave Request") }}
                </a>
            </div>

            {{-- Leave Requests Table --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-indigo-700 dark:text-indigo-300 text-center mb-6">
                        {{ __('Leave Requests') }}
                    </h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left border border-gray-200 dark:border-gray-700 rounded-lg">
                            <thead class="bg-indigo-100 dark:bg-indigo-600 text-indigo-900 dark:text-indigo-100">
                            <tr>
                                <th class="px-4 py-3 text-center">#</th>
                                <th class="px-4 py-3">Leave Type</th>
                                <th class="px-4 py-3">From</th>
                                <th class="px-4 py-3">To</th>
                                <th class="px-4 py-3">Reason</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @if($leaveRequests == null || $leaveRequests->isEmpty())
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No Leave Requests found.</td>
                                </tr>
                            @else
                                @foreach($leaveRequests as $leaveRequest)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition dark:text-white">
                                        <td class="px-4 py-3 text-center">
                                            {{ ($leaveRequests->currentPage()-1) * $leaveRequests->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3">{{ $leaveRequest->leaveType->name }}</td>
                                        <td class="px-4 py-3">{{ $leaveRequest->start_date }}</td>
                                        <td class="px-4 py-3">{{ $leaveRequest->end_date }}</td>
                                        <td class="px-4 py-3">{{ $leaveRequest->reason }}</td>
                                        <td class="px-4 py-3 text-center capitalize">
                                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                                    @if($leaveRequest->status === 'approved')
                                                        bg-green-200 text-green-800 dark:bg-green-600 dark:text-green-200
                                                    @elseif($leaveRequest->status === 'rejected')
                                                        bg-red-200 text-red-800 dark:bg-red-600 dark:text-red-200
                                                    @else
                                                        bg-yellow-200 text-yellow-800 dark:bg-yellow-600 dark:text-yellow-200
                                                    @endif
                                                ">
                                                    {{ $leaveRequest->status }}
                                                </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if($leaveRequest->status === 'pending')
                                                <div class="flex justify-center space-x-2">
                                                    <a href="{{ route('leave-request.edit', $leaveRequest->id) }}"
                                                       class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg shadow">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('leave-request.destroy', $leaveRequest->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg shadow">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $leaveRequests->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
