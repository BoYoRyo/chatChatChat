<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('フレンド') }}
        </h2>
    </x-slot>

    {{-- 友達一覧 --}}
    <div class="py-12">
        @foreach ($friends as $friend)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                    {{-- 画像 --}}
                    <div class="p-6 bg-white border-b border-gray-200">
                        <a href=""><img src="{{ asset('icon/' . $friend->user->icon) }}"
                                style="max-height:70px;"></a>
                    </div>
                    {{-- 名前 --}}
                    <div class="ml-1 mt-12 bg-white flex-initial text: left; text-xl ">
                        {{ $friend->user->name }}
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</x-app-layout>
