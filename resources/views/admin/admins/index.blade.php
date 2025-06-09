<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Management') }}
            </h2>
            <a href="{{ route('admin.manage.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-150">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                {{ __('Add New Admin') }}
            </a>
        </div>
    </x-slot>

    <div x-data="{ 
        showDeleteModal: false, 
        showStatusModal: false, 
        showResetModal: false, 
        adminToDelete: null, 
        adminToToggle: null, 
        adminToReset: null 
    }" class="space-y-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Modern Admin Table -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden mx-auto">
            <!-- Table Header -->
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Administrators</h3>
                    <div class="flex items-center space-x-3">
                        <form method="GET" action="{{ route('admin.manage.index') }}" class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search administrators..." 
                                   class="pl-10 pr-4 py-2.5 w-64 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-gray-300 dark:placeholder-gray-400">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <kbd class="absolute right-3 top-2.5 px-2 py-0.5 text-xs text-gray-400 bg-gray-100 dark:bg-gray-600 rounded">⌘K</kbd>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <div class="flex justify-center">
                    <table class="w-full max-w-none">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-700">
                                <th class="px-6 py-4 text-left w-12">
                                    <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2">
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ADMIN</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ROLE</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">PHONE</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">STATUS</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">JOINED</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                            @foreach($admins as $index => $admin)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                    <!-- Checkbox -->
                                    <td class="px-6 py-4">
                                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2">
                                    </td>
                                    
                                    <!-- Admin Info -->
                                    <td class="px-6 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $avatarColors = [
                                                        'bg-gradient-to-br from-blue-500 to-blue-600',
                                                        'bg-gradient-to-br from-purple-500 to-purple-600', 
                                                        'bg-gradient-to-br from-green-500 to-green-600',
                                                        'bg-gradient-to-br from-red-500 to-red-600',
                                                        'bg-gradient-to-br from-yellow-500 to-yellow-600',
                                                        'bg-gradient-to-br from-indigo-500 to-indigo-600'
                                                    ];
                                                    $avatarColor = $avatarColors[$index % count($avatarColors)];
                                                @endphp
                                                <div class="w-10 h-10 rounded-lg {{ $avatarColor }} flex items-center justify-center shadow-sm">
                                                    <span class="text-sm font-semibold text-white">
                                                        {{ strtoupper(substr($admin->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $admin->name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $admin->email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Role -->
                                    <td class="px-6 py-6">
                                        <div class="flex items-center space-x-3">
                                            @php
                                                $roleColors = [
                                                    'Super Admin' => 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400',
                                                    'Admin' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
                                                    'Editor' => 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400',
                                                    'Moderator' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                ];
                                            @endphp
                                            @forelse($admin->roles as $role)
                                                @php
                                                    $roleColor = $roleColors[$role->name] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-900/30 dark:text-gray-400';
                                                @endphp
                                                <div class="w-8 h-8 rounded-full {{ $roleColor }} flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $role->name }}</span>
                                            @empty
                                                <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400 flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">No Role</span>
                                            @endforelse
                                        </div>
                                    </td>

                                    <!-- Phone -->
                                    <td class="px-6 py-6">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">{{ $admin->phone ?? 'N/A' }}</span>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-6">
                                        @if($admin->status === \App\Enums\StatusEnum::ACTIVE)
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                                <svg class="w-1.5 h-1.5 mr-2 fill-current" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3"/>
                                                </svg>
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                <svg class="w-1.5 h-1.5 mr-2 fill-current" viewBox="0 0 6 6">
                                                    <circle cx="3" cy="3" r="3"/>
                                                </svg>
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Joined Date -->
                                    <td class="px-6 py-6">
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $admin->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $admin->created_at->format('g:i A') }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-6">
                                        <div class="flex items-center justify-center space-x-3">
                                            <!-- View Button -->
                                            <a href="{{ route('admin.manage.show', $admin) }}" class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors duration-150" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.manage.edit', $admin) }}" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors duration-150" title="Edit Admin">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Status Toggle Button -->
                                            <button @click="adminToToggle = {{ $admin->id }}; showStatusModal = true"
                                                    class="p-2 text-gray-400 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-colors duration-150" 
                                                    title="{{ $admin->status === \App\Enums\StatusEnum::ACTIVE ? 'Deactivate' : 'Activate' }}">
                                                @if($admin->status === \App\Enums\StatusEnum::ACTIVE)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @endif
                                            </button>

                                            <!-- Reset Password Button -->
                                            <button @click="adminToReset = {{ $admin->id }}; showResetModal = true"
                                                    class="p-2 text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition-colors duration-150" 
                                                    title="Reset Password">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z" />
                                                </svg>
                                            </button>

                                            <!-- Delete Button -->
                                            <button @click="adminToDelete = {{ $admin->id }}; showDeleteModal = true"
                                                    class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-150" 
                                                    title="Delete Admin">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Showing <span class="font-medium text-gray-700 dark:text-gray-300">{{ $admins->firstItem() ?? 0 }}</span> to <span class="font-medium text-gray-700 dark:text-gray-300">{{ $admins->lastItem() ?? 0 }}</span> of <span class="font-medium text-gray-700 dark:text-gray-300">{{ $admins->total() }}</span> results
                    </div>
                    <div class="flex items-center space-x-2">
                        {{ $admins->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="showDeleteModal = false"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-2xl px-6 pt-6 pb-6 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-red-500 to-red-600 sm:mx-0 sm:h-12 sm:w-12 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:ml-6 sm:text-left">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                Delete Administrator
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Are you sure you want to delete this administrator? This action cannot be undone and will permanently remove their account and all associated data.
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-6 sm:flex sm:flex-row-reverse gap-3">
                        <form :action="'/admin/manage/admins/' + adminToDelete" method="POST" class="inline w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Admin
                            </button>
                        </form>
                        <button @click="showDeleteModal = false" type="button" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-semibold rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Change Confirmation Modal -->
        <div x-show="showStatusModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="showStatusModal = false"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-2xl px-6 pt-6 pb-6 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 sm:mx-0 sm:h-12 sm:w-12 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                            </svg>
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:ml-6 sm:text-left">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                Change Administrator Status
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Are you sure you want to change this administrator's status? This will affect their ability to access the admin panel.
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-6 sm:flex sm:flex-row-reverse gap-3">
                        <form :action="'/admin/manage/admins/' + adminToToggle + '/toggle-status'" method="POST" class="inline w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                                </svg>
                                Change Status
                            </button>
                        </form>
                        <button @click="showStatusModal = false" type="button" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-semibold rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reset Password Confirmation Modal -->
        <div x-show="showResetModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="showResetModal = false"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-2xl px-6 pt-6 pb-6 text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 sm:mx-0 sm:h-12 sm:w-12 shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z" />
                            </svg>
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:ml-6 sm:text-left">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                                Reset Administrator Password
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Are you sure you want to reset this administrator's password? A new random password will be generated and you'll need to share it with them securely.
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-6 sm:flex sm:flex-row-reverse gap-3">
                        <form :action="'/admin/manage/admins/' + adminToReset + '/reset-password'" method="POST" class="inline w-full sm:w-auto">
                            @csrf
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z" />
                                </svg>
                                Reset Password
                            </button>
                        </form>
                        <button @click="showResetModal = false" type="button" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-semibold rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<script>
    // Handle keyboard shortcut for search
    document.addEventListener('keydown', function(e) {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            document.querySelector('input[name="search"]').focus();
        }
    });

    // Auto-submit search form on input (debounced)
    let searchTimeout;
    const searchInput = document.querySelector('input[name="search"]');
    const searchForm = searchInput.closest('form');
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            searchForm.submit();
        }, 500); // Wait 500ms after user stops typing
    });
</script> 