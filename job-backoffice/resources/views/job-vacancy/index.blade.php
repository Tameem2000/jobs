<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Vacancies {{ request()->input('archive') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="flex justify-between items-center pb-2">
            @if (request()->input('archive') == 'true')
                <a href="{{ route('job-vacancy.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                    Active
                </a>
            @else
                <a href="{{ route('job-vacancy.index', ['archive' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                    Archived
                </a>
            @endif

            <!-- Add job vacancy button -->
            <a href="{{ route('job-vacancy.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                Add Job Vacancy
            </a>
        </div>

        <!-- Job Vacancy Table -->
        <table class="min-w-full divide-y divide-grey-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Title</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Company</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($jobVacancies as $jobVacancy)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-black">
                            @if (request()->input('archive') == 'true')
                                <span class="text-gray-600">{{ $jobVacancy->title }}</span>
                            @else
                                <a href="{{ route('job-vacancy.show', $jobVacancy->id) }}"
                                    class="px-2 text-blue-800 hover:text-blue-900">{{ $jobVacancy->title }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-black">{{ $jobVacancy->company->name }}</td>
                        <td class="px-6 py-4 text-black">{{ $jobVacancy->location }}</td>
                        <td class="px-6 py-4 text-black">{{ $jobVacancy->type }}</td>
                        <td class="px-6 py-4 text-black">${{ number_format($jobVacancy->salary, 2) }}</td>
                        <td>
                            @if (request()->input('archive') == 'true')
                                <!-- Restore button -->
                                <form action="{{ route('job-vacancy.restore', $jobVacancy->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-2 text-green-700 hover:text-green-900">Restore</button>
                                </form>
                            @else
                                <!-- Edit button -->
                                <a href="{{ route('job-vacancy.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'true']) }}"
                                    class="px-2 text-blue-700 hover:text-blue-900">Edit</a>

                                <!-- Archive button -->
                                <form action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 text-red-700 hover:text-red-900">Archive</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No job vacancies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $jobVacancies->links() }}
        </div>
    </div>
</x-app-layout>
