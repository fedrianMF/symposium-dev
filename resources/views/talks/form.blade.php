{{-- Campos compartidos por create y edit. Espera $talk (vacío en create) y $submitLabel. --}}
<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $talk->title)" required
        autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('title')" />
</div>

<div>
    <x-input-label for="type" :value="__('Type')" />
    <select id="type" name="type" required
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        @foreach (\App\Enums\TalkType::cases() as $type)
            <option value="{{ $type->value }}" @selected(old('type', $talk->type?->value) === $type->value)>
                {{ ucfirst($type->value) }}
            </option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('type')" />
</div>

<div>
    <x-input-label for="length" :value="__('Length (minutes)')" />
    <x-text-input id="length" name="length" type="text" class="mt-1 block w-full" :value="old('length', $talk->length)" />
    <x-input-error class="mt-2" :messages="$errors->get('length')" />
</div>

<div>
    <x-input-label for="abstract" :value="__('Abstract')" />
    <textarea id="abstract" name="abstract" rows="5"
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('abstract', $talk->abstract) }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('abstract')" />
</div>

<div>
    <x-input-label for="organizer_notes" :value="__('Organizer notes')" />
    <textarea id="organizer_notes" name="organizer_notes" rows="3"
        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('organizer_notes', $talk->organizer_notes) }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('organizer_notes')" />
</div>

<div class="flex items-center gap-4">
    <x-primary-button>{{ $submitLabel }}</x-primary-button>
    <a href="{{ $talk->exists ? route('talks.show', $talk) : route('talks.index') }}"
        class="text-sm text-gray-600 hover:underline">
        {{ __('Cancel') }}
    </a>
</div>
