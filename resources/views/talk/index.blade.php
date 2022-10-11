<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex">
                <div class="flex-initial">
                    {{ __('トーク一覧') }}
                </div>
                <div class="flex-initial">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </div>
            </div>
        </h2>
    </x-slot>

    {{-- トーク一覧 --}}
    <div class="py-12">

        @foreach ($groups as $group)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
                <a href="/talk/show/{{ $group->group_id }}">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex">
                        {{-- 画像 --}}
                        <div class="p-6 bg-white border-b border-gray-200">
                            <img src="{{ asset('icon/' . $group->user->icon) }}" style="max-height:70px;">
                        </div>
                        {{-- 名前と最新のトーク --}}
                        <div class="ml-1 m-4 bg-white flex-initial text: left; text-xl ">
                            {{-- 名前 --}}
                            <div class="text: left; text-xl ">
                                {{ $group->user->name }}
                            </div>
                            {{-- 最新のトーク --}}
                            <div class="text: left; text-l text-gray-500">
                                {{-- 何分前のメッセージか表示 --}}
                                {{-- {{$group->connersasion->created_at->diffForHumans()}} --}}
                                
                                {{-- {{ $group->conversation->comment }} --}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    </div>
</x-app-layout>
