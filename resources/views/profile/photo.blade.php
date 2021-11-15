<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Photo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex">
                        <div class="flex-1">
                            <img src="{{ asset('storage/'.$user->photo) }}" alt="" width=500>
                        </div>
                        <div class="flex-1">
                            <form action="/profile/upload/{{ auth()->id() }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <x-form.input name="photo" label="Foto" span="6" type="file"/>

                                <x-button class="mt-2">Upload</x-button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
