@include('layouts.navigation')

<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @yield('head_text')
        </h2>
    </x-slot>
    @yield('first_content')
    @yield('forma')
</x-app-layout>