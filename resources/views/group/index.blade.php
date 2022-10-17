<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex">
                <div class="my-auto">
                    {{ __('グループ') }}
                </div>
                <div class="my-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </div>
                <div class="my-auto">
                    <form class="w-full max-w-sm">
                        <div class="flex items-center border-b border-fuchsia-600 py-2">
                            <input
                                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none  placeholder-gray-400"
                                type="text" placeholder="アカウントID  名前" aria-label="Full name">
                            <button
                                class="flex-shrink-0 bg-fuchsia-600 hover:bg-fuchsia-700 border-fuchsia-600 hover:border-fuchsia-700 text-sm border-4 text-white py-1 px-2 rounded"
                                type="button">
                                検索
                            </button>
                            <input type="reset" value="キャンセル"
                                class="flex-shrink-0 border-transparent border-4 text-fuchsia-600 hover:text-fuchsia-800 text-sm py-1 px-2 rounded">
                            <!-- <button
                                class="flex-shrink-0 border-transparent border-4 text-fuchsia-600 hover:text-fuchsia-800 text-sm py-1 px-2 rounded"
                                type="button">
                                キャンセル
                            </button> -->
                        </div>
                    </form>
                </div>
                <div class="bg-white hover:bg-gray-100 text-gray-800 font-semibold px-2 border border-gray-400 rounded m-2">
                    <a href="{{ route('group.create') }}">
                        <button>グループ作成</button>
                    </a>
                </div>
            </div>
        </h2>
    </x-slot>

    {{-- グループ一覧 --}}
    <div class="py-12">
        @foreach ($groups as $group)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                    {{-- 画像 --}}
                    <div class="p-6 bg-white my-auto">
                        <a href="{{ route('group.show', $group->id) }}">
                            <img src="{{ asset('icon/' . $group->icon) }}" style="max-height:70px;"
                                class="rounded-full">
                        </a>
                    </div>
                    {{-- 名前 --}}
                    <div class="ml-1 mt-11 bg-white flex-initial text: left; text-xl my-auto">
                        {{ $group->name }}
                    </div>
                    {{-- トークする --}}
                    <div class="my-10 ml-auto mr-10">
                        <form method="GET" action={{ route('talk.show', $group->id) }}>
                            <button
                                class="bg-amber-300 hover:bg-amber-500 text-white font-semibold hover:text-slate-700 py-4 px-4 border border-slate-700 hover:border-transparent rounded">
                                トークする
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
