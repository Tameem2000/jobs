<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Categories {{ request()->input('archive') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="flex justify-between items-center pb-2">
            @if (request()->input('archive') == 'true')
                <a href="{{ route('job-category.index') }}"
                    class="inline-flex items center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                    Active
                </a>
            @else
                <a href="{{ route('job-category.index', ['archive' => 'true']) }}"
                    class="inline-flex items center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                    Archived
            @endif

            <!-- Add category button -->
            <a href="{{ route('job-category.create') }}"
                class="inline-flex items center px-4 py-2 bg-blue-500 text-white hover:bg-blue-800 rounded-md focus:ring-2 focus:ring-offset">
                Add Job category
            </a>

        </div>





        <!-- Job Category Table -->
        <table class="min-w-full divide-y divide-grey-200 rounded-lg shadow mt-4 bg-white">


            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Category Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-black">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-black">{{ $category->name }}</td>
                        <td>
                            @if (request()->input('archive') == 'true')
                                <!-- Restore button -->
                                <form action="{{ route('job-category.restore', $category->id) }}" method="POST"
                                    class="inline block">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-2 text-green-700 hover-green-900">Restore</button>
                                </form>
                            @else
                                <!-- Edit button -->
                                <a href="{{ route('job-category.edit', $category->id) }}"
                                    class="px-2 text-blue-700 hover:text-blue-900">Edit</a>

                                <!-- Archive button -->
                                <form action="{{ route('job-category.destroy', $category->id) }}" method="POST"
                                    class="inline block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 text-red-700 hover:text-red-900">Archive</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">No job categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
