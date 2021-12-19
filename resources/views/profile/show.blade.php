<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Peribadi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mt-10 sm:mt-0">
                        <div class="md:grid md:grid-cols-2 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h1 class="font-bold text-lg font-medium leading-6 text-gray-900">
                                        {{ __('Lihat / Ubah Maklumat Peribadi') }}</h1>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __('Guna emel yg diberikan.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form action="/profile/update/{{ auth()->id() }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="shadow overflow-hidden sm:rounded-md">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="grid grid-cols-6 gap-6">

                                                <x-form.input name="name" label="nama" span="4"
                                                    value="{{ $user->name }}" />
                                                <x-form.input name="phone" label="No. Phone" span="2"
                                                    value="{{ $user->phone }}" />
                                                <x-form.input name="email" label="emel" span="2"
                                                    value="{{ $user->email }}" />
                                                <x-form.input name="icno" label="no ic" span="2"
                                                    value="{{ $user->icno }}" />
                                                <x-form.input name="birthday" label="tarikh lahir" span="2" type="date"
                                                    value="{{ $user->birthday }}" />
                                                <x-form.input name="address" label="Alamat" span="6"
                                                    value="{{ $user->address }}" />

                                                <hr class="col-span-6 sm:col-span-6" />

                                                <x-form.input name="joined_at" label="Tarikh Masuk" span="3" type="date"
                                                    value="{{ $user->joined_at }}" />
                                                <x-form.input name="left_at" label="Tarikh Keluar" span="3" type="date"
                                                    value="{{ $user->left_at }}" />

                                                <x-form.select name="department_id" label="Bahagian" span="3">
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            {{ $user->department_id == $department->id ? 'selected' : 'disabled' }}>
                                                            {{ $department->name }}</option>
                                                    @endforeach
                                                </x-form.select>
                                                <x-form.select name="position_id" label="Jawatan" span="3">
                                                    @foreach ($positions as $position)
                                                        <option value="{{ $position->id }}"
                                                            {{ $user->position_id == $position->id ? 'selected' : 'disabled' }}>
                                                            {{ $position->name }}</option>
                                                    @endforeach
                                                </x-form.select>

                                                <x-form.input name="qualification" label="Kelayakan (Diploma/Ijazah)"
                                                    span="6" value="{{ $user->qualification }}" />

                                                <hr class="col-span-6 sm:col-span-6" />

                                                <x-form.input name="bank_name" label="Bank" span="3"
                                                    value="{{ $user->bank_name }}" />
                                                <x-form.input name="bank_acc" label="No Akaun Bank" span="3"
                                                    value="{{ $user->bank_acc }}" />

                                            </div>
                                        </div>
                                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                            <x-button>
                                                {{ __('Kemaskini') }}
                                            </x-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-dashboard-link />
        </div>
    </div>
    </div>
</x-app-layout>
