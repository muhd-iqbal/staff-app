@props(['id', 'txt'])
<!-- Modal -->
<div x-data="{ showModal : false }">
    <!-- Button -->
    <button @click="showModal = !showModal"
        class="px-4 py-2 text-sm bg-purple-500 rounded-xl border transition-colors duration-150 ease-linear border-gray-200 text-white focus:outline-none focus:ring-0 font-bold hover:bg-purple-800 focus:bg-indigo-50 focus:text-indigo">
        {{ __(strtoupper($txt)) }}</button>

    <!-- Modal Background -->
    <div x-show="showModal"
        class="fixed text-gray-500 flex items-center justify-center overflow-auto z-50 bg-black bg-opacity-40 left-0 right-0 top-0 bottom-0"
        x-transition:enter="transition ease duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <!-- Modal -->
        <div x-show="showModal"
            class="bg-white rounded-xl shadow-2xl p-6 sm:w-10/12 md:w-2/3 lg:w-1/2 mx-10"
            @click.away="showModal = false"
            x-transition:enter="transition ease duration-100 transform"
            x-transition:enter-start="opacity-0 scale-90 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease duration-100 transform"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-1">
            <!-- Title -->
            <!-- Buttons -->
            <div class="flex flex-col text-center gap-5 mt-5">
                <span class="font-bold block text-2xl mb-3 text-red-600">
                    {{ __('Pilihan Production') }} </span>
                <x-form.single-action
                    action='/orders/item/{{ $id }}/approved-production'
                    title='Production Gurun + Print List' color='blue' />
                <x-form.single-action
                    action='/orders/item/{{ $id }}/approved'
                    title='Production Gurun' color='purple' />
                <x-form.single-action
                    action='/orders/item/{{ $id }}/approved-guar'
                    title='Production Guar' color='pink' />
                <x-form.single-action
                    action='/orders/item/{{ $id }}/approved-subcon'
                    title='Subcon' color='yellow' />
            </div>
        </div>
    </div>
</div>
