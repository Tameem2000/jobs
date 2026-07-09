<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant Status') }}
        </h2>
    </x-slot>

    {{-- errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">Please fix the following errors:</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <form action="{{ route('job-application.update', ['job_application' =>  $jobApplication->id, 'redirectToList' => request()->query('redirectToList')]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Job Application Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-50 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Job Application Details</h3>
                    <p class="text-sm mb-4">Update The Job Application Details</p>

                    <div class="mb-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Applicant Name</label>
                        <span>{{ $jobApplication->user->name }}</span>

                    </div>
                   <div class="mb-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Job Vacancy</label>
                        <span>{{ $jobApplication->jobVacancy->title }}</span>

                    </div>

                        <div class="mb-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Company</label>
                        <span>{{ $jobApplication->jobVacancy->company->name }}</span>

                    </div>

                     <div class="mb-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Ai Score</label>
                        <span>{{ $jobApplication->aiGeneratedScore }}</span>

                    </div>

                     <div class="mb-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Ai FeedBack</label>
                        <span>{{ $jobApplication->aiGeneratedFeedback }}</span>

                    </div>

                        <div class="mb-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 mt-2">Status</label>
                            <select name="status" id="status"
                                class="{{ $errors->has('status') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="Pending" {{ old('status', $jobApplication->status) == 'Pending' ? 'selected' : '' }}>Pending</option>

                                <option value="Accepted" {{ old('status', $jobApplication->status) == 'Accepted' ? 'selected' : '' }}>Accepted
                                </option>
                                <option value="Rejected" {{ old('status', $jobApplication->status) == 'Rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                </div>

    <a href="{{ url()->previous() }}"
        class="inline-flex items-center px-4 pt-2 pb-2 text-grey rounded-md hover:bg-gray-100">
        Cancel
    </a>

    <button type="submit"
        class="inline-flex items-center px-4 pt-2 pb-2 bg-blue-500 text-white rounded-md hover:bg-blue-800">
        Update Application Status
    </button>
    </form>
</div>
    </div>
</x-app-layout>
