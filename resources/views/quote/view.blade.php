<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ quote_num($quote->id) }}
        </h2>
    </x-slot>
    <x-modalbox>
        <!--Title-->
        <div class="flex justify-between items-center pb-3">
            <p class="text-2xl font-bold text-black">Tambah Item</p>
        </div>
        <!--Body-->
        <div class="my-5 text-black">
            <form action="/quote/{{ $quote->id }}/add-item" method="POST">
                @csrf
                <div class="grid grid-col-2">
                    <x-form.input name="product" label="Nama Produk" value="{{ old('product') }}"
                        class="mb-2" tags="required" />
                    <x-form.input name="quantity" label="Kuantiti" type="number" value="{{ old('amount') }}"
                        class="mb-2" tags="required" />
                    <x-form.input name="size" label="Saiz" value="{{ old('amount') }}" class="mb-2"
                        tags="required" />
                    <x-form.select name="measurement" label="Ukuran" class="mb-2">
                        @foreach ($measurements as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </x-form.select>
                    <x-form.input name="price" label="Harga Seunit" type="number" value="{{ old('amount') }}"
                        class="mb-2" tags="step=0.01 required" />
                </div>
                <x-button class="mt-3">Tambah</x-button>
            </form>
        </div>
        <!--Footer-->
        <div class="flex justify-end pt-2 gap-2">
            <button class="focus:outline-none modal-close px-4 bg-gray-400 text-black hover:bg-gray-300">Batal</button>
        </div>
    </x-modalbox>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-t-4">
                    <!-- start component -->
                    <div class="flex items-center justify-center">
                        <div class="grid bg-white rounded-lg shadow-xl w-full">
                            @if (auth()->user()->isAdmin)
                                <form action="/quote/{{ $quote->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <div class="text-right" title="Padam Order">
                                        <button type="submit" class=" text-red-500"
                                            onclick="return confirm('Padam quotation\nSila padam semua item terlebih dahulu.')">x</button>
                                    </div>
                                </form>
                            @endif
                            <div class="flex flex-col items-center">
                                <div class="flex">
                                    <h1 class="text-gray-600 font-bold md:text-2xl text-xl">{{ __('Quotation:') }}
                                        {{ quote_num($quote->id) }}</h1>
                                    <a href="{{ 'https://wa.me/6' . $quote->customer->phone }}">
                                        <img src="https://cdn.cdnlogo.com/logos/w/29/whatsapp-icon.svg" width="30"></a>
                                </div>
                                <div>
                                    <h2 class="text-gray-500 font-bold md:text-xl text-lg">
                                        {{ ucwords($quote->method) }}
                                        ({{ ucwords($quote->branch->shortname) }})</h2>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2">
                                <div class="mt-5 mx-7">
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('Nama Pelanggan: ') . $quote->customer->name }}
                                        <a href="/customer/{{ $quote->customer_id }}/edit?back=/quote/{{ $quote->id }}"
                                            class="lowercase bg-gray-600 text-white px-1 rounded hover:text-gray-200">edit</a>
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('No Telefon: ') . $quote->customer->phone }}
                                    </div>
                                    <div class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold">
                                        {{ __('Tarikh sebut harga: ') . date('d/m/Y', strtotime($quote->date)) }}
                                    </div>
                                </div>
                            </div>
                            <div
                                class='grid text-sm md:text-base grid-cols-2 md:grid-cols-3 gap-5 items-center justify-center p-5 pb-5'>
                                <div onclick="openModal()"
                                    class='w-auto cursor-pointer text-center bg-green-500 hover:bg-green-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Tambah Item') }}
                                </div>
                                <a href="/quote/{{ $quote->id }}/print"
                                    class='w-auto text-center bg-blue-500 hover:bg-blue-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Print') }}
                                </a>
                                @unless($quote->export_to_order)
                                <form action="/quote/{{ $quote->id }}/export" method="POST">
                                    @csrf
                                    <button onclick="return confirm('Pengesahan: export quotation ke order')" type="submit"
                                        class="bg-yellow-500 w-full text-center hover:bg-yellow-700 rounded-lg shadow-xl font-medium text-white px-4 py-2">
                                        Export ke Order
                                    </button>
                                </form>
                                @endunless
                                <a href="/quote"
                                    class='w-auto text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                    {{ __('Kembali') }}
                                </a>
                            </div>
                        </div>
                    </div> <!-- end components -->

                    <div class="flex flex-col text-left mt-2">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Item') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Saiz') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('KTT X Harga') }}
                                                </th>
                                                <th scope="col"
                                                    class=" px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ __('Jumlah') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($lists as $list)
                                                <tr>
                                                    <td class="py-4 whitespace-nowrap">
                                                        <div class="flex gap-3 ml-4 text-sm font-medium">
                                                            <form method="POST"
                                                                action="/quote/{{ $quote->id }}/{{ $list->id }}/delete">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="text-red-500 font-bold"
                                                                    onclick="return confirm('Padam {{ $list->product }}')">X</button>
                                                            </form>
                                                            {{ $list->product }}

                                                            <a href="/quote/{{ $list->id }}/edit"
                                                                class="bg-gray-500 text-sm px-1 rounded-sm text-white cursor-pointer hover:bg-gray-700">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $list->size }}
                                                        {{ $list->measurement ? '(' . $list->measurement . ')' : '' }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $list->quantity . ' X ' . RM($list->price) }}</td>
                                                    <td class="text-center">
                                                        {{ RM($list->total) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 border border-gray-200 rounded-lg shadow-lg p-4 bg-white">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <div>Tambahan: <span
                                class="bg-gray-500 text-sm px-1 rounded-sm text-white cursor-pointer hover:bg-gray-700"
                                onclick="toggleModalShipping()">edit</span></div>
                        <div>Penghantaran: RM{{ RM($quote->shipping) }}</div>
                        <div>Diskaun: RM{{ RM($quote->discount) }}</div>
                        <div>Jumlah: RM{{ RM($quote->grand_total) }}</div>
                    </div>

                    <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal-shipping">
                        <div
                            class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-900 opacity-75" />
                            </div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                            <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                <form action="/orders/{{ $quote->id }}/additional" method="POST">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        @csrf
                                        @method('PATCH')
                                        <label>Caj Penghantaran</label>
                                        <input type="number" step="0.01" class="w-full bg-gray-100 p-2 mt-2 mb-3"
                                            name="shipping" value="{{ RM($quote->shipping) }}" />
                                        <label>Jumlah Diskaun</label>
                                        <input type="text" class="w-full bg-gray-100 p-2 mt-2 mb-3" name="discount"
                                            value="{{ RM($quote->discount) }}" />
                                    </div>
                                    <div class="bg-gray-200 px-4 py-3 text-right">
                                        <button type="button"
                                            class="py-2 px-4 bg-red-600 text-white rounded hover:bg-gray-700 mr-2"
                                            onclick="toggleModalShipping()"> Batal</button>
                                        <button type="submit"
                                            class="py-2 px-4 bg-green-500 text-white rounded hover:bg-blue-700 mr-2"
                                            @if ($quote->paid == $quote->grand_total) onclick="return confirm('Pesanan telah dibayar sepenuhnya! Teruskan?  ')" @endif>
                                            Kemaskini</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleModalShipping() {
            document.getElementById('modal-shipping').classList.toggle('hidden')
        }
    </script>
</x-app-layout>
