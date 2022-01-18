@props(['name', 'label', 'value' => null, 'span' => null])

<div class="col-span-6 sm:col-span-{{ $span }}">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <select id="{{ $name }}" name="{{ $name }}" autocomplete="{{ $name }}"
        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        {{ $slot }}
    </select>
</div>
