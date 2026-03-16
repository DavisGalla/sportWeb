<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    
                    <div class="mt-6 space-y-4">
                        @if(auth()->user()->google_access_token)
                            <div class="flex items-center space-x-3">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-green-600 dark:text-green-400">Google Calendar Connected</span>
                            </div>
                            <a href="{{ route('calendar.index') }}" class="inline-block mt-3 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                                View Calendar
                            </a>
                        @else
                            <p class="text-gray-600 dark:text-gray-400 mb-3">Connect your Google Calendar to get started:</p>
                            <a href="/auth/google" class="inline-block px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition">
                                Connect Google Calendar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
