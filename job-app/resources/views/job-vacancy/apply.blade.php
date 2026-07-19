<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $vacancy->title }} - Apply
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

                    </div>
                </div>
            </div>
            <form action="{{ route('job-vacancy.storeApplication', $vacancy->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                @endif
                <!-- Resume Selection -->
                <div>
                    <h3 class="text-white text-xl font-semibold mb-2 mt-4">Choose your Resume</h3>

                    <div class="mb-6">
                        <label for="resume" class="text-white text-md mb-2">Select from your existing resumes:</label>
                        <!-- List of Resumes -->
                        <div class="space-y-4">
                            @forelse($resumes as $resume)
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="resume_option" id="existing_{{ $resume->id }}" value="existing_{{ $resume->id }}"
                                        @error('resume_option') class="border-red-500" @else class="border-gray-600" @enderror />
                                    <x-input-label for="existing_{{ $resume->id }}" class="text-white cursor-pointer">
                                        {{ $resume->fileName }}
                                        <span class="text-gray-400 text-sm">(Last updated: {{ $resume->updated_at->format('M d, Y') }})</span>
                                    </x-input-label>
                                </div>
                            @empty
                                <span class="text-gray-400 text-sm">No resumes found.</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Upload New Resume -->
                    <div x-data="{ fileName: '', hasError: {{ $errors->has('resume_file') ? 'true' : 'false' }} }">
                        <div class="flex items-center gap-2">
                            <input x-ref="newResumeRadio" type="radio" name="resume_option" id="new_resume" value="new_resume"
                                @error('resume_option') class="border-red-500" @else class="border-gray-600" @enderror />
                            <x-input-label class="text-white cursor-pointer" for="new_resume" value="Upload a new resume:" />
                        </div>
                        <div class="flex items-center">
                            <div class="flex-1">
                                <label for="new_resume_file" class="block text-white cursor-pointer">
                                    <div class="border-2 border-dashed border-gray-600 rounded-lg p-4 hover:border-blue-500 transition"
                                        :class="{ 'border-blue-500': fileName, 'border-red-500': hasError }">
                                        <input @change="fileName = $event.target.files[0].name; $refs.newResumeRadio.checked = true" type="file"
                                            name="resume_file" id="new_resume_file" class="hidden" accept=".pdf" />
                                        <div class="text-center">
                                            <template x-if="!fileName">
                                                <p class="text-gray-400">Click to upload PDF (Max 5MB)</p>
                                            </template>

                                            <template x-if="fileName">
                                                <div>
                                                    <p x-text="fileName" class="mt-2 text-blue-400"></p>
                                                    <p class="text-gray-400 text-sm mt-1">Click to change file</p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="border-0 mt-4 text-white rounded-xl bg-gradient-to-r from-indigo-500 to-rose-500 hover:from-indigo-400 hover:to-rose-400 transition-colors px-8 py-3  font-medium text-base shadow-lg shadow-rose-500/20">
                    Submit Application
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
