@props(['route', 'text'])

<form method="POST" action="{{ $route }}">
    @csrf
    @method('DELETE')

    <a href="{{ $route }}" onclick="event.preventDefault(); this.closest('form').submit();"
        {{ $attributes->merge(['class' => 'underline']) }}>
        {{ $text }}
    </a>
</form>
