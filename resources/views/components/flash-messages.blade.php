@if (session('success'))
    <div class="mb-4 px-4 py-3 rounded bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 border border-red-300 font-bold">
        {{ session('error') }}
    </div>
@endif 