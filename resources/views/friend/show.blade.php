<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex">
            <div class="bg-white">
                <img src="{{ asset('icon/' . $friend->icon) }}" style="max-height:50px;" class="rounded-full">
            </div>
            <div class="ml-3 my-auto">
                {{ $friend->name }}
            </div>

        </h2>
    </x-slot>

    {{-- プロフィール --}}
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-1">
            <div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- 画像 --}}
                <div class="flex justify-center p-2 bg-white">
                    <img src="{{ asset('icon/' . $friend->icon) }}" style="max-height:240px;">
                </div>
                {{-- 名前 --}}
                <div class="flex justify-center font-semibold text-l text-gray-800 leading-tight p-2">
                    <div class="mb-1">
                        {{ $friend->name }}
                    </div>
                </div>

                {{-- 一言 --}}
                <div class="flex justify-center font-semibold text-l text-gray-800 leading-tight p-2">
                    <div class="mb-1 max-w-md break-words inline-block">
                        {{ $friend->introduction }}
                    </div>
                </div>

                @if ($relationship == 'friend')
                    {{-- トークボタン --}}
                    <div class="flex justify-center mb-2">
                        <form method="GET" action="{{ route('talk.store', $friend->id) }}">
                            @csrf
                            <button type="submit"
                                class="bg-amber-300 hover:bg-amber-400 text-gray-600 hover:text-gray-700 font-semibold rounded px-4 py-2 w-40">
                                トーク
                            </button>
                        </form>
                    </div>

                    {{-- ブロックボタン --}}
                    <div class="flex justify-center mb-2">
                        <form method="GET" action="{{ route('friend.destroy', $friend->id) }}">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                class="border-1 border-amber-300 hover:bg-amber-400 text-gray-400 hover:text-gray-700 font-semibold rounded px-4 py-2 w-40">
                                ブロック
                            </button>
                        </form>
                    </div>
                @elseif($relationship == 'blockedFriend')
                    {{-- ブロック解除ボタン --}}
                    <div class="flex justify-center mb-2">
                        <form method="GET" action="{{ route('friend.cancelDestroy', $friend->id) }}">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                class="bg-amber-300 hover:bg-amber-400 text-gray-600 hover:text-gray-700 font-semibold rounded px-4 py-2 w-40">
                                ブロック解除
                            </button>
                        </form>
                    </div>
                @elseif($relationship == 'other')
                    {{-- フレンド追加ボタン --}}
                    <div class="flex justify-center mb-2">
                        <form method="GET" action="{{ route('add.connect', $friend->id) }}">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                class="bg-amber-300 hover:bg-amber-400 text-gray-600 hover:text-gray-700 font-semibold rounded px-4 py-2 w-40">
                                フレンドになる
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
