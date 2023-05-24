@extends('layouts/samenav')

@section('menu')
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('home')" :active="request()->routeIs('home') || request()->routeIs('find')" class="text-decoration-none">
        {{ __('Home') }}
    </x-nav-link>
</div>

@auth
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('setting')" :active="request()->routeIs('setting')" class="text-decoration-none">
            Setting
        </x-nav-link>
    </div>
    @if(Auth::user()->is_admin)

    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <x-nav-link :href="route('admin')" :active="request()->routeIs('admin')" class="text-decoration-none">
            {{ __('Admin') }}
        </x-nav-link>
    </div>
    @endif
@endauth
@endsection