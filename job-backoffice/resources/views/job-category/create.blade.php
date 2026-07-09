<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Job Category') }}
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
            <form action="{{ route('job-category.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="{{ $errors->has('name') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <a class="inline-flex items-center px-4 pt-2 pb-2 text-grey rounded-md hover:bg-gray-100"
                    href="{{ url()->previous() }}">Cancel</a>



                <button type="submit"
                    class="inline-flex items-center px-4 pt-2 pb-2 bg-blue-500 text-white rounded-md hover:bg-blue-800">
                    Add Category
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
