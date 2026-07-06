<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Company') . ' - ' . $company->name }}
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
            <form action="{{ route('company.update', ['company' => $company->id, 'redirectToList' => request()->query('redirectToList')]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Company Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-50 rounded-lg shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Company Details</h3>
                    <p class="text-sm mb-4">Change The Company Details</p>

                    <div class="mb-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}"
                            class="{{ $errors->has('name') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address', $company->address) }}"
                            class="{{ $errors->has('address') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <div class="mb-2">
                            <label for="industry" class="block text-sm font-medium text-gray-700 mt-2">Industry</label>
                            <select name="industry" id="industry"
                                class="{{ $errors->has('industry') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry }}" {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>
                                        {{ $industry }}
                                    </option>
                                @endforeach
                            </select>
                            @error('industry')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="website" class="block text-sm font-medium text-gray-700 mt-2">Website
                                (optional)</label>
                            <input type="text" name="website" id="website"
                                value="{{ old('website', $company->website) }}"
                                class="{{ $errors->has('website') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('website')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror


                        </div>
                    </div>
                                    </div>


                    <!-- Owner Details -->

                    <div class="mb-4 p-6 bg-gray-50 border border-gray-50 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold mb-4">Owner Details</h3>
                        <p class="text-sm mb-4">Change The Owner Details</p>

                        <div class="mb-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Owner Name</label>
                            <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $company->owner->name) }}"
                                class="{{ $errors->has('owner_name') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('owner_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Owner Email</label>
                            <input disabled type="email" name="owner_email" id="owner_email" value="{{ old('owner_email', $company->owner->email) }}"
                                class="{{ $errors->has('owner_email') ? 'outline-red-500' : 'outline-grey-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-300">
                            @error('owner_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror


                        </div>
                        <div class="mb-2">
                            <!-- Password -->
                            <div class="mt-4 relative" x-data="{ show: false }">
                                <x-input-label for="owner_password" :value="__('Owner Password (Leave blank if you want to keep the current password)')" />

                                <div class="relative">
                                    <x-text-input id="password"
                                        class=" outline outline-1 mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm block pr-10"
                                        x-bind:type="show ? 'text' : 'password'" name="owner_password"
                                        autocomplete="current-password" />


                                    <!-- Eye Icon for Show/Hide Password -->
                                    <button type="button"
                                        class="absolute inset-y-0 right-2 flex items-center text-gray-500"
                                        @click="show = !show">
                                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                        </svg>

                                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825a9.56 9.56 0 01-1.875.175c-4.478 0-8.268-2.943-9.542-7 1.002-3.364 3.843-6 7.542-7.575M15 12a3 3 0 00-6 0 3 3 0 006 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>



                        </div>

                    </div>





                <button class="inline-flex items-center px-4 pt-2 pb-2 text-grey rounded-md hover:bg-gray-100">
                    <a href="{{ route('company.index') }}">Cancel</a>

                </button>

                <button type="submit"
                    class="inline-flex items-center px-4 pt-2 pb-2 bg-blue-500 text-white rounded-md hover:bg-blue-800">
                    Update Company
                </button>
            </form>

        </div>
    </div>
</x-app-layout>
