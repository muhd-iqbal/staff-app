<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="container mx-auto p-6 font-mono">
                        <div class="flow-root">
                            <div class="md:float-left flex gap-3 mb-2">
                                <a href="/customers/create"
                                    class="border-2 border-purple-500 bg-purple-300 text-sm rounded-md p-2">{{ __('Tambah Pelanggan') }}</a>
                                <a href="/orders/create"
                                    class="border-2 border-green-500 bg-green-300 text-sm rounded-md p-2">{{ __('Tambah Order') }}</a>
                            </div>
                            <div class="md:float-right">
                                <form action="/customers" method="get">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        placeholder="Carian..">
                                    @if (request('search'))
                                        <a href="/customers" class="text-2xl" title="Tunjuk semua">&#8635;</a>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr
                                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                            <th class="px-4 py-3 text-center">{{ 'No' }}</th>
                                            <th class="px-4 py-3">{{ 'Nama' }}</th>
                                            <th class="px-4 py-3 text-center">{{ 'No Tel' }}</th>
                                            <th class="px-4 py-3 text-center">{{ 'Tindakan' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($customers as $customer)
                                            <tr class="text-gray-700">
                                                <td class="text-center border">
                                                    {{ ($customers->currentpage() - 1) * $customers->perpage() + $loop->index + 1 }}
                                                </td>
                                                <td class="px-4 py-3 border">
                                                    <p class="text-sm font-semibold text-black">
                                                        {{ ucwords(strtolower($customer->name)) }}</p>
                                                </td>
                                                <td class="text-center border">
                                                    {{ $customer->phone }}
                                                </td>
                                                <td class="text-center border">
                                                    <a href="/customer/{{ $customer->id }}/edit"
                                                        class="text-md px-6 py-2 rounded-md bg-blue-500 text-indigo-50 font-semibold cursor-pointer">{{ __('Edit') }}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $customers->withQueryString()->links() }}
                    </section>
                    <x-dashboard-link />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
