<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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
                                <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                  <th class="px-4 py-3">{{ ('Nama') }}</th>
                                  @if (auth()->user()->isAdmin)<th class="px-4 py-3">{{ ('No Tel') }}</th>@endif
                                  <th class="px-4 py-3">{{ ('Status') }}</th>
                                  @if (auth()->user()->isAdmin)<th class="px-4 py-3">{{ ('Tindakan') }}</th>@endif
                                </tr>
                              </thead>
                              <tbody class="bg-white">
                                @foreach ($users as $user)

                                <tr class="text-gray-700">
                                  <td class="px-4 py-3 border">
                                    <div class="flex items-center text-sm">
                                      <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                        <img class="object-cover w-full h-full rounded-full" src="{{ asset('storage/'.$user->photo) }}" alt="" loading="lazy" />
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                      </div>
                                      <div>
                                        <p class="font-semibold text-black">{{ ucwords(strtolower($user->name)) }}</p>
                                        <p class="text-xs text-gray-600">{{ $user->position->name . __(' di Bahagian ') .  $user->department->name }}</p>
                                      </div>
                                    </div>
                                  </td>
                                  @if (auth()->user()->isAdmin)
                                  <td class="px-4 py-3 text-ms font-semibold border">{{ \App\Http\Controllers\Controller::phone_format($user->phone) }}</td>
                                  @endif
                                  <td class="px-4 py-3 text-xs border text-center">
                                      @if($user->active)
                                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm"> {{ __('Aktif') }} </span>
                                      @else
                                        <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-sm"> {{ __('Tidak Aktif') }} </span>
                                      @endif
                                  </td>
                                  @if (auth()->user()->isAdmin)

                                  <td class="px-4 py-3 text-sm border">
                                      <a href="/staff/show/{{ $user->id }}" class="bg-blue-500 hover:bg-blue-600 py-2 px-4 text-sm font-medium text-white border border-transparent rounded-lg focus:outline-none">Ubah</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                        {{ $users->links() }}
                      </section>
                      <x-dashboard-link />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
