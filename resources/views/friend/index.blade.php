<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('フレンド') }}
        </h2>
    </x-slot>

    {{-- 友達一覧 --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href=""><img src="{{ asset('logo/linkedin_profile_image.png') }}"
                            style="max-height:60px;"></a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href=""><img src="{{ asset('logo/linkedin_profile_image.png') }}"
                            style="max-height:60px;"></a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href=""><img src="{{ asset('logo/linkedin_profile_image.png') }}"
                            style="max-height:60px;"></a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
