<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('Create Leave Request') }}
        </h2>
    </x-slot>


    @if(session('error'))
        <div class="max-w-4xl mx-auto mt-6">
            <div class="bg-red-200 text-red-800 dark:bg-red-600 dark:text-red-200 border border-red-400 px-4 py-3 rounded-lg shadow-md" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block">{{ session('error') }}</span>
            </div>
        </div>
    @endif


    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900 dark:text-white">
                    <form action="{{ route('leave-request.store') }}" method="POST">
                        @csrf

                        <!-- Leave Type -->
                        <div class="mb-6">
                            <label for="leave_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Leave Type</label>
                            <select id="leave_type_id" name="leave_type_id" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Select Leave Type</option>
                                @foreach($leaveTypes as $leaveType)
                                    <option value="{{ $leaveType->id }}">{{ $leaveType->name }}</option>
                                @endforeach
                            </select>
                            @error('leave_type_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- date From -->
                        <div class="mb-6">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date From</label>
                            <input type="date" name="start_date" id="start_date" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- date To -->
                        <div class="mb-6">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date To</label>
                            <input type="date" name="end_date" id="end_date" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reason -->
                        <div class="mb-6">
                            <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason</label>
                            <textarea id="reason" name="reason" rows="4" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                            @error('reason')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-800">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
