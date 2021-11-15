@props(['name', 'label', 'type' => 'text', 'value' => null, 'span' => null])

<div class="col-span-6 sm:col-span-{{ $span }}">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ ucwords($label) }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" autocomplete="{{ $name }}" value="{{ $value == null ? old($name):$value }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>


