<x-guest-layout>
    <div class="mx-auto p-3" style="max-width: 148mm; background: ">
        <div class="flex items-center justify-between mb-8 px-3">

            <div class="text-center w-full">
                <span class="font-bold text-2xl uppercase">{{ strtoupper($order->branch->name) }}</span><br />
                {{ strtoupper($order->branch->address) }}<br />
                Hubungi: {{ phone_format($order->branch->phone_1) }} / admin&#x40;inspirazs.com.my<br />
            </div>
        </div>

        <div class="flex justify-between mb-1 px-3">
            <div class="">
                <span>Rujukan: {{ order_num($order->id) }}</span><br />
                @if ($order->customer->organisation)
                    {{ strtoupper($order->customer->organisation) }}
                @else
                    {{ strtoupper($order->customer->name) }}
                @endif
                <br />Tel: {{ phone_format($order->customer->phone) }}
                @if ($order->customer->organisation)
                    <br />u/p: {{ $order->customer->name }}
                @endif
            </div>

            <div>
                <span>Tarikh</span>: {{ date('d/m/Y', strtotime($order->created_at)) }}<br />
                <span>Masa</span>: {{ date('H:i A', strtotime($order->created_at)) }}<br />

            </div>
        </div>

        <div class="border border-t border-gray-400 mb-1 px-3"></div>

        @foreach ($order->order_item as $item)
            <div class="flex justify-between mb-1 px-3 py-2 border-dashed border-b border-gray-500">
                <div>
                    #{{ $loop->iteration . ': ' . strtoupper($item->product) . ' ' . $item->size }} {{ $item->measurement? ' (' . $measurements[$item->measurement] .')':"" }}<br />
                    {{ $item->quantity . ' X RM' . RM($item->price) }}
                </div>
                <div class="text-right font-medium">{{ 'RM' . RM($item->total) }}</div>
            </div>
        @endforeach
        @if ($order->shipping)
            <div class="flex justify-between items-center mb-2 px-3">
                <div class="text-base leading-none"><span class="">Penghantaran</span>:</div>
                <div class="text-base text-right font-medium">
                    {{ __('RM') . RM($order->shipping) }} </div>
            </div>
        @endif
        @if ($order->discount)
            <div class="flex justify-between items-center mb-2 px-3">
                <div class="text-base leading-none"><span class="">Diskaun</span>:</div>
                <div class="text-base text-right font-medium">
                    {{ __('RM') . RM($order->discount) }} </div>
            </div>
        @endif

        <div class="flex justify-between items-center mb-2 px-3">
            <div class="text-base leading-none"><span class="">Jumlah</span>:</div>
            <div class="text-base text-right font-medium">
                {{ __('RM') . RM($order->grand_total) }} </div>
        </div>

        @if ($order->paid)
            @foreach ($order->payment as $payment)
                <div class="flex justify-between items-center mb-2 px-3">
                    <div class="leading-none capitalize"><span
                            class="text-sm">{{ $payment_method[$payment->payment_method] . ' @ ' . date('d/m/Y', strtotime($payment->time)) }}</span>:
                    </div>
                    <div class="text-sm text-right font-medium">
                        {{ __('RM') . RM($payment->amount) }}
                    </div>
                </div>
            @endforeach
            <div class="flex justify-between items-center mb-2 px-3">
                <div class="text-base leading-none"><span class="">Baki</span>:</div>
                <div class="text-base text-right font-medium">
                    {{ __('RM') . RM($order->due) }} </div>
            </div>
        @endif
        @if ($order->due)
            <div class="my-4 px-3 text-center">
                <span>Buat bayaran ke {{ $order->branch->bank_account_1 }} dengan Rujukan
                    {{ order_num($order->id) }}
            </div>
        @endif

        <div class="mb-4 text-2xl text-center px-3">
            <span>Terima kasih!</span>
        </div>

        <div class="text-center text-xs px-3">
            INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN
        </div>
    </div>
    <script>
        window.print();
    </script>
</x-guest-layout>
