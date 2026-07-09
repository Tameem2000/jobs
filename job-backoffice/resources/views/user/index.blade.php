<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="flex justify-between items-center pb-2">
            @if (request()->input('archive') == 'true')
                <a href="{{ route('user.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                    Active
                </a>
            @else
                <a href="{{ route('user.index', ['archive' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                    Archived
                </a>
            @endif

        </div>

        <!-- User Table -->
        <table class="min-w-full divide-y divide-grey-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-black">
                            @if (request()->input('archive') == 'true')
                                <span class="text-gray-600">{{ $user->name }}</span>
                            @else
                                <span class="px-2 text-gray-800">{{ $user->name }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-black">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-black">{{ $user->role }}</td>
                        <td>
                            @if (request()->input('archive') == 'true')
                            <!-- if Admin do not show restore button -->

                                <!-- Restore button -->
                                <form action="{{ route('user.restore', $user->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-2 text-green-700 hover:text-green-900">Restore</button>
                                </form>
                            @else
                            @if ($user->role !== 'admin')
                                <!-- Edit button -->
                                <a href="{{ route('user.edit', ['user' => $user->id, 'redirectToList' => 'true']) }}"
                                    class="px-2 text-blue-700 hover:text-blue-900">Edit</a>

                                <!-- Archive button -->
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 text-red-700 hover:text-red-900">Archive</button>
                                </form>
                            @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
