<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $vacancy->title }} - Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="bg-black shadow-lg rounded-lg p-6 max-w-7xl mx-auto">
            <a href="{{  url()->previous() }}" class="text-blue-500 hover:underline mb-4 inline-block">← Back</a>

            <div class="border-b border-white/10 pb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white text-2xl font-bold mb-2">
                            {{ $vacancy->title }}
                        </h3>
                        <p class="text-md text-white font-semibold">{{ $vacancy->company->name }}</p>

                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 mt-6">
    <div class="col-span-2">
        <h2 class="text-lg font-bold text-white">Job Description</h2>
        <p class="text-gray-400">{{ $vacancy->description }}</p>
    </div>
    <div class="col-span-1">
        <h2 class="text-lg font-bold text-white">Job Overview</h2>
        <div class="bg-gray-900 rounded-lg p-6 space-y-4">
            <div>
                <p class="text-gray-400">Company</p>
                <p class="text-white">{{ $vacancy->company->name }}</p>
            </div>
            <div>
                <p class="text-gray-400">Location</p>
                <p class="text-white">{{ $vacancy->location }}</p>
            </div>
            <div>
                <p class="text-gray-400">Salary/Year</p>
                <p class="text-white">{{ '$' . number_format($vacancy->salary) }}</p>
            </div>
            <div>
                <p class="text-gray-400">Type</p>
                <p class="text-white">{{ $vacancy->type }}</p>
            </div>
            <div>
                <p class="text-gray-400">Category</p>
                <p class="text-white">{{ $vacancy->jobCategory->name }}</p>
            </div>
        </div>
    </div>
</div>
    <a href="{{ route('job-vacancy.apply', $vacancy->id) }}" class="text-white rounded-xl bg-gradient-to-r from-indigo-500 to-rose-500 hover:from-indigo-400 hover:to-rose-400 transition-colors px-8 py-3  font-medium text-base shadow-lg shadow-rose-500/20">Apply Now</a>
        </div>





    </div>




    </div>














</x-app-layout>
