<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white text-center leading-tight">
            {{ __('Manage Leave Requests') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="max-w-3xl mx-auto mt-6 px-4 py-3 rounded-lg bg-green-600 text-white text-center shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
            @php
                $summary = [
                    ['title' => 'Pending Requests', 'count' => $leaveRequests->where('status', 'pending')->count(), 'color' => 'yellow'],
                    ['title' => 'Approved Requests', 'count' => $leaveRequests->where('status', 'approved')->count(), 'color' => 'green'],
                    ['title' => 'Rejected Requests', 'count' => $leaveRequests->where('status', 'rejected')->count(), 'color' => 'red'],
                    ['title' => 'Total Requests', 'count' => $leaveRequests->count(), 'color' => 'blue'],
                ];
            @endphp

            @foreach($summary as $item)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5 text-center">
                    <h3 class="text-gray-700 dark:text-white font-medium text-lg">{{ $item['title'] }}</h3>
                    <p class="dark:text-white text-3xl font-bold text-{{ $item['color'] }}-500 mt-2">{{ $item['count'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Unified Leave Requests Table -->
    <div class="max-w-7xl mx-auto px-4 mb-10">
        <div class="bg-white dark:bg-gray-900 shadow rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 text-center">All Leave Requests</h3>

            @if($leaveRequests->isEmpty())
                <div class="text-center text-gray-500 dark:text-gray-400">No Leave Requests Available.</div>
            @else
                <div class="overflow-auto">
                    <table class="w-full table-auto border-collapse text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-center">#</th>
                            <th class="px-4 py-2 text-left">Request By</th>
                            <th class="px-4 py-2 text-left">Leave Type</th>
                            <th class="px-4 py-2 text-left">From</th>
                            <th class="px-4 py-2 text-left">To</th>
                            <th class="px-4 py-2 text-left">Duration</th>
                            <th class="px-4 py-2 text-left">Reason</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leaveRequests as $request)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 dark:text-white">
                                <td class="px-4 py-2 text-center">
                                    {{ ($leaveRequests->currentPage() - 1) * $leaveRequests->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-2">{{ $request->user->name }}</td>
                                <td class="px-4 py-2">{{ $request->leaveType->name }}</td>
                                <td class="px-4 py-2">{{ $request->start_date }}</td>
                                <td class="px-4 py-2">{{ $request->end_date }}</td>
                                <td class="px-4 py-2">
                                    {{ intval(\Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date))) }} days
                                </td>
                                <td class="px-4 py-2">{{ $request->reason }}</td>
                                <td class="px-4 py-2 text-center">
                                    <span class="inline-block px-3 py-1 text-white rounded-full
                                        @if($request->status === 'approved') bg-green-600
                                        @elseif($request->status === 'rejected') bg-red-600
                                        @else bg-yellow-500 @endif">
                                        {{ $request->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    @if($request->status === 'pending')
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('admin.leave-approve', $request->id) }}"
                                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                                                Approve
                                            </a>
                                            <a href="{{ route('admin.leave-reject', $request->id) }}"
                                               class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                                Reject
                                            </a>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $leaveRequests->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
