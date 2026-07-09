<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="mb-6">
            <a href="{{ route('job-vacancy.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">← Back</a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Job Vacancy Details</h3>
            <p><strong>Company: </strong>{{ $jobVacancy->company->name }}</p>
            <p><strong>Location: </strong>{{ $jobVacancy->location }}</p>
            <p><strong>Type: </strong>{{ $jobVacancy->type }}</p>
            <p><strong>Salary: </strong>${{ number_format($jobVacancy->salary, 2) }}</p>
            <p><strong>Description: </strong>{{ $jobVacancy->description }}</p>

            <div class="mt-4">
                <a href="{{ route('job-vacancy.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'false']) }}"
                    class="px-2 text-blue-700 hover:text-blue-900">Edit</a>

                <form action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2 text-red-700 hover:text-red-900">Archive</button>
                </form>
            </div>

            <div class="mt-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('job-vacancy.show', ['job_vacancy' => $jobVacancy->id, 'tab' => 'jobs']) }}"
                            class="py-2 px-4 text-gray-800 font-semibold {{ request('tab') == 'jobs' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">Jobs</a>
                    </li>
                    <li>
                        <a href="{{ route('job-vacancy.show', ['job_vacancy' => $jobVacancy->id, 'tab' => 'applications']) }}"
                            class="py-2 px-4 text-gray-800 font-semibold {{ request('tab') == 'applications' ? 'border-b-2 border-blue-500' : '' }}">Applications</a>
                    </li>
                </ul>
            </div>

            <div class="mt-4">

                <div id="applications" class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
                    <h3 class="text-lg font-bold pt-4 mb-2">Applications Content</h3>
                    <table class="min-w-full bg-gray-50 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Applicant Name</th>
                                <th class="py-2 px-4 text-left bg-gray-100">Job Title</th>
                                <th class="py-2 px-4 text-left bg-gray-100">Status</th>
                                <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Notice this uses jobApplication (singular) to match your JobVacancy model --}}
                            @foreach ($jobVacancy->jobApplication as $application)
                                <tr>
                                    <td class="py-2 px-4">{{ $application->user->name }}</td>
                                    <td class="py-2 px-4">{{ $jobVacancy->title }}</td>
                                    <td class="py-2 px-4">{{ $application->status }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('job-application.show', $application->id) }}"
                                            class="text-blue-500 hover:text-blue-700 underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div> </div> </div> </x-app-layout>
