<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            PB / Personal Best Tracker
        </h2>
    </x-slot>

    <div class="py-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 mb-6">

            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">Add new PB</h3>

            <form method="POST" action="{{ route('pbs.store') }}">
                @csrf
                <div class="flex flex-wrap gap-3">
                    <div class="flex-[2] min-w-[140px]">
                        <input
                            type="text"
                            name="exercise"
                            placeholder="Exercise"
                            value="{{ old('exercise') }}"
                            list="exercise-suggestions"
                            required
                            class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500"
                        />
                        @error('exercise')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex-1 min-w-[90px]">
                        <input
                            type="number"
                            name="weight"
                            placeholder="kg"
                            value="{{ old('weight') }}"
                            min="0"
                            step="0.5"
                            required
                            class="w-full h-10 px-3 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500"
                        />
                        @error('weight')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="h-10 px-5 text-sm font-medium rounded-lg bg-gray-900 dark:bg-white text-white dark:text-gray-900 hover:opacity-80 transition"
                    >
                        + Add
                    </button>
                </div>
            </form>
        </div>

        @if ($bests->isEmpty())
            <p class="text-center text-sm text-gray-400 py-12">No PBs yet — add your first one above.</p>
        @else
            <div class="flex flex-col gap-3">
                @foreach ($bests as $best)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4"
                        x-data="{ editing: false }"
                    >
                        <div class="flex items-center gap-4" x-show="!editing">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $best->exercise }}</p>
                            </div>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                {{ $best->weight + 0 }} <span class="text-sm font-normal text-gray-400">kg</span>
                            </p>
                            <button
                                @click="editing = true"
                                class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-400 transition text-sm"
                                title="Edit"
                            >✎</button>
                            <form method="POST" action="{{ route('pbs.destroy', $best) }}"
                                onsubmit="return confirm('Delete this PB?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 dark:border-gray-600 text-gray-400 hover:text-red-500 hover:border-red-300 transition text-sm"
                                    title="Delete"
                                >✕</button>
                            </form>
                        </div>
   
                        <form method="POST" action="{{ route('pbs.update', $best) }}" x-show="editing">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-center gap-3 flex-wrap">
                                <p class="font-medium text-gray-900 dark:text-gray-100 flex-1">{{ $best->exercise }}</p>
                                <input
                                    type="number"
                                    name="weight"
                                    value="{{ $best->weight + 0 }}"
                                    min="0"
                                    step="0.5"
                                    required
                                    class="w-24 h-9 px-3 text-sm rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300"
                                />
                                <button
                                    type="submit"
                                    class="h-9 px-4 text-sm font-medium rounded-lg bg-gray-900 dark:bg-white text-white dark:text-gray-900 hover:opacity-80 transition"
                                >Save</button>
                                <button
                                    type="button"
                                    @click="editing = false"
                                    class="h-9 px-3 text-sm rounded-lg border border-gray-200 dark:border-gray-600 text-gray-500 hover:text-gray-700 transition"
                                >Cancel</button>
                            </div>
                        </form>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>