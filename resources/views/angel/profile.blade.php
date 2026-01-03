<x-app-layout>
     
    
    @include('layouts.header')

    <flux:heading>Angelone Profile</flux:heading>
    <flux:text class="mt-2">Name : {{ $profile['name'] }}</flux:text>

    <flux:text class="mt-2">Client Code : {{ $profile['clientcode'] }}</flux:text>
    
    <flux:text class="mt-2">Broker : {{ $profile['brokerid'] }}</flux:text>
    
    <flux:text class="mt-2">Exchanges : {{ implode(', ', $profile['exchanges'] ) }}</flux:text>

    <form method="POST" action="{{ route('angel.logout') }}">
        @csrf
        <flux:button variant="primary" type="submit">Logout</flux:button>
    </form>
</x-app-layout>
