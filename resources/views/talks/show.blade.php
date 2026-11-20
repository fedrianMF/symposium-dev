<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $talk->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <p class="text-sm text-gray-500">
                        {{ ucfirst($talk->type->value) }}
                        @if ($talk->length)
                            &middot; {{ $talk->length }} {{ __('min') }}
                        @endif
                    </p>

                    <div>
                        <h3 class="font-semibold text-gray-800">{{ __('Abstract') }}</h3>
                        <p class="mt-1 whitespace-pre-line">{{ $talk->abstract ?: '—' }}</p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800">{{ __('Organizer notes') }}</h3>
                        <p class="mt-1 whitespace-pre-line">{{ $talk->organizer_notes ?: '—' }}</p>
                    </div>

                    <div class="flex items-center gap-6 text-sm">
                        <a href="{{ route('talks.index') }}" class="text-indigo-600 hover:underline">
                            &larr; {{ __('Back to talks') }}
                        </a>
                        <a href="{{ route('talks.edit', $talk) }}" class="underline">
                            {{ __('Edit this talk') }}
                        </a>
                        <x-delete-item :route="route('talks.destroy', $talk)" :text="__('Delete this talk')" class="text-red-600" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
