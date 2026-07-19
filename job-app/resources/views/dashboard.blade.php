<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">
            <h3 class="text-white text-2xl font-bold mb-4">
                {{ __('Welcome back,') }} {{ Auth::user()->name }}!
            </h3>

            <div class="flex items-center justify-between">
                <form action="{{ route('dashboard') }}" method="GET" class="flex items-center justify-center w-1/4">
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full p-2 rounded-l-lg bg-gray-800 text-white"
                        placeholder="Search for a job">
                    <button type="submit"
                        class="bg-blue-500 text-white p-2 rounded-r-lg border border-blue-500">Search</button>
                </form>

                <div class="flex space-x-2">
                    <a href="{{ route('dashboard', ['filter' => 'Full-time', 'search' => request('search')]) }}" class="text-white p-2 border rounded-lg">Full-Time</a>
                    <a href="{{ route('dashboard', ['filter' => 'Remote', 'search' => request('search')]) }}" class="text-white p-2 border rounded-lg">Remote</a>
                    <a href="{{ route('dashboard', ['filter' => 'Hybrid', 'search' => request('search')]) }}" class="text-white p-2 border rounded-lg">Hybrid</a>
                    <a href="{{ route('dashboard', ['filter' => 'Contract', 'search' => request('search')]) }}" class="text-white p-2 border rounded-lg">Contract</a>
                </div>
            </div>

            @if (request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif

                <div class="space-y-4 mt-6">
    @foreach ($jobs as $job)
    <div class="border-b border-white/10 pb-4 flex justify-between items-center">
        <div>
            <a href="{{ route('job-vacancy.show', $job->id) }}" class="text-lg font-semibold text-blue-400 hover:underline">{{ $job->title }}</a>
            <p class="text-sm text-white">{{ $job->company->name }} - {{ $job->location }}</p>
            <p class="text-sm text-white">${{ number_format($job->salary, 2) }}/ Year</p>
        </div>
        <span class="bg-blue-500 text-white p-2 rounded-lg">{{ $job->type }}</span>
    </div>
    @endforeach
</div>

                <div class="mt-4">
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
