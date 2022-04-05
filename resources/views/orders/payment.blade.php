<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Bayaran Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5">
                    <div class="text-center text-xl ">
                        {{ __('Order ID: ') . order_num($order->id) }}
                    </div>
                    <div class="text-center">
                        <div>{{ __('Jumlah: ') . 'RM' . RM($order->grand_total) }}</div>
                        <div>{{ __('Telah dibayar: ') . 'RM' . RM($order->paid) }}</div>
                        <div class="mb-3">{{ __('Baki: ') . 'RM' . RM($order->due) }}
                        </div>
                        <a href="/orders/view/{{ $order->id }}"
                            class='text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl text-white px-4 py-2'>
                            {{ __('Kembali ke pesanan') }}
                        </a>
                    </div>

                    <div class="grid grid-cols-2 mt-2">
                        <div>
                            @if ($order->due > 0)
                                <div>
                                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                    <div class="flex">
                                        <button
                                            class="bg-green-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="button" onclick="toggleModal('modal-id')">
                                            {{ __(strtoupper('Tambah Rekod Bayaran')) }}
                                        </button>
                                    </div>

                                    <div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
                                        id="modal-id">
                                        <div class="relative w-auto md:w-2/3 my-6 mx-auto max-w-3xl">
                                            <!--content-->
                                            <div
                                                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                                                <!--header-->
                                                <div
                                                    class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                                                    <h3 class="text-3xl font-semibold">
                                                        {{ __('Maklumat Pembayaran') }}
                                                    </h3>
                                                </div>
                                                <!--body-->
                                                <div class="relative p-6 flex-auto">
                                                    <form action="/orders/{{ $order->id }}/payments" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="grid grid-flow-row gap-3">
                                                            <div class="grid grid-cols-2">
                                                                <label for="amount">{{ __('Amaun Bayaran') }}
                                                                    <span
                                                                        class="bg-yellow-300 p-1 text-xs rounded-md hover:bg-yellow-500 cursor-pointer"
                                                                        onclick="set_pay(50)">{!! __('50&#37;') !!}</span>
                                                                    <span
                                                                        class="bg-yellow-300 p-1 text-xs rounded-md hover:bg-yellow-500 cursor-pointer"
                                                                        onclick="set_pay(100)">{!! __('100&#37;') !!}</span>
                                                                </label>
                                                                <script>
                                                                    function set_pay(percent) {
                                                                        document.getElementById('amount').value = ({{ $order->due / 100 }} * percent / 100).toFixed(2);
                                                                    }
                                                                </script>
                                                                <input type="number" name="amount" id="amount"
                                                                    step="0.01" value="{{ $order->due / 100 }}"
                                                                    placeholder="Amaun">
                                                            </div>
                                                            <div class="grid grid-cols-2">
                                                                <label
                                                                    for="payment_method">{{ __('Kaedah Bayaran') }}</label>
                                                                <select name="payment_method" id="payment_method"
                                                                    class="float-right">
                                                                    @foreach ($payment_method as $key => $value)
                                                                        <option value="{{ $key }}">
                                                                            {{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="grid grid-cols-2">
                                                                <label for="reference">{{ __('No Rujukan') }}</label>
                                                                <input type="text" name="reference" id="reference"
                                                                    placeholder="Rujukan">
                                                            </div>
                                                            <div class="grid grid-cols-2">
                                                                <label for="branch_id">{{ __('Bayar di') }}</label>
                                                                <select name="branch_id" id="branch_id">
                                                                    @foreach ($branches as $branch)
                                                                        <option value="{{ $branch->id }}"
                                                                            {{ auth()->user()->branch_id == $branch->id ? 'selected' : '' }}>
                                                                            {{ ucfirst($branch->shortname) }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="grid grid-cols-2">
                                                                <label for="time">{{ __('Masa Bayaran') }}</label>
                                                                <div class="grid grid-cols-2">
                                                                    <input type="date" name="date" id="date"
                                                                        placeholder="Masa Pembayaran"
                                                                        value="{{ date('Y-m-d') }}">
                                                                    <input type="time" name="time" id="time"
                                                                        placeholder="Masa Pembayaran"
                                                                        value="{{ date('H:i:s') }}">
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-2">
                                                                <label
                                                                    for="attachment">{{ __('Slip / Lampiran') }}</label>
                                                                <div class="grid grid-cols-1">
                                                                    <input type="file" name="attachment"
                                                                        id="attachment">
                                                                </div>
                                                            </div>
                                                            <div class="flex justify-end">
                                                                <button type="submit"
                                                                    class="p-2 px-4 bg-green-500 text-white rounded-md">Rekod</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!--footer-->
                                                <div
                                                    class="flex items-center justify-center p-6 border-t border-solid border-blueGray-200 rounded-b">
                                                    <button
                                                        class="w-full text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                                        type="button" onclick="toggleModal('modal-id')">
                                                        {{ __('Batal') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="text-right">
                            <button onclick="display_receipt({{ $order->id }})"
                                class="bg-yellow-500 hover:bg-yellow-400 p-3 px-5 rounded">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-5">
                <div class="text-center">
                    {{ __('Senarai Pembayaran') }}
                </div>
                <div class="mt-5">
                    <div class="flex flex-col mt-8">
                        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                            <div>
                                @unless(count($payments))
                                    <div class="text-center">
                                        {{ __('Tiada') }}
                                    </div>
                                @else
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        @foreach ($payments as $payment)
                                            <div class="grid col-span-1 shadow p-3">
                                                <div>
                                                    <div>ID: {{ payment_num($payment->id) }}</div>
                                                    <div>Rujukan: {{ $payment->reference }}</div>
                                                    <div>Kaedah: {{ $payment_method[$payment->payment_method] }}</div>
                                                    <div>Lokasi: {{ ucfirst($payment->branch->shortname) }}</div>
                                                    <div>Masa: {{ date('d/m/Y H:i A', strtotime($payment->time)) }}</div>
                                                    <div>Jumlah: RM{{ RM($payment->amount) }}</div>
                                                    @if ($payment->attachment)
                                                        <a href="{{ asset('storage/' . $payment->attachment) }}"
                                                            target="_blank" class="text-blue-600 underline">Lampiran</a>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    <form
                                                        action="/orders/{{ $order->id }}/payments/{{ $payment->id }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit"
                                                            onclick="return confirm('Padam bayaran {{ payment_num($payment->id) }}?')"
                                                            class="text-red-500 cursor-pointer">x</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endunless

                                <div class="hidden flex items-center justify-center fixed left-0 bottom-0 w-full h-full border-4"
                                    id="modal-payment">
                                    <div class="bg-white rounded-lg w-5/6 md:w-1/2">
                                        <div class="flex flex-col items-start p-4">
                                            <iframe src="" class="w-full" style="height: 90vh;">
                                                <p>Your browser does not support iframes.</p>
                                            </iframe>
                                            <div class="flex items-center w-full">
                                                <svg onclick="toggleModal('modal-payment')"
                                                    class="ml-auto fill-current text-white bg-red-700 w-8 h-8 cursor-pointer"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                                                    <path
                                                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById(modalID + "-backdrop").classList.toggle("flex");
        }

        function display_receipt(order) {
            // e.preventDefault();
            // $("#modal-payment").show();
            $("iframe").attr("src", "/payment/" + order);
            toggleModal('modal-payment');
        }
    </script>
</x-app-layout>
