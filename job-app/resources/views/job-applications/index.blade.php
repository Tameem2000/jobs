<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Applications') }}
        </h2>
    </x-slot>
    <!-- validate ssession  -->
    <div class="absloute inset-x-0 bottom-0 z-50">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4  " role="alert">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto flex flex-col gap-6">
            @forelse ($jobs as $job)
                <div class="bg-black shadow-lg rounded-lg p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-2xl font-bold text-white hover:underline">
                                {{ $job->jobVacancy->title }}
                            </p>
                            <p class="text-md text-white mt-1">{{ $job->jobVacancy->company->name }}</p>
                            <p class="text-sm text-gray-400">{{ $job->jobVacancy->location }}</p>
                            <p class="text-sm text-gray-400 mt-2">{{ $job->created_at->format('d M Y') }}</p>
                        </div>
                        <span class="shrink-0 bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded-lg">
                            {{ $job->jobVacancy->type }}
                        </span>
                    </div>

                    <p class="text-white mt-4">
                        Applied With: {{ $job->resume->fileName }}
                        <a href="{{ config('filesystems.disks.cloud.url').'/'.$job->resume->fileUrl }}" target="_blank"
                            rel="noopener" class="text-indigo-400 hover:underline">View Resume</a>
                    </p>

                    <div class="flex flex-wrap gap-3 mt-4">
                        <span @class([
                            'px-4 py-2 rounded-lg text-sm font-medium text-white',
                            'bg-amber-500' => strtolower($job->status) === 'pending',
                            'bg-green-600' => strtolower($job->status) === 'accepted',
                            'bg-red-600' => strtolower($job->status) === 'rejected',
                        ])>
                            Status: {{ ucfirst($job->status) }}
                        </span>
                        <span class="bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg">
                            Score: {{ round($job->aiGeneratedScore) }}
                        </span>
                    </div>

                    @if ($job->aiGeneratedFeedback)
                        <div class="mt-4">
                            <h4 class="text-white font-bold mb-2">AI Feedback:</h4>
                            <p class="text-gray-300 leading-relaxed">{{ $job->aiGeneratedFeedback }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-black shadow-lg rounded-lg p-6 text-center">
                    <p class="text-white">No applications found.</p>
                </div>
            @endforelse
        </div>

        <div class="max-w-7xl mx-auto mt-6">
            {{ $jobs->links() }}
        </div>
    </div>
</x-app-layout>
