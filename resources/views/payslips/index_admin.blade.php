<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Slip Gaji') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6 font-mono">
                    <x-modalbox width='max-w-3xl'>
                        <div class="flex justify-between items-center pb-3">
                            <p class="text-2xl font-bold text-black">Muat naik slip gaji</p>
                            <span
                                class="focus:outline-none modal-close px-4 float-right text-red-500 cursor-pointer">x</span>
                        </div>
                        <div class="pt-2 gap-2">
                            <form action="/admin/payslips/add" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="text-black flex flex-col gap-3 mb-3">
                                    <div>
                                        <label for="user_id">Nama Staf
                                            <x-form.asterisk />
                                        </label>
                                        <select class="w-full rounded-md" name="user_id" id="user_id">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="year">Tahun (YYYY)
                                            <x-form.asterisk />
                                        </label>
                                        <select class="w-full rounded-md" name="year" id="year">
                                            @for ($current = date('Y'); $current >= 2020; $current--)
                                                <option value="{{ $current }}">{{ $current }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <label for="month">Bulan
                                            <x-form.asterisk />
                                        </label>
                                        <select class="w-full rounded-md" name="month" id="month">
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}"
                                                    {{ $m == date('n', strtotime('-1 months')) ? 'selected' : '' }}>
                                                    {{ month_name($m) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <label for="file">Slip Gaji
                                            <x-form.asterisk /><span class="text-xs text-red-6p00">Max 2MB</span>
                                        </label>
                                        <input class="w-full rounded-md" type="file" name="file" id="file" required>
                                    </div>
                                </div>
                                <x-button class="mt-5">Tambah Slip Gaji</x-button>
                            </form>
                        </div>
                    </x-modalbox>
                    <div class="flex text-right">
                        <div class="font-bold text-lg">
                            <form action="">
                                <select class="p-0" name="y" id="y">
                                    @for ($current = date('Y'); $current >= 2020; $current--)
                                        <option value="{{ $current }}"
                                            {{ $current == request('y') ? 'selected' : '' }}>
                                            {{ $current }}</option>
                                    @endfor
                                </select>
                                <select name="m" id="m" class="p-0">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}"
                                            {{ $m == request('m') ? 'selected' : '' }}>
                                            {{ month_name($m) }}</option>
                                    @endfor
                                </select>
                                <button type="submit"
                                    class="bg-gray-400 text-white text-sm p-1 rounded-md hover:bg-gray-700">Submit</button>
                            </form>
                        </div>
                        <div class="ml-auto">
                            <button class="bg-yellow-500 p-2 px-4 rounded-md shadow-md hover:bg-yellow-300"
                                onclick="openModal()">Tambah</button>
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        </div>
                    </div>
                    <div class="overflow-x-auto p-4">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table class="w-full border-collapse md:w-1/2 mt-5">
                                    <thead>
                                        <tr class="border border-gray-600">
                                            <th>Nama</th>
                                            <th>Slip Gaji</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($currents as $current)
                                            <tr class="border border-gray-400">
                                                <td>{{ $current->user->name }}</td>
                                                <td class="p-2 flex gap-2"><a
                                                        class="bg-blue-400 text-white p-1 px-2 rounded-md mx-auto"
                                                        target="_blank"
                                                        href="{{ asset('storage/' . $current->file) }}">Lampiran</a>
                                                    <form action="/admin/payslips/{{ $current->id }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="bg-red-600 p-1 px-2 text-white rounded-md mx-auto"
                                                            onclick="return confirm('Padam slip gaji {{ $current->user->name }} untuk bulan {{ month_name($current->month) . ' ' . $current->year }}?')">x</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <x-dashboard-link />
        </div>
    </div>
</x-app-layout>
