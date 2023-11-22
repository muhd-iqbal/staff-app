<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('Graf Jumlah Design Staff') }}
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
                                    <a href="/staff-reports/{{ request('year') - 1 }}{{ request('branch') ? '/' . request('branch') : '' }}"
                                        class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">&#10094;
                                        {{ request('year') - 1 }}</a>
                                @endif
                            </div>
                            <div class="ml-auto">
                                @if (request('year') < date('Y'))
                                    <a href="/staff-reports/{{ request('year') + 1 }}{{ request('branch') ? '/' . request('branch') : '' }}"
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
                            Designer {{ request('branch') ? $curr_branch->shortname : '' }} {{ request('year') }}
                            {{ $current ? '(Terkini)' : '(Lama)' }}
                        </h1>
                        <div class="ml-auto mt-3">
                            <a href="/{{ $current ? 'old-' : '' }}reports"
                                class="bg-blue-{{ $current ? '5' : '4' }}00 text-white py-1 px-2 rounded-md shadow-md">POS
                                {{ $current ? 'lama' : 'terkini' }}</a>
                        </div>
                    </div>
                    <div width="400" height="400">
                        <canvas id="chartContainer"></canvas>
                    </div>
                   <!-- <div class="flex flex-row-reverse gap-3 mt-5">
                        <a href="/{{ $current ? '' : 'old-' }}reports/{{ request('year') }}"
                            class="capitalize bg-gray-500 p-2 px-4 rounded-md shadow-md text-white">Semua</a>
                        @foreach ($branches as $branch)
                            <a href="/{{ $current ? '' : 'old-' }}reports/{{ request('year') }}/{{ $branch->id }}"
                                class="capitalize bg-{{ $branch->color_code }}-500 p-2 px-4 rounded-md shadow-md text-white">
                                {{ $branch->shortname }}</a>
                        @endforeach -->
                    </div>
                    <div class="text-center mt-5">
                        <table class="w-full border border-collapse">
                            <tr>
                                <th class="border">Designer</th>
                                <th class="border">Jumlah Design</th>
                            </tr>
                            @foreach ($users as $designer)
                                <tr>
                                    <td class="border">{{ $designer->name }}</td>
                                    <td class="border">{{ $designer->order_item->count() ? $designer->order_item->count() : 'Tiada' }} design.</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <!-- <div class="mt-5">
                        <div>POS terkini bermula {{ date("d M Y", strtotime(config('app.pos_start'))) }}</div>
                    </div>-->
                </section>
            </div>
        </div>
    </div>
    <x-dashboard-link />
    <script>
        $(function() {
            var sales = {!! json_encode($users) !!};
            {{-- var dues = {!! json_encode($dues) !!}; --}}
            var barCanvas = $("#barChart");
            var barChart = new Chart(barCanvas, {
                type: 'bar',
                data: {
                    datasets: [{
                            label: 'Jualan {{ request('year') }}',
                            data: users,
                            backgroundColor: '{{ $current ? '#39f' : '#139f' }}',
                            hoverBackgroundColor: '#fff',
                            borderColor: '#00f',
                            borderWidth: 1,
                            barPercentage: 0.5,
                        },
                        // {
                        //     label:'Tertungak {{ request('year') }}',
                        //     data:dues,
                        //     backgroundColor:'#0ff'
                        // },
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
