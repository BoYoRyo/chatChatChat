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
        </div>
    </div>
</x-app-layout>
