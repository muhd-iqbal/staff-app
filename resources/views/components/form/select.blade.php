@props(['name', 'label', 'value' => null, 'span' => null, 'class' => null])

<div class="col-span-6 sm:col-span-{{ $span }}">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ strtoupper($label) }}</label>
    <select id="{{ $name }}" name="{{ $name }}" autocomplete="{{ $name }}"
        class="mt-1 block w-full py-2 px-3 border border-purple-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm {{ $class }}">
        {{ $slot }}
    </select>
</div>
