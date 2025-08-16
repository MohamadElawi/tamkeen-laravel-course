<x-filament::card>
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold">User Count</h2>

        <x-filament::select wire:model="statusFilter" placeholder="Filter by Status" class="w-48">
            <option value="all">All</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="blocked">Blocked</option>
        </x-filament::select>
    </div>

    <div class="mt-4 text-3xl font-semibold">
        {{ $totalUsers }}
    </div>
</x-filament::card>
