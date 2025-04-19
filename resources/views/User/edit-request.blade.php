<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Leave Request') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('leave-request.update', $leaveRequest->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="leave_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Leave Type</label>
                            <select id="leave_type_id" name="leave_type_id" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select Leave Type</option>
                                @foreach($leaveTypes as $leaveType)
                                    <option value="{{ $leaveType->id }}"
                                        {{ $leaveRequest->leave_type_id == $leaveType->id ? 'selected' : '' }}>
                                        {{ $leaveType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('leave_type_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date From</label>
                            <input type="date" name="start_date" id="start_date" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ $leaveRequest->start_date }}">
                            @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date To</label>
                            <input type="date" name="end_date" id="end_date" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500" value="{{ $leaveRequest->end_date }}">
                            @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason</label>
                            <textarea id="reason" name="reason" rows="3" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200">{{ $leaveRequest->reason }}</textarea>
                            @error('reason')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex justify-center">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-400">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
