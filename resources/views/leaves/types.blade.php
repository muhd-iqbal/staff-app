<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Permohonan Cuti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <section class="container mx-auto p-6 font-mono">
                        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr
                                            class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                            <th class="px-4 py-3">Jenis</th>
                                            <th class="px-4 py-3">Perlu Kelulusan?</th>
                                            <th class="px-4 py-3">Ubah kelulusan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach ($types as $type)
                                            <tr class="text-gray-700">
                                                <td class="px-4 py-3 border">
                                                    <div class="flex items-center text-sm">
                                                        <div>
                                                            <p class="font-semibold text-black">{{ $type->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 border">
                                                    <p class="text-black">
                                                        {{ $type->approval ? 'Ya' : 'Tidak' }}
                                                    </p>
                                                </td>
                                                <td class="px-4 py-3 border">
                                                    <p class="text-black">
                                                    <form method="POST" action="/top/leave-types/{{ $type->id }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="approval"
                                                            value="{{ $type->approval ? 0 : 1 }}">
                                                        <x-button>{{ $type->approval ? 'Tak Perlu' : 'Perlu' }}
                                                        </x-button>
                                                    </form>
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
