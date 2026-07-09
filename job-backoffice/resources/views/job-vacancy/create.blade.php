<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Job Vacancy') }}
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
            <form action="{{ route('job-vacancy.store') }}" method="POST">
                @csrf

                <!-- Job Vacancy Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-50 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Job Vacancy Details</h3>
                    <p class="text-sm mb-4">Enter The Job Vacancy Details</p>

                    <div class="mb-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="{{ $errors->has('title') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                            class="{{ $errors->has('location') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        </div>

                         <div class="mb-2">
                            <label for="salary" class="block text-sm font-medium text-gray-700 mt-2">Expected
                                Salary(USD)</label>
                            <input type="number" name="salary" id="salary" value="{{ old('salary') }}"
                                class="{{ $errors->has('salary') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('salary')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror


                        </div>

                        <div class="mb-2">
                            <label for="type" class="block text-sm font-medium text-gray-700 mt-2">Type</label>
                            <select name="type" id="type"
                                class="{{ $errors->has('type') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="Full-time" {{ old('type') == 'Full-time' ? 'selected' : '' }}>Full-time
                                </option>
                                <option value="Contract" {{ old('type') == 'Contract' ? 'selected' : '' }}>Contract
                                </option>
                                <option value="Hybrid" {{ old('type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="Remote" {{ old('type') == 'Remote' ? 'selected' : '' }}>Remote</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Select Dropdown -->
                        <div class="mb-2">
                            <label for="companyId" class="block text-sm font-medium text-gray-700 mt-2">Company</label>
                            <select name="companyId" id="companyId"
                                class="{{ $errors->has('companyId') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ old('companyId') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('companyId')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                    </div>
<!-- Category Select Dropdown -->
                        <div class="mb-2">
                            <label for="categoryId" class="block text-sm font-medium text-gray-700 mt-2">Category</label>
                            <select name="categoryId" id="categoryId"
                                class="{{ $errors->has('categoryId') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('categoryId') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoryId')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                    </div>
                    <!-- Description Textarea -->
                    <div class="mb-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mt-2">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="{{ $errors->has('description') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                </div>











    <a href="{{ route('job-vacancy.index') }}"
        class="inline-flex items-center px-4 pt-2 pb-2 text-grey rounded-md hover:bg-gray-100">
        Cancel
    </a>

    <button type="submit"
        class="inline-flex items-center px-4 pt-2 pb-2 bg-blue-500 text-white rounded-md hover:bg-blue-800">
        Add Job Vacancy
    </button>
    </form>
</div>
    </div>
</x-app-layout>
