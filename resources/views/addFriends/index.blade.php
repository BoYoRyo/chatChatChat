<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- TODO 要素を中央にしたい --}}
            <div class="flex">
                <div class="my-auto">
                    {{ __('フレンド検索') }}
                </div>
                <div class="my-auto p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <div class="my-auto">
                    <form class="w-full max-w-sm" action="{{ url('add/searchFriend') }}" method="POST">
                        @csrf
                        <div class="flex items-center border-b border-fuchsia-600 py-2 px-2">
                            <input type="text" placeholder="アカウントIDまたは名前" aria-label="Full name"
                                name="search" value="{{ $search ? $search : '' }}"
                                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none placeholder-gray-400">
                            <button type="submit"
                                class="flex-shrink-0 bg-fuchsia-600 hover:bg-fuchsia-700 border-fuchsia-600 hover:border-fuchsia-700 text-sm border-4 text-white py-1 px-2 rounded">
                                検索
                            </button>
                            <input type="reset" value="×"
                                class="flex-shrink-0 border-transparent border-4 text-fuchsia-600 hover:text-fuchsia-800 text-sm py-1 px-2 rounded">
                        </div>
                    </form>
                </div>
            </div>
        </h2>
    </x-slot>
    <div class="py-12">
        @if ($addFriendName)
            <div class="alert alert-success text-center mx-auto sm:px-6 lg:px-4 py-4 max-w-5xl">
                {{ $addFriendName->name }}がフレンドに追加されました
            </div>
        @endif
        @foreach ($results as $result)
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 py-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                    {{-- 画像 --}}
                    <div class="px-2 py-2">
                        <img src="{{ asset('icon/' . $result->icon) }}" width="70">
                    </div>
                    {{-- アカウント名 --}}
                    <div class="mx-6 my-auto text-sm text-gray-400">
                        アカウント名
                    </div>
                    <div class="mx-6 my-auto w-40">
                        {{ $result->name }}
                    </div>
                    {{-- アカウントID --}}
                    <div class="mx-6 my-auto text-sm text-gray-400">
                        アカウントID
                    </div>
                    <div class="mx-6 my-auto">
                        {{ $result->account_id }}
                    </div>
                    {{-- 追加ボタン --}}
                    <div class="my-auto ml-auto mr-10">
                        <a href="{{ route('add.myFriend', $result->id) }}" class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                            </svg>
                            &nbsp;追加する
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
