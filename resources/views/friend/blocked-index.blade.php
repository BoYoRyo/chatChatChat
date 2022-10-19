<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex">
                <div class="my-auto">
                    {{ __('ブロックリスト') }}
                </div>
                <div class="my-auto p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            </div>
        </h2>
    </x-slot>

    {{-- 友達一覧 --}}
    <div class="py-12">
        @foreach ($friends as $friend)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                    {{-- 画像 --}}
                    <div class="p-6 bg-white my-auto">
                        <a href="{{ route('friend.show', $friend->follow_id) }}"><img
                                src="{{ asset('icon/' . $friend->user->icon) }}" style="max-height:70px;"></a>
                    </div>
                    {{-- 名前 --}}
                    <div class="ml-1 bg-white flex-initial text: left; text-xl my-auto">
                        {{ $friend->user->name }}
                    </div>
                    {{-- 解除する --}}
                    <div class="my-auto ml-auto mr-10">
                        <form method="GET" action={{ route('talk.store', $friend->follow_id) }} >
                            <button class="bg-amber-300 hover:bg-amber-500 text-white font-semibold hover:text-slate-700 p-3 border border-slate-700 hover:border-transparent rounded">
                                解除
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
