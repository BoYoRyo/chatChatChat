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
                        <img src="{{ asset('icon/' . $member->user->icon) }}" style="max-height:70px;"
                            class="rounded-full">
                    </div>

                    {{-- 名前 --}}
                    <div class="ml-1 m-3 bg-white flex-initial text: left; text-xl my-auto">
                        <div class="text: left; text-xl ">
                            {{ $member->user->name }}
                        </div>
                    </div>

                    {{-- 友達追加 --}}
                    <div class="my-auto flex-1">
                        <a href="{{ route('add.connect', $member->user->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
