<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 flex flex-col gap-6">
        <!-- Overview Cards -->
        <div class="grid grid-cols-3 gap-6">

            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Active Users</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['activeUsers'] }}</p>
                <p class="text-sm text-gray-500">Last 30 days</p>
            </div>

            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Total Jobs</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalJobs'] }}</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>

            <div class="p-6 bg-white overflow-hidden shadow-sm rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Total Applications</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalApplications'] }}</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>
        </div>

        <!-- Most Applied Jobs Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 ">
            <h3 class="text-lg font-medium text-gray-900">Most Applied Jobs</h3>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Job Title</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applications</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mostAppliedJobs as $job)
                            <tr class="border-b">
                                <td class="px-6 py-4 text-black">{{ $job->title }}</td>
                                <td class="px-6 py-4 text-black">{{ $job->company->name }}</td>
                                <td class="px-6 py-4 text-black">{{ $job->totalCount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Conversation Rates Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 ">
            <h3 class="text-lg font-medium text-gray-900">Conversation Rates</h3>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Job Title</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">View</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applications</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Conversation Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($conversationRates as $rate)
                            <tr class="border-b">
                                <td class="px-6 py-4 text-black">{{ $rate->title }}</td>
                                <td class="px-6 py-4 text-black">{{ $rate->viewCount }}</td>
                                <td class="px-6 py-4 text-black">{{ $rate->totalCount }}</td>
                                <td class="px-6 py-4 text-black">{{ $rate->conversationRate }}%</td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



        <!-- Most Applied Jobs -->

        <!-- Conversation rates -->
    </div>
</x-app-layout>
