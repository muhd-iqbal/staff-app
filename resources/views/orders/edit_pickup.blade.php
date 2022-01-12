<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Pesanan') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- start component -->
                    <form action="/orders/pickup/{{ $order->id }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center justify-center">
                            <div class="grid bg-white rounded-lg shadow-xl w-full">

                                <div class="flex justify-center">
                                    <div class="flex">
                                        <h1 class="text-gray-600 font-bold md:text-2xl text-xl">
                                            {{ __('Kemaskini Order: ') . \App\Http\Controllers\Controller::order_num($order->id) }}
                                        </h1>
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
                                <small class="text-red-500">* Kemaskini setelah order telah pickup/kurier</small>
                                    <label
                                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nama
                                        Pelanggan</label>
                                    <input
                                        class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                        type="text" name="customer_name" placeholder="Masukkan nama pelanggan"
                                        value="{{ $order->customer_name }}" disabled />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                                    <div class="grid grid-cols-1">
                                        <label
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Pickup</label>
                                        <select name="pickup_type" class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" >
                                            <option value="Gurun">Gurun</option>
                                            <option value="Guar">Guar</option>
                                            <option value="Kurier">Kurier</option>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nota / Track</label>
                                        <input name="pickup" value="{{ old('pickup') }}"
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" />
                                    </div>
                                </div>
                                {{-- <div class="grid grid-cols-1 mt-5 mx-7">
                                    <label
                                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Produk</label>
                                    <div class="grid grid-cols-8 gap-4">
                                        @foreach ($products as $color => $product)
                                            <label class="col-span-3 md:col-span-2 mt-3">
                                                <input type="checkbox"
                                                    class="form-checkbox h-5 w-5 text-{{ $color }}-600"
                                                    name="product[]" value="{{ $product }}"
                                                    {{ (is_array(old('product')) and in_array($product, old('product'))) ? ' checked' : '' }} />
                                                <span class="ml-2 text-gray-700">{{ $product }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 mt-5 mx-7">
                                    <label
                                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold mb-1">Remarks</label>

                                    <textarea name="remarks" id="mytextarea"></textarea>

                                </div> --}}

                                <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                                    <a href="/orders/view/{{ $order->id }}"
                                        class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Batal
                                    </a>
                                    <button
                                        class='w-auto bg-purple-500 hover:bg-purple-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Kemaskini
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
