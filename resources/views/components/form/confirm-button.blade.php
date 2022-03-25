@props(['id', 'txt'])
<button
    class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
    type="button" onclick="toggleModal('modal-id')">
    {{ __(strtoupper($txt)) }}
</button>
<div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
    id="modal-id">
    <div class="relative w-auto md:w-2/3 my-6 mx-auto max-w-3xl">
        <!--content-->
        <div
            class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
            <!--header-->
            <div class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-3xl font-semibold">
                    {{ __('Pilihan Production') }}
                </h3>
            </div>
            <!--body-->
            <div class="relative p-6 flex-auto">
                <!-- Title -->
                <!-- Buttons -->
                <div class="flex flex-col text-center gap-5 mt-5">
                    <x-form.single-action action='/orders/item/{{ $id }}/approved-production'
                        title='Production Gurun + Print List' color='blue' />
                    <x-form.single-action action='/orders/item/{{ $id }}/approved' title='Production Gurun'
                        color='purple' />
                    <x-form.single-action action='/orders/item/{{ $id }}/approved-guar'
                        title='Production Guar' color='pink' />
                    <x-form.single-action action='/orders/item/{{ $id }}/approved-subcon' title='Subcon'
                        color='yellow' />
                </div>
            </div>
            <!--footer-->
            <div class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                <button
                    class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    type="button" onclick="toggleModal('modal-id')">
                    {{ __('Batal') }}
                </button>
            </div>
        </div>
    </div>
</div>
<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>
<script type="text/javascript">
    function toggleModal(modalID) {
        document.getElementById(modalID).classList.toggle("hidden");
        document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
        document.getElementById(modalID).classList.toggle("flex");
        document.getElementById(modalID + "-backdrop").classList.toggle("flex");
    }
</script>
