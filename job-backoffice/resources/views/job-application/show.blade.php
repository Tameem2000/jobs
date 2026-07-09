<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $jobApplication->user->name }} | Applied To {{ $jobApplication->jobVacancy->title }} |
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />
        <!-- Back button -->
            <div class="mb-6">
                <a href="{{ route('job-application.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">←
                    Back</a>
            </div>
            <!-- Applicant Details -->

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Applicant Details</h3>
                <p><strong>Applicant: </strong>{{ $jobApplication->user->name }}</p>
                <p><strong>Job Vacancy: </strong>{{ $jobApplication->jobVacancy->title }}</p>
                <p><strong>Status: </strong> <span class="@if ($jobApplication->status == 'Pending') text-black @elseif ($jobApplication->status == 'Accepted') text-green-600 @elseif ($jobApplication->status == 'Rejected') text-red-600 @endif">{{ $jobApplication->status }}</span></p>
                <p><strong>Resume: </strong><a class= "text-blue-700 hover:text-blue-900 underline"
                    href="{{ $jobApplication->resume->url }}"target="_blank">{{ $jobApplication->resume->fileUrl }}</a></p>

                <!-- Edit and Delete Buttons -->
                <div class="mt-4">
                    <a href="{{ route('job-application.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'false']) }}"
                        class="px-2 text-blue-700 hover:text-blue-900">Edit</a>

                    <!-- Archive button -->
                    <form action="{{ route('job-application.destroy', $jobApplication->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 text-red-700 hover:text-red-900">Archive</button>
                    </form>
                    <!-- Tabs Navigation -->
                    <div class="mt-6">
                        <ul class="flex space-x-4">
                            <li>
                                <a href="{{ route('job-application.show', ['job_application' => $jobApplication->id, 'tab' => 'resume']) }}"
                                    class="py-2 px-4 text-grey-800 font-semibold{{ request('tab') == 'resume' || request('tab') == '' ? ' border-b-2 border-blue-500' : '' }}">Resume</a>
                            </li>
                            <li>
                                <a href="{{ route('job-application.show', ['job_application' => $jobApplication->id, 'tab' => 'ai-feedback']) }}"
                                    class="py-2 px-4 text-grey-800 font-semibold{{ request('tab') == 'ai-feedback' ? ' border-b-2 border-blue-500' : '' }}">AI Feedback</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Tap content -->
                    <div>
                        <!-- Resume Job -->
                        <div id="resume"
                            class="{{ request(key: 'tab') == 'resume' || request('tab') == '' ? 'block' : 'hidden' }}">
                            <h3 class="text-lg font-bold pt-4">Resume Content</h3>
                            <table class="min-w-full bg-gray-50 rounded-lg shadow">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Summary</th>
                                        <th class="py-2 px-4 text-left bg-gray-100">Skills</th>
                                        <th class="py-2 px-4 text-left bg-gray-100">Experience</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Education</th>
                                     </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td class="py-2 px-4">{{ $jobApplication->resume->summary }}</td>
                                            <td class="py-2 px-4">{{ $jobApplication->resume->skills }}</td>
                                            <td class="py-2 px-4">{{ $jobApplication->resume->experience }}</td>
                                            <td class="py-2 px-4">{{ $jobApplication->resume->education }}</td>
                                        </tr>

                                </tbody>
                            </table>

                        </div>
<!-- AI Feedback -->
                        <div id="ai-feedback" class="{{ request('tab') == 'ai-feedback' ? 'block' : 'hidden' }}">
                            <h3 class="text-lg font-bold pt-4">AI Feedback Content</h3>
                            <table class="min-w-full bg-gray-50 rounded-lg shadow">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Ai Score</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Ai FeedBack</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td class="py-2 px-4">{{ $jobApplication->aiGeneratedScore }}</td>
                                            <td class="py-2 px-4">{{ $jobApplication->aiGeneratedFeedback }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <div id="applications" class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
                            <h3 class="text-lg font-bold pt-4   ">Applications Content</h3>
                            <table class="min-w-full bg-gray-50 rounded-lg shadow">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">ApplicantName</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Job Title</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Status</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td class="py-2 px-4">{{ $jobApplication->user->name }}</td>
                                            <td class="py-2 px-4">{{ $jobApplication->jobVacancy->title }}</td>
                                            <td class="py-2 px-4">{{ $jobApplication->status }}</td>
                                            <td class="py-2 px-4">
                                                <a href="{{ route('job-application.show', $jobApplication->id) }}"
                                                    class="text-blue-500 hover:text-blue-700 underline">View</a>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>




                    </div>










</x-app-layout>
