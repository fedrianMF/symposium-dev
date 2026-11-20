<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Talks') }}
            </h2>
            <a href="{{ route('talks.create') }}" class="text-sm text-indigo-600 hover:underline">
                {{ __('Nuevo talk') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($talks->isEmpty())
                        <p class="text-gray-600">{{ __('You have no talks yet.') }}</p>
                    @else
                        <ul class="divide-y divide-gray-100">
                            @foreach ($talks as $talk)
                                <li class="py-3 flex items-center justify-between">
                                    <a href="{{ route('talks.show', $talk) }}" class="text-indigo-600 hover:underline">
                                        {{ $talk->title }}
                                    </a>
                                    <span class="text-sm text-gray-500">
                                        {{ collect([$talk->length, $talk->type?->value])->filter()->join(' / ') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
