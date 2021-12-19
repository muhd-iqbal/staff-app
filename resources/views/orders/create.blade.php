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
                    <form action="/orders/create" method="post">
                        @csrf
                        <div class="flex items-center justify-center">
                            <div class="grid bg-white rounded-lg shadow-xl w-full">

                                <div class="flex justify-center">
                                    <div class="flex">
                                        <h1 class="text-gray-600 font-bold md:text-2xl text-xl">Order Form</h1>
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
                                    <label
                                        class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Nama
                                        Pelanggan</label>
                                    <input
                                        class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                        type="text" name="customer_name" placeholder="Masukkan nama pelanggan"
                                        value="{{ old('customer_name') }}" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8 mt-5 mx-7">
                                    <div class="grid grid-cols-1">
                                        <label
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">No
                                            Telefon</label>
                                        <input
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="text" name="customer_phone" placeholder="No Telefon Pelanggan"
                                            value="{{ old('customer_phone') }}" />
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Tarikh</label>
                                        <input
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="date" name="date" value="{{ date('Y-m-d') }}" readonly />
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Deadline</label>
                                        <input
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="date" name="dateline" value="{{ old('dateline') }}" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 mt-5 mx-7">
                                    <div class="grid grid-cols-1">
                                        <label
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Pesanan</label>
                                        <select name="method"
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                            <option value="walkin" {{ old('method') == 'walkin' ? 'selected' : '' }}>
                                                Walk-in
                                            </option>
                                            <option value="online" {{ old('method') == 'online' ? 'selected' : '' }}>
                                                Online
                                            </option>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-1">
                                        <label
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Lokasi</label>
                                        <select name="location"
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                            <option value="gurun" {{ old('method') == 'gurun' ? 'selected' : '' }}>
                                                Gurun
                                            </option>
                                            <option value="guar" {{ old('method') == 'guar' ? 'selected' : '' }}>
                                                Guar
                                            </option>
                                        </select>
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
                                    <a href="/orders"
                                        class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Batal
                                    </a>
                                    <button
                                        class='w-auto bg-purple-500 hover:bg-purple-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Tambah Pesanan
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
