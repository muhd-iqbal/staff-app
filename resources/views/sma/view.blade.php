<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Order ID: ' . $order[0]->id . " ($branch)" }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <button id="show" onclick="show()" class="m-5 bg-gray-700 text-white p-2 px-3 rounded shadow">Lihat
                    Info</button>
                <div class="m-5">
                    <table class="table-auto w-full border-collapse">
                        <tr>
                            <th class="border">Bil</th>
                            <th class="border">Description</th>
                            <th class="border">Unit Price</th>
                            <th class="border">Quantity</th>
                            <th class="border">Subtotal</th>
                        </tr>
                        @foreach ($items as $item)
                            <tr class="text-center">
                                <td class="border">{{ $loop->iteration }}</td>
                                <td class="border">{{ $item->product_code }} - {{ $item->product_name }}</td>
                                <td class="border">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="border">{{ number_format($item->quantity, 2) }}</td>
                                <td class="border">{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="hidden m-5 grid grid-cols-2 gap-2" id="detail">
                    <div class="border p-2 rounded shadow">
                        @foreach ($order[0] as $key => $value)
                            @if ($value != null)
                                <span class="text-gray-500">{{ ucwords(str_replace('_', ' ', $key)) }}:</span> <span
                                    class=" font-bold truncate ...">{{ $value }}</span> <br>
                            @endif
                        @endforeach
                    </div>
                    <div>
                        <div class="border p-2 bg-gray-100 rounded shadow">
                            <p class="font-bold uppercase">Customer</p>
                            @foreach ($cust[0] as $key => $value)
                                @if ($value != null)
                                    <span class="text-gray-500">{{ ucwords(str_replace('_', ' ', $key)) }}:</span> <span
                                        class=" font-bold">{{ $value }}</span> <br>
                                @endif
                            @endforeach
                        </div>
                        @foreach ($pays as $value)
                            <div class="my-5 border p-2 bg-green-100 rounded shadow">
                                <span class="text-gray-500">Payment ID: </span><span
                                    class=" font-bold">{{ $value->id }}</span> <br>
                                <span class="text-gray-500">Date: </span><span
                                    class=" font-bold">{{ $value->date }}</span> <br>
                                <span class="text-gray-500">Reference No: </span><span
                                    class=" font-bold">{{ $value->reference_no }}</span> <br>
                                <span class="text-gray-500">Paid By: </span><span
                                    class=" font-bold">{{ $value->paid_by }}</span> <br>
                                <span class="text-gray-500">Amount: </span><span
                                    class=" font-bold">{{ number_format($value->amount, 2) }}</span> <br>
                            </div>
                        @endforeach
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="#" class="bg-yellow-400 p-2 px-3 border rounded shadow" onclick="history.back(); return false;">Kembali</a>
            </div>
        </div>
    </div>
    <script>
        function show() {
            let element = document.getElementById("detail");
            let x = document.getElementById("show");

            element.classList.toggle("block");
            element.classList.toggle("hidden");
            if (x.innerHTML === "Tutup Info") {
                x.innerHTML = "Lihat Info";
            } else {
                x.innerHTML = "Tutup Info";
            }
        }
    </script>
</x-app-layout>
