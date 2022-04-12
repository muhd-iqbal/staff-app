<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peti Tunai ') . ucwords($branch->shortname) }}
        </h2>
    </x-slot>
    <x-modalbox width='max-w-3xl'>
        <div class="flex justify-between items-center pb-3">
            <p class="text-2xl font-bold text-black">Duit Masuk / Keluar ({{ $branch->shortname }})</p>
            <span class="focus:outline-none modal-close px-4 float-right text-red-500 cursor-pointer">x</span>
        </div>
        <div class="pt-2 gap-2">
            <form action="/cashflow/{{ $branch->id }}/add" method="POST">
                @csrf
                <div class="text-black flex flex-col gap-3 mb-3">
                    <div>
                        <label for="category_id">Kategori
                            <x-form.asterisk />
                        </label>
                        <select class="w-full rounded-md" name="category_id" id="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }} -
                                    {{ $category->in ? 'Masuk' : 'Keluar' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="reference">Rujukan
                            <x-form.asterisk />
                        </label>
                        <input class="w-full rounded-md" type="text" name="reference" id="reference" required>
                    </div>
                    <div>
                        <label for="date">Tarikh
                            <x-form.asterisk />
                        </label>
                        <input class="w-full rounded-md" type="date" name="date" id="date" value="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label for="amount">Amaun
                            <x-form.asterisk />
                        </label>
                        <input class="w-full rounded-md" type="number" step="0.01" name="amount" id="amount"
                            placeholder="Amaun dimasukkan/dikeluarkan" required>
                    </div>
                    <div class="col-span-2">
                        <label for="note">Nota</label>
                        <input class="w-full rounded-md" type="text" name="note" id="note">
                    </div>
                </div>
                <x-button>Tambah Rekod</x-button>
            </form>
        </div>
    </x-modalbox>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="section-to-print" class="bg-white overflow-hidden sm:rounded-lg">
                <div class="p-6 bg-white">
                    <div class="grid grid-cols-2">
                        <div>
                            <button onclick="openModal()"
                                class="bg-yellow-600 p-2 px-4 rounded-md shadow-md hover:bg-yellow-400">Duit Masuk /
                                Keluar</button>
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        </div>
                        <div class="text-right">Baki: RM{{ RM($branch->cash_current) }}</div>
                    </div>
                    <div class="mt-4">
                        <section class="container mx-auto p-6 font-mono">
                            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                                <div class="w-full overflow-x-auto">
                                    <table class="w-full">
                                        <thead
                                            class="text-center text-sm font-semibold tracking-wide text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                            <tr class="">
                                                <th class="px-4 border" rowspan="2">Tarikh</th>
                                                <th class="px-4 border" colspan="2">Amaun</th>
                                                <th class="px-4 border" rowspan="2">Rujukan</th>
                                                <th class="px-4 border" rowspan="2">Kategori</th>
                                                <th class="px-4 border" rowspan="2">Nota</th>
                                            </tr>
                                            <tr>
                                                <th class="border">Masuk</th>
                                                <th class="border">Keluar</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            @foreach ($cashflows as $cashflow)
                                                <tr class="text-center">
                                                    <td class="border">{{ $cashflow->date }}</td>
                                                    @if ($cashflow->category->in)
                                                        <td class="border">{{ RM($cashflow->amount) }}</td>
                                                        <td class="border">&nbsp;</td>
                                                    @else
                                                        <td class="border">&nbsp;</td>
                                                        <td class="border">{{ RM($cashflow->amount) }}</td>
                                                    @endif
                                                    {{-- {!! $cashflow->category->in ? "<td>". RM($cashflow->amount) . '</td><td></td>' : '<td></td><td>' . RM($cashflow->amount)."</td>" !!}</td> --}}
                                                    <td class="border">{{ $cashflow->reference }}</td>
                                                    <td class="border">{{ $cashflow->category->name }}</td>
                                                    <td class="border">{{ $cashflow->note }}</td>
                                                    <td class="border p-0">
                                                        @if ($cashflow->payment_id == null)
                                                            <form action="/cashflow/delete/{{ $cashflow->id }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="font-bold text-red-600 border px-2"
                                                                    onclick="return confirm('Padam aliran tunai {{ $cashflow->reference }}?')">&#128465;</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <div class="flex">
                        <div>
                            <a href="/"
                                class='text-center bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                                {{ __('Kembali') }}
                            </a>
                        </div>
                        <div class="ml-auto">
                            @foreach ($branches as $bra)
                                <a href="/cashflow/{{ $bra->id }}"
                                    class="bg-{{ $bra->color_code }}-500 shadow-xl py-2 px-4  rounded-md font-bold text-white hover:bg-{{ $bra->color_code }}-700">{{ ucwords($bra->shortname) }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
