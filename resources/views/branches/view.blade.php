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
                                <form action="/branches/{{ $branch->id }}/update" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="grid md:grid-cols-3 gap-5 p-5">
                                        <div class="col-span-2">
                                            <x-form.input name="name" label="Nama Syarikat"
                                                value="{!! $branch->name !!}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="shortname" label="Lokasi (singkat)"
                                                value="{{ $branch->shortname }}" />
                                        </div>
                                        <div class="col-span-3">
                                            <x-form.input name="address" label="Alamat"
                                                value="{{ $branch->address }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="phone_1" label="Telefon 1"
                                                value="{{ $branch->phone_1 }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="phone_2" label="Telefon 2"
                                                value="{{ $branch->phone_2 }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="whatsapp_1" label="WhatsApp 1"
                                                value="{{ $branch->whatsapp_1 }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="whatsapp_2" label="WhatsApp 2"
                                                value="{{ $branch->whatsapp_1 }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="bank_account_1" label="Akaun Bank 1"
                                                value="{{ $branch->bank_account_1 }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="bank_account_2" label="Akaun Bank 2"
                                                value="{{ $branch->bank_account_2 }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="bank_account_3" label="Akaun Bank 3"
                                                value="{{ $branch->bank_account_3 }}" />
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.select name="color_code" label="Color Code" value="{{ $branch->color_code }}">
                                                <option selected disabled>Pilihan warna</option>
                                                    <option value="gray" {{ $branch->color_code=="gray"?"selected":""}}>gray</option>
                                                    <option value="red" {{ $branch->color_code=="red"?"selected":""}}>red</option>
                                                    <option value="yellow" {{ $branch->color_code=="yellow"?"selected":""}}>yellow</option>
                                                    <option value="green" {{ $branch->color_code=="green"?"selected":""}}>green</option>
                                                    <option value="blue" {{ $branch->color_code=="blue"?"selected":""}}>blue</option>
                                                    <option value="indigo" {{ $branch->color_code=="indigo"?"selected":""}}>indigo</option>
                                                    <option value="purple" {{ $branch->color_code=="purple"?"selected":""}}>purple</option>
                                                    <option value="pink" {{ $branch->color_code=="pink"?"selected":""}}>pink</option>
                                               </x-form.select>
                                        </div>
                                        <div class="col-span-1">
                                            <x-form.input name="foot_note" label="Nota Kaki"
                                                value="{{ $branch->foot_note }}" />
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
                        <a href="/branches"
                            class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>
                            Kembali ke senarai cawangan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
