<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex">
                <div class="my-auto">
                    {{ __('トーク一覧') }}
                </div>
                <div class="my-auto p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </div>
                <div class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-1 px-2 border border-gray-400 rounded">
                    <a href="{{ route('group.create') }}">
                        <button>グループ作成</button>
                    </a>
                </div>
            </div>
        </h2>
    </x-slot>

    {{-- トーク一覧 --}}
    <div class="py-12">

        @foreach ($groups as $group)
            @if($group->invisible == 0)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
                <a href="/talk/show/{{ $group->group_id }}">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                        {{-- 画像 --}}
                        <div class="p-6 bg-white my-auto">
                            @if ($group->group->type == '0')
                                <img src="{{ asset('icon/' . $group->user->icon) }}" style="max-height:70px;" class="rounded-full">
                            @else
                                <img src="{{ asset('icon/' . $group->group->icon) }}" style="max-height:70px;" class="rounded-full">
                            @endif
                        </div>
                        {{-- 名前と最新のトーク --}}
                        <div class="ml-1 m-4 bg-white flex-initial text: left; text-xl my-auto">
                            {{-- 名前 --}}
                            <div class="text: left; text-xl ">
                                @if ($group->group->type == '0')
                                    {{ $group->user->name }}
                                @else
                                    {{ $group->group->name }}
                                @endif
                            </div>
                            {{-- 最新のトーク --}}
                            <div class="text: left; text-l text-gray-500 mt-2 overflow-hidden max-w-3xl text-ellipsis">
                                @if ($group->conversation)
                                    {{-- 何分前のメッセージか表示 --}}
                                    {{ $group->conversation->created_at->diffForHumans() }}
                                    {{-- トーク内容 --}}
                                    {{ $group->conversation->comment }}
                                @endif
                            </div>
                        </div>
                        {{-- 非表示ボタン --}}
                        <div class="my-auto ml-auto mr-10">
                            <form action={{ route('talk.update',$group->id) }} type="get">
                                <button class="bg-transparent hover:bg-slate-700 text-slate-500 font-semibold hover:text-slate-700 py-4 px-4 border border-slate-700 hover:border-transparent rounded" name="invisible" type="submit">
                                    非表示にする
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
            @endif
        @endforeach
    </div>
</x-app-layout>
