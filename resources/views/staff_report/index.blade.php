<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('Graf Jumlah Design Designer') }}
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
                                    <a href="/staff-reports/{{ request('year') - 1 }}{{ request('month') ? '/' . request('month') : '' }}"
                                        class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">&#10094;
                                        {{ request('year') - 1 }}</a>
                                @endif
                            </div>
                            <div class="ml-auto">
                                @if (request('year') < date('Y'))
                                    <a href="/staff-reports/{{ request('year') + 1 }}{{ request('month') ? '/' . request('month') : '' }}"
                                        class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">
                                        {{ request('year') + 1 }} &#10095;</a>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex">
                            <div>
                                @if (request('year') <= date('Y', strtotime(config('app.pos_start'))))
                                    <a href="/staff-old-reports/{{ request('year') - 1 }}{{ request('month') ? '/' . request('month') : '' }}"
                                        class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">&#10094;
                                        {{ request('year') - 1 }}</a>
                                @endif
                            </div>
                            <div class="ml-auto">
                                @if (request('year') < date('Y'))
                                    <a href="/staff-old-reports/{{ request('year') + 1 }}{{ request('month') ? '/' . request('month') : '' }}"
                                        class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">
                                        {{ request('year') + 1 }} &#10095;</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="flex">
                        <h1 class="capitalize text-xl mt-3">
                            Jumlah Design Designer {{ request('year') }}

                        </h1>
                        
                    </div>
                    
                    <div width="400" height="400">
                        <canvas id="chartContainer"></canvas>
                    </div>
                    <div class="flex flex-row-reverse gap-3 mt-5">
                        <a href="/{{ $current ? 'staff-old-' : '' }}reports/{{ request('year') }}"
                            class="capitalize bg-gray-500 p-2 px-4 rounded-md shadow-md text-white">Semua</a>
                        @foreach ($order as $loop)
                            <a href=""
                                class="capitalize bg-blue-500 p-2 px-4 rounded-md shadow-md text-white">
                            {{month_name($loop->iteration)}}</a>
                        @endforeach
                    </div>

                    <div class="text-center mt-5">
                        <table class="w-full border border-collapse">
                            <tr>
                                <th class="border">Designer</th>
                                <th class="border">Jumlah Design</th>
                            </tr>

                            @foreach ($users as $designer)
                                @if ($designer->order_item->count() > 0)
                                    <tr>
                                        <td class="border">{{ ucwords(strtolower($designer->name))}}</td>
                                        <td class="border">{{ $designer->order_item->count() }} design.</td>
                                    </tr>
                                @endif
                            @endforeach

                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <x-dashboard-link />
    <script>
        $(function() {
            var designers = {!! json_encode($users->pluck('name')) !!};
            var orders = {!! json_encode($users->pluck('order_item')->map->count()) !!};
    
            var colors = ['#39f', '#f90', '#f00', '#FFC0CB', '#0f0', '#BF40BF', '#900', '#f60', '#60f', '#999', '#139f'];
    
            var datasets = [{
                data: orders,
                backgroundColor: colors,
                hoverBackgroundColor: '#fff',
                borderColor: '#000000',
                borderWidth: 1.5,
            }];
    
            var pieCanvas = $("#chartContainer");
            var pieChart = new Chart(pieCanvas, {
                type: 'pie',
                data: {
                    labels: designers,
                    datasets: datasets,
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
