<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Item Pesanan') }}
        </h2>
        <x-head.tinymce-config />
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- start component -->
                    <form action="/orders/{{ $order->id }}/add-item" method="post">
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
                                    <div class="mt-3 grid md:grid-cols-4 gap-3">
                                        <input
                                            class="py-2 px-3 md:col-span-2 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="text" name="product" placeholder="Masukkan nama produk"
                                            value="{{ old('product') }}" />
                                        <input
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="text" name="price" placeholder="Harga Seunit" value="{{ old('price') }}" />
                                        <input
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="number" step=1 name="quantity" placeholder="Kuantiti"
                                            value="{{ old('quantity') }}" />
                                        <input
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="text" name="size" placeholder="Saiz Item"
                                            value="{{ old('size') }}" />

                                        <input
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="text" name="status" placeholder="Status"
                                            value="{{ old('design_status') }}" />

                                        
                                        <select name="measurement" id="measurement"
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                            @foreach ($measurements as $k => $v)
                                                <option value="{{ $k }}">{{ $v }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <div class="flex justify-center items-center hidden">
                                            <input type="checkbox" name="printing_list" id="printing_list">
                                            <label for="printing_list" class="mx-3"> Item masuk ke print list?
                                            </label>
                                        </div> --}}
                                        <input
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="text" name="finishing" placeholder="Nota / Finishing"
                                            value="{{ old('finishing') }}" />
                                        <div class="flex justify-center items-center">
                                            <input type="checkbox" name="is_urgent" id="is_urgent">
                                            <label for="is_urgent" class="mx-3 text-red-500"> Urgent?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 mt-5 mx-7">
                                    <label
                                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold mb-1">Nota</label>

                                    <textarea name="remarks" id="mytextarea" placeholder="Remarks">{{ old('remarks') }}</textarea>

                                </div>

                                <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                                    <a href="/orders/view/{{ $order->id }}"
                                        class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Batal
                                    </a>
                                    <button
                                        class='w-auto bg-purple-500 hover:bg-purple-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Tambah Item
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
