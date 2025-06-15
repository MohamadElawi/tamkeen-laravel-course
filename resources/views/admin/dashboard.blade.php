<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Admin Management Card -->
                        <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900">
                                        <svg class="h-8 w-8 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Admin Management</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Manage administrators and their roles</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('manage.admins') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md transition-colors">
                                        Manage Administrators
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Other Dashboard Cards -->
                        <!-- Add your other dashboard cards here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 