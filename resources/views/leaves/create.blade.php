<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permohonan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mt-10 sm:mt-0">
                        <div class="md:grid md:grid-cols-2 md:gap-6">

                          <div class="mt-5 md:mt-0 md:col-span-2">
                            <form action="/leaves/create/{{ auth()->id() }}" method="POST" enctype="multipart/form-data">
                                @csrf
                              <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                  <div class="grid grid-cols-6 gap-6">

                                    <x-form.input name="detail" label="Maklumat / Sebab Permohonan" span="4" />
                                    <x-form.input name="start" label="Tarikh" type="date" span="2" />

                                    <x-form.select name="leave_type_id" label="Jenis Cuti" span="2">
                                        @foreach ($leave_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </x-form.select>

                                    <x-form.input name="day" label="Bilangan hari" span="2" type="number" tags="step=0.5"/>
                                    <x-form.input name="return" label="Tarikh Kembali" type="date" span="2" />
                                    <x-form.select name="time" label="Seharian / Setengah Hari" span="2">
                                        @foreach ($time as $key=>$value)
                                        <option value="{{ $key }}" {{ old('time')==$key? "selected":"" }}>{{ $value }}</option>
                                        @endforeach
                                        {{-- <option value="full" {{ old('time')=="full"? "selected":"" }}>Seharian</option>
                                        <option value="h-am" {{ old('time')=="h-am"? "selected":"" }}>Setengah Hari (Pagi)</option>
                                        <option value="h-pm" {{ old('time')=="h-pm"? "selected":"" }}>Setengah Hari (Petang)</option> --}}
                                    </x-form.select>
                                    <x-form.input name="attachment" label="Lampiran" type="file" />

                                  </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                  <x-button>Mohon / Hantar</x-button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
