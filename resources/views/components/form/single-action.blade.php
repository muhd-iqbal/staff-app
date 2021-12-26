@props(['action', 'title', 'color'=>'gray'])

<form action="{{ $action }}" method="POST">
    @csrf
    <x-button class="h-10 bg-{{ $color }}-800 hover:bg-{{ $color }}-700 active:bg-{{ $color }}-900 focus:border-{{ $color }}-900 ring-{{ $color }}-300">{{ __($title) }}</x-button>
</form>

