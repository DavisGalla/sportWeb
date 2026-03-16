<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-2xl p-8">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Add Event</h2>
                        @if(request('date'))
                            <p class="text-sm text-gray-500 mt-0.5">
                                {{ \Carbon\Carbon::parse(request('date'))->format('l, F j, Y') }}
                            </p>
                        @endif
                    </div>
                    <a href="{{ route('calendar.index') }}"
                       class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 transition-colors text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                </div>

                {{-- Validation errors --}}
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('calendar.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="summary" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Event Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="summary" id="summary"
                               required
                               value="{{ old('summary') }}"
                               placeholder="e.g. Team standup"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all @error('summary') border-red-400 @enderror">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Description
                        </label>
                        <textarea name="description" id="description"
                                  rows="3"
                                  placeholder="Optional details..."
                                  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 placeholder-gray-400 transition-all resize-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Start <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="start_time" id="start_time"
                                   required
                                   value="{{ old('start_time', request('date') ? request('date').'T09:00' : '') }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all text-sm @error('start_time') border-red-400 @enderror">
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                End <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="end_time" id="end_time"
                                   required
                                   value="{{ old('end_time', request('date') ? request('date').'T10:00' : '') }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-800 transition-all text-sm @error('end_time') border-red-400 @enderror">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('calendar.index') }}"
                           class="flex-1 text-center px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                                class="flex-1 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors shadow-sm shadow-blue-200">
                            Create Event
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>