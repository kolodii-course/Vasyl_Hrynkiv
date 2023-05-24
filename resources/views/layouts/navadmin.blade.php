@extends('layouts/samenav')

@section('menu')
<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-decoration-none">
        {{ __('Home') }}
    </x-nav-link>
</div>

@auth
    @if(Auth::user()->is_admin)
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('queue')" :active="request()->routeIs('queue')" class="text-decoration-none">
                {{ __('Queue') }}
            </x-nav-link>
        </div>

        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('outagelist')" :active="request()->routeIs('outagelist') || request()->routeIs('outagelist.find')" class="text-decoration-none">
                Outage list
            </x-nav-link>
        </div>

        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('users.show')" :active="request()->routeIs('users.show')" class="text-decoration-none">
                Users
            </x-nav-link>
        </div>
    @endif
@endauth
@endsection