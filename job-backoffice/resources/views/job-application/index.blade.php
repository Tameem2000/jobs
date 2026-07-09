<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Applications {{ request()->input('archive') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="flex justify-between items-center pb-2">
            @if (request()->input('archive') == 'true')
                <a href="{{ route('job-application.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                    Active
                </a>
            @else
                <a href="{{ route('job-application.index', ['archive' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                    Archived
                </a>
            @endif

        </div>

        <!-- Job Application Table -->
        <table class="min-w-full divide-y divide-grey-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Applicant Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Position</th>
                    @if (auth()->user()->role !== 'company-owner')
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($jobApplications as $jobApplication)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-black">
                            @if (request()->input('archive') == 'true')
                                <span class="text-gray-600">{{ $jobApplication->user->name }}</span>
                            @else
                                <a href="{{ route('job-application.show', $jobApplication->id) }}"
                                    class="px-2 text-blue-800 hover:text-blue-900">{{ $jobApplication->user->name }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-black">{{ $jobApplication->jobVacancy->title }}</td>
                        @if (auth()->user()->role !== 'company-owner')
                        <td class="px-6 py-4 text-black">{{ $jobApplication->jobVacancy?->company?->name ?? 'N/A' }}</td>
                        @endif
                        <td class="px-6 py-4 @if ($jobApplication->status == 'Pending') text-black @elseif ($jobApplication->status == 'Accepted') text-green-600 @elseif ($jobApplication->status == 'Rejected') text-red-600 @endif">{{ $jobApplication->status }}</td>

                        <td>
                            @if (request()->input('archive') == 'true')
                                <!-- Restore button -->
                                <form action="{{ route('job-application.restore', $jobApplication->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-2 text-green-700 hover:text-green-900">Restore</button>
                                </form>
                            @else
                                <!-- Edit button -->
                                <a href="{{ route('job-application.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'true']) }}"
                                    class="px-2 text-blue-700 hover:text-blue-900">Edit</a>

                                <!-- Archive button -->
                                <form action="{{ route('job-application.destroy', $jobApplication->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 text-red-700 hover:text-red-900">Archive</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No job applications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $jobApplications->links() }}
        </div>
    </div>
</x-app-layout>
