<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Customer: ') . $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="container mx-auto p-6 font-mono">
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                            <div class="w-full overflow-x-auto">
                                <form action="/customer/{{ $customer->id }}/edit" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="grid md:grid-cols-3 gap-5 p-5">
                                        <div class="col-span-2">
                                            <x-form.input name="name" label="Nama Pelanggan"
                                                value="{{ $customer->name }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="phone" label="No Telefon"
                                                value="{{ $customer->phone }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input type="email" name="email" label="Alamat Emel"
                                                value="{{ $customer->email }}" />
                                        </div>
                                        <div class="col-span-2">
                                            <x-form.input name="address" label="Alamat"
                                                value="{{ $customer->address }}" />
                                        </div>

                                        <div class="col-span-1">
                                            <x-form.input name="city" label="Daerah / Bandar"
                                                value="{{ $customer->city }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="postcode" label="Poskod"
                                                value="{{ $customer->postcode }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.select name="state" label="Negeri" value="{{ $customer->state }}">
                                                <option selected disabled>Pilihan negeri..</option>
                                                @foreach ($states as $sh => $state)
                                                    <option value="{{ $sh }}"
                                                        {{ $customer->state == $sh ? 'selected' : '' }}>
                                                        {{ $state }}</option>
                                                @endforeach
                                            </x-form.select>
                                        </div>
                                    </div>
                                    <div class="flex flex-row-reverse p-5">
                                        <x-button>Kemaskini</x-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                    <div class="text-center mb-5">
                        <a href="/customers"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            Kembali ke senarai pelanggan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
