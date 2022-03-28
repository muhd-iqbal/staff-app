<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Semasa') }}
            <span class="text-sm text-red-500">(Experiment)</span>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="bg-white mx-auto border border-gray-200">
                            <ul class="shadow-box">
                                @foreach ($users as $designer)

                                    <li class="relative border-b border-gray-200" x-data="{selected:null}">

                                        <button type="button" class="w-full px-8 py-3 text-left"
                                            @click="selected !== 1 ? selected = 1 : selected = null">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    {{ $designer->name }}
                                                </div>
                                                <div
                                                    class="inline-flex border-2 border-yellow-900 text-black rounded-full h-6 p-2 justify-center items-center text-right">
                                                    {{ $designer->order_item->count() ? $designer->order_item->count() : 'Tiada' }} design.
                                                </div>
                                            </div>
                                        </button>

                                        <div class="relative overflow-hidden transition-all max-h-0 duration-700"
                                            style="" x-ref="container1"
                                            x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                                            <div class="p-6 border-t-2">
                                                <ol class="ml-5 list-decimal">
                                                    @foreach ($designer->order_item as $item)
                                                        <li>{{ $item->product }}</li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <x-dashboard-link />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
</x-app-layout>
