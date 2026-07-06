<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Category') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <form action="{{ route('job-category.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                        class="{{ $errors->has('name') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
              <button class="inline-flex items-center px-4 pt-2 pb-2 text-grey rounded-md hover:bg-gray-100">
                    <a href="{{ route('job-category.index') }}">Cancel</a>

                </button>

                <button type="submit"
                    class="inline-flex items-center px-4 pt-2 pb-2 bg-blue-500 text-white rounded-md hover:bg-blue-800">
                    Update Category
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
