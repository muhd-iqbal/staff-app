<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah sebut harga') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- start component -->
                    <form action="/quote/create" method="post">
                        @csrf
                        <div class="flex items-center justify-center">
                            <div class="grid bg-white rounded-lg shadow-xl w-full">

                                <div class="flex justify-center">
                                    <div class="flex">
                                        <h1 class="text-gray-600 font-bold md:text-2xl text-xl">Form Quotation</h1>
                                    </div>
                                </div>

                                @if ($errors->any())
                                    <div class="mt-5 mx-7">
                                        <ul class="text-red-600 list-disc">
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
                                                class="h-10 inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest [...]"
                                                +</a>
                                        </div>
                                        <div class="flex-grow"></div>
                                        <div class="flex flex-none md:justify-end">
                                            <input type="text" id="searchBox" autocomplete="searchBox"
                                                placeholder="Cari..."
                                                class="w-1/2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-6 gap-2 mt-5">

                                        <x-form.select id="customer_id" name="customer_id" label="Nama Pelanggan" class="py-3">
                                            <option selected disabled>Pilihan Pelanggan..</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ $customer->name . ' - ' . ($customer->company_name ?? '-') . ' - ' . $customer->phone }}
                                                </option>
                                            @endforeach
                                        </x-form.select>
                                    </div>

                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-2 mt-5 mx-7">
                                    <div class="grid grid-cols-1">
                                        <label
                                            class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">Tarikh</label>
                                        <input
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                            type="date" name="date" value="{{ date('Y-m-d') }}" readonly />
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
                                        <select name="branch_id"
                                            class="py-2 px-3 rounded-lg border-2 border-purple-300 mt-1 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ ucwords($branch->shortname) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                                    <a href="/quote"
                                        class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Batal
                                    </a>
                                    <button
                                        class='w-auto bg-purple-500 hover:bg-purple-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                        Tambah Quotation
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
        const searchBox = document.querySelector("#searchBox");
        const customerSelect = document.querySelector("#customer_id");

        searchBox.addEventListener("keyup", function(e) {
            const text = e.target.value.trim();
            const options = customerSelect.options;

            // If search box is empty, reset to default option
            if (!text) {
                customerSelect.selectedIndex = 0;
                return;
            }

            // Try to find the first matching option (by contains or regex)
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                const optionText = option.text;
                const lowerOptionText = optionText.toLowerCase();
                const lowerText = text.toLowerCase();
                const regex = new RegExp(text, "i");
                const match = optionText.match(regex);
                const contains = lowerOptionText.indexOf(lowerText) !== -1;

                if (match || contains) {
                    option.selected = true;
                    return;
                }
            }

            // No match found => reset to default
            customerSelect.selectedIndex = 0;
        });
    </script>
</x-app-layout>
