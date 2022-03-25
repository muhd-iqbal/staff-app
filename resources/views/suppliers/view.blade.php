<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lokasi cawangan ')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="container mx-auto p-6 font-mono">
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                            <div class="w-full overflow-x-auto">
                                <form action="/suppliers/{{ $supplier->id }}/update" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="grid md:grid-cols-3 gap-5 p-5">
                                        <div class="col-span-1">
                                            <x-form.input name="name" label="Nama Syarikat"
                                                value="{!! $supplier->name !!}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="phone" label="Telefon"
                                                value="{{ $supplier->phone }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="email" label="Emel"
                                                value="{{ $supplier->email }}" />
                                        </div>
                                        <div class="col-span-3">
                                            <x-form.input name="address" label="Alamat"
                                                value="{{ $supplier->address }}" />
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
                        <a href="/suppliers"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            Kembali ke senarai sub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
