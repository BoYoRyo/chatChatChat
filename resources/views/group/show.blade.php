<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex">
            <a href="{{ route('talk.show', $group->id) }}" class=" flex">
                <div class="bg-white">
                    <img src="{{ asset('icon/' . $group->icon) }}" style="max-height:50px;" class="rounded-full">
                </div>
                <div class="ml-3 my-auto">
                    {{ $group->name }}
                </div>
            </a>
        </h2>
    </x-slot>

    {{-- 詳細 --}}
    <div class="py-12">
        <div class=" max-w-6xl mx-auto sm:px-6 lg:px-8 py-1">
            {{-- グループ名・画像 --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-2 mx-auto mb-2 flex">
                {{-- グループ名 --}}
                <div class="my-auto font-semibold text-xl text-gray-800 leading-tight p-5">
                    {{ $group->name }}
                </div>
                {{-- 画像 --}}
                <div class="bg-white">
                    <div class="relative">
                        <img src="{{ asset('icon/' . $group->icon) }}" style="max-height:150px;" class="rounded-full">
                    </div>
                </div>
            </div>

            {{-- メンバー --}}
            @foreach ($group->members as $member)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex mb-2">
                    {{-- 画像 --}}
                    <div class="py-6 pl-6 bg-white border-b border-gray-200">
                        <a href="{{ route('friend.show', $member->user->id) }}">
                            <img src="{{ asset('icon/' . $member->user->icon) }}" style="max-height:70px;"
                                class="rounded-full">
                        </a>
                    </div>

                    {{-- 名前 --}}
                    <div class="ml-1 m-3 bg-white flex-initial text: left; text-xl my-auto">
                        <div class="text: left; text-xl ">
                            <a href="{{ route('friend.show', $member->user->id) }}">
                                {{ $member->user->name }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- 友達追加を追加する --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex mb-2">
                    <div class="py-6 pl-6 bg-white border-b border-gray-200">
                        <a href="{{ route('group.edit' , $group->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="ml-1 m-3 bg-white flex-initial text: left; text-1xl my-auto">
                        <a href="{{ route('group.edit' , $group->id) }}">
                            友達を追加する
                        </a>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
