<x-agent-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Order') }}: {{ request('id') ? request('id') : '' }}
        </h2>
        <x-head.tinymce-config />
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section class="container mx-auto p-6">
                    <form action="add-order" method="POST">
                        @csrf
                        <div class="grid grid-cols-12 gap-6">
                            <x-form.input name="order_id" label="No Order (Kosongkan jika order baru)" span="2"
                                tags="placeholder={{ config('app.order_prefix') . '000001' }}"
                                value="{{ request('id') ? request('id') : '' }}" />
                            <x-form.select name="branch_id" label="Cawangan (Abaikan jika masukkan No Order)"
                                span="2">
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->shortname }}</option>
                                @endforeach
                            </x-form.select>
                            <x-form.input name="product" label="Produk" span="4" />
                            <x-form.input name="size" label="Saiz" span="2" />
                            <x-form.input name="quantity" type="number" label="Kuantiti" span="2" value=1 />

                            <x-form.select name="measurement" label="Ukuran" span="2">
                                @foreach ($measurements as $k => $v)
                                    <option value="{{ $k }}">{{ $v }}</option>
                                @endforeach
                            </x-form.select>
                            {{-- <x-form.input name="image" type="file" label="Lampiran / Gambar" span="4" /> --}}
                        </div>
                        <div class="grid grid-cols-1 mt-5">
                            <label class="md:text-sm text-xs text-gray-500 text-light font-semibold mb-1">Nota</label>
                            <textarea name="remarks" id="mytextarea" placeholder="Remarks">{{ old('remarks') }}</textarea>
                        </div>
                        <div class="text-center my-2 ">
                            <a href="/agent" class="bg-red-500 text-white p-2 px-4 rounded-md shadow-md">Batal</a>
                            <button type="submit"
                                class="bg-green-500 text-white p-2 px-4 rounded-md shadow-md">Submit</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-agent-layout>
