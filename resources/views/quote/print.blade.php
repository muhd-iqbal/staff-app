<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quotation: ' . $quote->id) }}
        </h2>
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                #section-to-print,
                #section-to-print * {
                    visibility: visible;
                }

                #section-to-print {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
            }
        </style>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="section-to-print" class="bg-white overflow-hidden sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="text-right">
                        <div class="font-bold text-xl">{{ __('SEBUT HARGA') }}</div>
                    </div>
                    <div>
                        <div class="flex text-left gap-5">
                            <x-application-logo class="hidden md:block h-24 w-auto fill-current text-gray-600" />
                            <x-application-logo class="block md:hidden h-32 w-auto fill-current text-gray-600" />
                            <div>
                                <div class="text-2xl font-bold uppercase">{{ $quote->branch->name }}</div>
                                <div class="text-base font-bold uppercase">LOT 15, BANGUNAN PKNK KAWASAN PERINDUSTRIAN RINGAN GURUN, KILANG KETAPAN, 08300 GURUN, KEDAH</div>
                                <div class="text-base font-bold uppercase">Tel:
                                    
                                    013-530 3135
                                </div>
                                <div class="text-base font-bold">EMEL: admin@inspirazs.com.my</div>
                            </div>
                        </div>

                        <div class="mt-5">
                            {{ __('Kepada: ') }}
                        </div>
                        {{ $quote->customer->organisation ? $quote->customer->organisation : $quote->customer->name }}<br>
                        {{-- <div>{{ $quote->customer->organisation ? '' : $quote->customer->name }}</div> --}}
                        {{ $quote->customer->address }},<br>{{ $quote->customer->postcode }}
                        {{ $quote->customer->city }}, {{ $quote->customer->state }}
                        <div>{{ $quote->customer->organisation ? 'PIC: '.$quote->customer->name : ''  }}</div>
                        <div>
                            {{ __('Telefon: ') . phone_format($quote->customer->phone) }}
                        </div>
                    </div>
                    <div class="border-b border-gray-600 pb-3">
                        <div class="grid grid-cols-2 mt-5">
                            <div class="font-bold">
                                {{ __('No. Sebut Harga: ') . quote_num($quote->id) }}
                            </div>
                            <div class="text-right">{{ __('Tarikh: ') . date('d/m/Y', strtotime($quote->date)) }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <table class="w-full border-collapse">
                            <tr class="bg-gray-100">
                                <th class="text-center px-3 border w-1/12">No</th>
                                <th class="text-left px-3 border">Perkara</th>
                                <th class="text-center px-3 border w-2/12">Saiz</th>
                                <th class="text-center px-3 border w-2/12">Kuantiti</th>
                                <th class="text-center px-3 border w-2/12">Harga Seunit</th>
                                <th class="text-right px-3 border w-2/12">Jumlah (RM)</th>
                            </tr>
                            @foreach ($quote->quote_item as $item)
                                <tr>
                                    <td class="text-center px-3 border">{{ $loop->iteration }}</td>
                                    <td class="px-3 border">{{ $item->product }}</td>
                                    <td class="px-3 text-center border">
                                        {{ $item->size }}
                                        {{ $item->measurement ? '(' . $item->measurement . ')' : '' }}
                                    </td>
                                    <td class="px-3 text-center border">{{ $item->quantity }}</td>
                                    <td class="px-3 text-center border">{{ RM($item->price) }}</td>
                                    <td class="px-3 text-right border">{{ RM($item->total) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @if ($quote->discount || $quote->shipping)
                        <div class="grid grid-cols-2 mt-5">
                            <div class="font-bold">{{ __('Jumlah Kasar') }}</div>
                            <div class="text-right font-bold">{{ 'RM' . RM($quote->total) }}</div>
                        </div>
                    @endif
                    @if ($quote->discount)
                        <div class="grid grid-cols-2 mt-3">
                            <div class="font-bold">{{ __('Diskaun') }}</div>
                            <div class="text-right font-bold">
                                {{ '(RM' . RM($quote->discount) . ')' }}</div>
                        </div>
                    @endif
                    @if ($quote->shipping)
                        <div class="grid grid-cols-2 mt-3">
                            <div class="font-bold">{{ __('Penghantaran') }}</div>
                            <div class="text-right font-bold">{{ 'RM' . RM($quote->shipping) }}
                            </div>
                        </div>
                    @endif
                    <div class="grid grid-cols-2 mt-3">
                        <div class="font-bold">{{ __('Jumlah Bersih') }}</div>
                        <div class="text-right font-bold">{{ 'RM' . RM($quote->grand_total) }}
                        </div>
                    </div>
                    @if ($quote->foot_note)
                        <div class="border mt-2 p-1">
                            <div>Nota:</div>
                            <div>{!! $quote->foot_note !!}</div>
                        </div>
                    @endif
                    <div class="text-center mt-10">
                        <div class="text-sm">
                            <div class="mt-5">{{ __('Nombor Akaun:') }}</div>
                            {{ $quote->branch->bank_account_1 }} 
                            
                        </div>
                        &nbsp;
                        <div class="text-sm">

                            Ini adalah dokumen yang dihasilkan komputer. Tidak perlu tandatangan
                        </div>
                       <div class="text-sm">

                            Sebut harga ini sah selama 3 minggu selepas tarikh dokumen ini dikeluarkan
                        </div>
                    </div>
                </div>
            </div>

            <!-- Percentage calculation section (ADDED) -->
            <div class="mt-5 p-4 bg-gray-50 rounded-md border">
                <h3 class="font-bold mb-2">Kiraan Peratus Pembayaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-sm font-medium">Peratus Bayaran (%)</label>
                        <input id="payment_percent" type="number" min="0" max="100" value="100" class="mt-1 block w-full rounded-md border px-2 py-1" />
                        <div class="text-xs text-gray-500">Contoh: 100 = penuh bayaran</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Peratus Deposit (%)</label>
                        <input id="deposit_percent" type="number" min="0" max="100" value="60" class="mt-1 block w-full rounded-md border px-2 py-1" />
                        <div class="text-xs text-gray-500">Contoh: 50 = separuh daripada jumlah bayaran</div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Peratus Barang Sedia Untuk Dihantar (%)</label>
                        <input id="ready_percent" type="number" min="0" max="100" value="40" class="mt-1 block w-full rounded-md border px-2 py-1" />
                        <div class="text-xs text-gray-500">Biasanya 100 - deposit</div>
                    </div>
                </div>

                <div class="mt-3">
                    <button id="calc_btn" type="button" class="bg-blue-500 text-white px-3 py-1 rounded">Kira</button>
                    <button id="apply_to_note" type="button" class="bg-green-500 text-white px-3 py-1 rounded ml-2">Masukkan ke Nota Kaki</button>
                    <button id="reset_btn" type="button" class="bg-gray-300 text-black px-3 py-1 rounded ml-2">Reset</button>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium">Pratonton Nota</label>
                    <div id="note_preview" class="whitespace-pre-wrap mt-1 p-3 rounded border bg-white text-sm" style="min-height:100px;">
                        <!-- Generated note preview will appear here -->
                    </div>
                </div>
            </div>
            <!-- End percentage calculation section -->

            <div class="flex">
                <a href="/quote/{{ $quote->id }}"
                    class='w-auto text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2 mt-3'>
                    {{ __('Kembali') }}
                </a>
                <div class="ml-auto">
                    <button onclick="print()"
                        class="bg-blue-400 p-2 rounded-md px-4 font-bold mt-3 text-white hover:bg-blue-600">Cetak</button>
                </div>
            </div>
            <div class="mt-5">
                Nota Kaki <span class="text-xs rounded-full bg-gray-700 text-white px-1 cursor-pointer"
                    onclick="alert('Elakkan guna simbol. Ganti nota dengan ayat.\nNew line: nota<br> \nBold: <b>nota</b> \nItalic: <i>nota</i>\nUnderline: <u>nota</u>')">
                    ?
                </span>
                <form action="/quote/{{ $quote->id }}/print" method="POST">
                    @csrf
                    @method('PATCH')
                    <div>
                        <textarea name="foot_note" id="foot_note" cols="30" rows="3" class="rounded-md resize-none">{{ $quote->foot_note }}</textarea>
                    </div>
                    <div>
                        <button type="submit"
                            class="px-2 bg-yellow-400 hover:bg-yellow-600 rounded-md">Kemaskini</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            // Use server-side grand total safely encoded into JS
            const grandTotal = parseFloat({!! json_encode((float) $quote->grand_total) !!}) || 0;

            const paymentInput = document.getElementById('payment_percent');
            const depositInput = document.getElementById('deposit_percent');
            const readyInput = document.getElementById('ready_percent');
            const preview = document.getElementById('note_preview');
            const calcBtn = document.getElementById('calc_btn');
            const applyBtn = document.getElementById('apply_to_note');
            const resetBtn = document.getElementById('reset_btn');
            const footNote = document.getElementById('foot_note');

            function formatRM(value) {
                // Format number with thousand separators and 2 decimals, e.g. 27,360.00
                return 'RM ' + new Intl.NumberFormat('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
            }

            function generateNote() {
                const paymentPercent = Math.max(0, Math.min(100, parseFloat(paymentInput.value) || 0));
                const depositPercent = Math.max(0, Math.min(100, parseFloat(depositInput.value) || 0));
                let readyPercent = Math.max(0, Math.min(100, parseFloat(readyInput.value) || 0));

                // If ready percent is zero, try to auto compute as remainder of deposit within the payment percent context
                // The semantics: deposit and ready split the "payment percent" amount.
                // We'll compute amounts as:
                // paymentAmount = grandTotal * paymentPercent/100
                // depositAmount = paymentAmount * depositPercent/100
                // readyAmount = paymentAmount * readyPercent/100
                // If readyPercent not provided (0) and depositPercent provided, set readyPercent = 100 - depositPercent
                if (readyPercent === 0 && depositPercent > 0) {
                    readyPercent = Math.max(0, 100 - depositPercent);
                    readyInput.value = readyPercent;
                }

                const paymentAmount = (paymentPercent / 100);
                const depositAmount = paymentAmount * (depositPercent / 100);
                const readyAmount = paymentAmount * (readyPercent / 100);

                // Build note text similar to the example
                const lines = [];
                lines.push('Nota:');
                lines.push('CARA PEMBAYARAN :');
                if (paymentPercent > 0) {
                    lines.push(paymentPercent + '% BAYARAN = ' + formatRM(paymentAmount));
                } else {
                    lines.push('0% BAYARAN = ' + formatRM(0));
                }

                // Show deposit/ready lines if their percentages > 0
                if (depositPercent > 0) {
                    lines.push(depositPercent + '% DEPOSIT = ' + formatRM(depositAmount));
                }
                if (readyPercent > 0) {
                    lines.push(readyPercent + '% BARANG SEDIA UNTUK DIHANTAR = ' + formatRM(readyAmount));
                }

                lines.push('');
                lines.push('JANGKAAN SIAP :');
                lines.push('60 HARI BEKERJA SELEPAS PENGESAHAN PEMBAYARAN DEPOSIT');

                return lines.join('\n');
            }

            function updatePreview() {
                preview.textContent = generateNote();
            }

            calcBtn.addEventListener('click', function () {
                updatePreview();
            });

            // Apply generated preview into the foot_note textarea (HTML allowed in existing implementation)
            applyBtn.addEventListener('click', function () {
                // We want to preserve line breaks but allow HTML if needed.
                // Convert newlines to <br> for storage in foot_note (the view prints {!! $quote->foot_note !!})
                const text = generateNote();
                const html = text.replace(/\n/g, '<br>');
                if (footNote) {
                    footNote.value = html;
                }
                // Update preview to reflect the HTML that will be saved (optional)
                preview.innerHTML = html.replace(/\n/g, '<br>');
            });

            resetBtn.addEventListener('click', function () {
                paymentInput.value = 100;
                depositInput.value = 60;
                readyInput.value = 40;
                updatePreview();
            });

            // update automatically on change
            [paymentInput, depositInput, readyInput].forEach(function (el) {
                el.addEventListener('input', updatePreview);
            });

            // initial preview
            updatePreview();
        })();
    </script>
</x-app-layout>
