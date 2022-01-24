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
                                    <div class="flex gap-2">
                                        <div class="flex-none">
                                            <a href="/customers/create" id="" title="Tambah Pelanggan"
                                                class="h-10 inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                +</a>
                                        </div>
                                        <div class="flex-grow"></div>
                                        <div class="flex flex-none md:justify-end">
                                            {{-- <label for="searchBox"
                                                class="text-sm font-medium text-gray-700 flex-wrap content-end hidden md:flex">CARIAN..</label> --}}
                                            <input type="text" id="searchBox" autocomplete="searchBox"
                                                placeholder="Cari..."
                                                class="w-1/2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-6 gap-2 mt-5">

                                        <x-form.select name="customer_id" label="Nama Pelanggan" class="py-3">
                                            <option selected disabled>Pilihan Pelanggan..</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ $customer->name . ' - ' . $customer->phone }}</option>
                                            @endforeach
                                        </x-form.select>
                                    </div>

                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-5 md:gap-2 mt-5 mx-7">
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
    <script>
        searchBox = document.querySelector("#searchBox");
        customerid = document.querySelector("#customer_id");
        var when = "keyup"; //You can change this to keydown, keypress or change

        searchBox.addEventListener("keyup", function(e) {
            var text = e.target.value; //searchBox value
            var options = customerid.options; //select options
            for (var i = 0; i < options.length; i++) {
                var option = options[i]; //current option
                var optionText = option.text; //option text ("Somalia")
                var lowerOptionText = optionText
                    .toLowerCase(); //option text lowercased for case insensitive testing
                var lowerText = text.toLowerCase(); //searchBox value lowercased for case insensitive testing
                var regex = new RegExp("^" + text, "i"); //regExp, explained in post
                var match = optionText.match(regex); //test if regExp is true
                var contains = lowerOptionText.indexOf(lowerText) != -
                    1; //test if searchBox value is contained by the option text
                if (match || contains) { //if one or the other goes through
                    option.selected = true; //select that option
                    return; //prevent other code inside this event from executing
                }
                searchBox.selectedIndex = 0; //if nothing matches it selects the default option
            }
        });
    </script>
</x-app-layout>
