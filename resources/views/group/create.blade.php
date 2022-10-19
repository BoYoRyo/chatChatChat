<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <div class="flex">
                <div class="flex-initial">
                    {{ __('グループ作成') }}
                </div>
                <div class="flex-initial">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </div>
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- グループ作成フォーム --}}
        <form action="{{ route('group.store') }}" method="get" enctype="multipart/form-data">
            @csrf
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
                <div class="py-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="flex items-center my-auto">
                        {{-- <div class="ml-3">
                            アイコン：<input type="file" name="icon">
                            <img src="{{ asset('icon/' . 'default_group_icon' . random_int(1, 5) . '.png') }}" style="max-height:80px;" class="rounded-full">
                        </div> --}}
                        <div class="font-semibold text-l text-gray-800 leading-tight p-2 my-auto ml-4">
                            <input type="text" name="groupName"
                                class="bg-gray-50 border border-gray-300 text-gray-800 text-sm rounded focus:ring-amber-400 focus:border-amber-400 block w-full h-11"
                                placeholder="グループ名" value="{{ old('groupName') }}">
                            </div>
                            <div>
                                <button
                                class="bg-amber-300 hover:bg-amber-500 border-amber-300 hover:border-slate-700 text-base border text-white p-2 my-auto rounded"
                                type="submit">
                                グループ作成
                            </button>
                        </div>
                    </div>
                    @if ($errors->any())
                    <div class="text-red-700 ml-7">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                </div>
            </div>

            {{-- 友達一覧 --}}
            @foreach ($friends as $friend)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
                    <div class="py-3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex items-center my-auto">
                            <input name="memberId[]" id="{{ $friend->user->id }}" type="checkbox"
                                value="{{ $friend->user->id }}"
                                class="w-4 h-4 ml-3 my-auto text-amber-600 bg-gray-100 rounded border-gray-300 focus:ring-amber-500">
                            <label for="{{ $friend->user->id }}" class="flex ml-3 text-sm font-medium text-gray-900">
                                {{-- 画像 --}}
                                <div class="my-auto bg-white">
                                    <img src="{{ asset('icon/' . $friend->user->icon) }}" style="max-height:50px;">
                                </div>
                                {{-- 名前 --}}
                                <div class="ml-1 my-auto bg-white text: left; text-xl ">
                                    {{ $friend->user->name }}
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach
        </form>
    </div>
</x-app-layout>
