<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Senarai Pesanan') }}
        </h2>
    </x-slot>
    <div class="text-right">
        <button class="bg-green-500 py-1 px-4 rounded-md shadow-md hover:bg-green-700 hover:text-white">
            Batal
        </button>
    </div>
    <div class="text-right">
        <button class="bg-green-500 py-1 px-4 rounded-md shadow-md hover:bg-green-700 hover:text-white">
            Tambah Pesanan
        </button>
    </div>
