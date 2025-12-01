<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('Graf Jualan') }}
        </h2>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
            integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6 font-mono">
                    @if ($current)
                        <div class="flex">
                            <div>
                                @if (request('year') > date('Y', strtotime(config('app.pos_start'))))
                                    <a href="/reports/{{ request('year') - 1 }}{{ request('branch') ? '/' . request('branch') : '' }}"
                                        class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">&#10094;
                                        {{ request('year') - 1 }}</a>
                                @endif
                            </div>
                            <div class="ml-auto">
                                @if (request('year') < date('Y'))
                                    <a href="/reports/{{ request('year') + 1 }}{{ request('branch') ? '/' . request('branch') : '' }}"
                                        class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">
                                        {{ request('year') + 1 }} &#10095;</a>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex">
                            <div>
                                @if (request('year') <= date('Y', strtotime(config('app.pos_start'))))
                                    <a href="/old-reports/{{ request('year') - 1 }}{{ request('branch') ? '/' . request('branch') : '' }}"
                                        class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">&#10094;
                                        {{ request('year') - 1 }}</a>
                                @endif
                            </div>
                            <div class="ml-auto">
                                @if (request('year') < date('Y'))
                                    <a href="/old-reports/{{ request('year') + 1 }}{{ request('branch') ? '/' . request('branch') : '' }}"
                                        class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">
                                        {{ request('year') + 1 }} &#10095;</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="flex">
                        <h1 class="capitalize text-xl mt-3">
                            Jualan {{ request('branch') ? $curr_branch->shortname : '' }} {{ request('year') }}
                            {{ $current ? '(Terkini)' : '(Lama)' }}
                        </h1>
                        <div class="ml-auto mt-3">
                            <a href="/{{ $current ? 'old-' : '' }}reports"
                                class="bg-blue-{{ $current ? '5' : '4' }}00 text-white py-1 px-2 rounded-md shadow-md">POS
                                {{ $current ? 'lama' : 'terkini' }}</a>
                        </div>
                    </div>

                    <div width="400" height="400">
                        <canvas id="barChart"></canvas>
                    </div>

                    <div class="flex flex-row-reverse gap-3 mt-5">
                        <a href="/{{ $current ? '' : 'old-' }}reports/{{ request('year') }}"
                            class="capitalize bg-gray-500 p-2 px-4 rounded-md shadow-md text-white">Semua</a>
                        @foreach ($branches as $branch)
                            <a href="/{{ $current ? '' : 'old-' }}reports/{{ request('year') }}/{{ $branch->id }}"
                                class="capitalize bg-{{ $branch->color_code }}-500 p-2 px-4 rounded-md shadow-md text-white">
                                {{ $branch->shortname }}</a>
                        @endforeach
                    </div>

                    <!-- Monthly sales table -->
                    <div class="text-center mt-5">
                        <table class="w-full border border-collapse">
                            <tr>
                                <th class="border">Bulan</th>
                                <th class="border">Jumlah RM</th>
                            </tr>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td class="border">{{ month_name($loop->iteration) }}</td>
                                    <td class="border">{{ number_format($sale, 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <!-- Date range search form for daily sales -->
                    <div class="mt-6 flex items-center gap-3">
                        <form method="GET"
                            action="{{ url(($current ? '' : 'old-') . 'reports/' . request('year') . (request('branch') ? '/' . request('branch') : '')) }}"
                            class="flex items-center gap-2">
                            <label for="start_date" class="text-sm">Dari:</label>
                            <input id="start_date" name="start_date" type="date"
                                value="{{ request('start_date') }}"
                                class="border rounded-md p-1">
                            <label for="end_date" class="text-sm">Hingga:</label>
                            <input id="end_date" name="end_date" type="date"
                                value="{{ request('end_date') }}"
                                class="border rounded-md p-1">
                            <button type="submit"
                                class="bg-green-500 text-white px-3 py-1 rounded-md shadow-md">Cari</button>

                            <!-- keep other query params if present -->
                            @foreach(request()->except(['start_date','end_date','_token']) as $k => $v)
                                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endforeach
                        </form>

                        <div class="ml-auto text-sm text-gray-600">
                            <span class="italic">Masukkan julat tarikh untuk melihat pecahan jualan harian.</span>
                        </div>
                    </div>

                    <!-- Daily sales table (appears below monthly) -->
                    <div class="text-center mt-5">
                        <h2 class="text-lg font-semibold">
                            Jualan Harian
                            @if(request('start_date') || request('end_date'))
                                -
                                @if(request('start_date')) {{ date('d M Y', strtotime(request('start_date'))) }} @else - @endif
                                hingga
                                @if(request('end_date')) {{ date('d M Y', strtotime(request('end_date'))) }} @else - @endif
                            @endif
                        </h2>

                        @isset($dailySales)
                            @if ($dailySales->count() > 0)
                                <table class="w-full border border-collapse mt-3">
                                    <tr>
                                        <th class="border">Tarikh</th>
                                        <th class="border">Jumlah RM</th>
                                    </tr>

                                    @foreach ($dailySales as $row)
                                        <tr>
                                            <td class="border">{{ date('d M Y', strtotime($row->date)) }}</td>
                                            <td class="border">{{ number_format($row->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </table>

                                <!-- Optional: show total for range -->
                                <div class="mt-3 font-semibold">
                                    Jumlah keseluruhan: RM {{ number_format($dailySales->sum('total'), 2) }}
                                </div>
                            @else
                                <div class="mt-3 text-gray-600">Tiada data jualan harian untuk julat yang dipilih.</div>
                            @endif
                        @else
                            <div class="mt-3 text-gray-600">Pilih julat tarikh dan tekan Cari untuk melihat jualan harian.</div>
                        @endisset
                    </div>

                    <div class="mt-5">
                        <div>POS terkini bermula {{ date("d M Y", strtotime(config('app.pos_start'))) }}</div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <x-dashboard-link />
    <script>
        $(function() {
            var sales = {!! json_encode($sales) !!};
            var barCanvas = $("#barChart");
            var barChart = new Chart(barCanvas, {
                type: 'bar',
                data: {
                    datasets: [{
                            label: 'Jualan {{ request('year') }}',
                            data: sales,
                            backgroundColor: '{{ $current ? '#39f' : '#139f' }}',
                            hoverBackgroundColor: '#fff',
                            borderColor: '#00f',
                            borderWidth: 1,
                            barPercentage: 0.5,
                        },
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            })
        })
    </script>
</x-app-layout>
