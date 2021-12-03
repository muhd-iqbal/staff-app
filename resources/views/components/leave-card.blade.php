@props(['user', 'leave', 'link' => ''])
<div class="bg-white rounded-lg p-6">
    <div class="flex items-center space-x-6 mb-4">
        <div>
            <p class="text-xl text-gray-700 font-normal mb-1">{{ $leave->user_name }}</p>
        </div>
    </div>
    <div>
        <p class="text-black leading-loose font-normal text-base">Jenis: {{ $leave->type_name }}</p>
        <p class="text-black leading-loose font-normal text-base">Sebab: {{ $leave->detail }}</p>
        <p class="text-black leading-loose font-normal text-base">Tarikh:
            {{ date('D d/m/Y', strtotime($leave->start)) }}</p>
        <p class="text-black leading-loose font-normal text-base">Tempoh: {{ $leave->day }} hari ({{ $leave->time }})
        </p>
        <hr />
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

            </form>

            <form action="{{ $link }}/leaves/approval/{{ $leave->id }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="button"
                    class="w-full mt-4 bg-green-500 px-4 py-3 rounded text-white font-semibold hover:bg-green-600 transition duration-200 each-in-out"
                    onclick="event.preventDefault();this.closest('form').submit();">
                    Lulus
                </button>
            </form>

            <form action="{{ $link }}/leaves/approval/{{ $leave->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button"
                    class="w-full mt-4 bg-red-500 px-4 py-3 rounded text-white font-semibold hover:bg-red-600 transition duration-200 each-in-out"
                    onclick="event.preventDefault();this.closest('form').submit();">
                    Padam
                </button>
            </form>

        </div>

    </div>
</div>
