<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />
        <!-- Back button -->
            <div class="mb-6">
                <a href="{{ route('company.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">←
                    Back</a>
            </div>
            <!-- Company Details -->

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Company Details</h3>
                <p><strong>Owner: </strong>{{ $company->owner->name }}</p>
                <p><strong>Address: </strong>{{ $company->address }}</p>
                <p><strong>Industry: </strong>{{ $company->industry }}</p>
                <p><strong>Website: </strong><a class="text-blue-500 hover:text-blue-700 underline"
                        href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></p>

                <!-- Edit and Delete Buttons -->
                <div class="mt-4">
                    <a href="{{ route('company.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}"
                        class="px-2 text-blue-700 hover:text-blue-900">Edit</a>

                    <!-- Archive button -->
                    <form action="{{ route('company.destroy', $company->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 text-red-700 hover:text-red-900">Archive</button>
                    </form>
                    <!-- Tabs Navigation -->
                    <div class="mt-6">
                        <ul class="flex space-x-4">
                            <li>
                                <a href="{{ route('company.show', ['company' => $company->id, 'tab' => 'jobs']) }}"
                                    class="py-2 px-4 text-grey-800 font-semibold{{ request('tab') == 'jobs' || request('tab') == '' ? ' border-b-2 border-blue-500' : '' }}">Jobs</a>
                            </li>
                            <li>
                                <a href="{{ route('company.show', ['company' => $company->id, 'tab' => 'applications']) }}"
                                    class="py-2 px-4 text-grey-800 font-semibold{{ request('tab') == 'applications' ? ' border-b-2 border-blue-500' : '' }}">Application</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Tap content -->
                    <div>
                        <!-- Tap Job -->
                        <div id="jobs"
                            class="{{ request(key: 'tab') == 'jobs' || request('tab') == '' ? 'block' : 'hidden' }}">
                            <h3 class="text-lg font-bold pt-4">Jobs Content</h3>
                            <table class="min-w-full bg-gray-50 rounded-lg shadow">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">Title</th>
                                        <th class="py-2 px-4 text-left bg-gray-100">Type</th>
                                        <th class="py-2 px-4 text-left bg-gray-100">Location</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($company->jobVacancy as $vacancy)
                                        <tr>
                                            <td class="py-2 px-4">{{ $vacancy->title }}</td>
                                            <td class="py-2 px-4">{{ $vacancy->type }}</td>
                                            <td class="py-2 px-4">{{ $vacancy->location }}</td>
                                            <td class="py-2 px-4">
                                                <a href="{{ route('job-vacancy.show', $vacancy->id) }}"
                                                    class="text-blue-500 hover:text-blue-700 underline">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div id="applications" class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
                            <h3 class="text-lg font-bold pt-4   ">Applications Content</h3>
                            <table class="min-w-full bg-gray-50 rounded-lg shadow">
                                <thead>
                                    <tr>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tl-lg">ApplicantName</th>
                                        <th class="py-2 px-4 text-left bg-gray-100">Job Title</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Status</th>
                                        <th class="py-2 px-4 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($company->jobApplication as $application)
                                        <tr>
                                            <td class="py-2 px-4">{{ $application->user->name }}</td>
                                            <td class="py-2 px-4">{{ $application->jobVacancy->title }}</td>
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




                    </div>










</x-app-layout>
