<x-main-layout title="Jobify - Find your dream job">
    <div class="flex flex-col items-center justify-center text-center space-y-8 max-w-4xl mx-auto px-4">

        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
            <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <span class="text-sm text-white/70 rounded-full bg-white/10 px-4 py-1.5 font-medium tracking-wide border border-white/5">
                    Jobify
                </span>
            </div>
        </div>

        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)">
            <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <h1 class="text-6xl sm:text-7xl md:text-8xl font-bold tracking-tight leading-tight">
                    <span class="text-white">Find your</span><br />
                    <span class="text-gray-300 font-serif italic pr-4">Dream Job</span>
                </h1>
            </div>
        </div>

        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)">
            <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <p class="text-white/60 text-lg sm:text-xl max-w-2xl">
                    connect with top employers, and find exciting opportunities
                </p>
            </div>
        </div>

        <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 700)">
            <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="flex flex-row items-center justify-center gap-4 pt-2">

                <a href="{{ route('register') }}"
                   class="rounded-xl bg-white/10 hover:bg-white/20 transition-colors px-6 py-3 text-white font-medium text-base">
                    Create an Account
                </a>

                <a href="{{ route('login') }}"
                   class="text-white rounded-xl bg-gradient-to-r from-indigo-500 to-rose-500 hover:from-indigo-400 hover:to-rose-400 transition-colors px-8 py-3  font-medium text-base shadow-lg shadow-rose-500/20">
                    Login
                </a>

            </div>
        </div>

    </div>
</x-main-layout>
