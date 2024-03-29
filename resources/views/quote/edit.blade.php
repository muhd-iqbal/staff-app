<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kemaskini Item') }}
        </h2>
        <x-head.tinymce-config />
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- start component -->
                    <form action="/quote/item/{{ $item->id }}/update-item" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="flex items-center justify-center">
                            <div class="grid bg-white rounded-lg shadow-xl w-full">

                                <div class="flex justify-center">
                                    <div class="flex">
                                        <h1 class="text-gray-600 font-bold md:text-2xl text-xl"></h1>
                                    </div>
                                </div>

                                @if ($errors->any())
                                    <div class="bg-red-500 mt-5 mx-7">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 mt-5 mx-7">
                                    <div class="mt-3 grid md:grid-cols-12 gap-3">
                                        <x-form.input name="product" label="Nama Produk" 
                                            value="{!! $item->product !!}" />

                                        <x-form.input name="quantity" label="Kuantiti" type="number" 
                                            value="{{ $item->quantity }}" />

                                            <x-form.input name="size" label="Saiz" value="{!! $item->size !!}" span=3 />

                                        <div class="col-span-3">
                                            <label for="measurement"
                                                class="block text-sm font-medium text-gray-700">Ukuran</label>
                                            <select name="measurement" id="measurement"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                @foreach ($measurements as $k => $v)
                                                    <option value="{{ $k }}"
                                                        {{ $item->measurement == $k ? 'selected' : '' }}>
                                                        {{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <x-form.input name="price" label="Harga Seunit"
                                            value="{{ $item->price / 100 }}" span=3 />
                                    </div>
                                </div>
                                <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                                    <a href="/quote/item/{{ $item->id }}"
                                        class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Batal
                                    </a>
                                    <button
                                        class='w-auto bg-pink-500 hover:bg-pink-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Kemaskini Item
                                    </button>
                                </div>
                            </div>
                        </div> <!-- end components -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
