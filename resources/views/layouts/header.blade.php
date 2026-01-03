    
    <flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:brand href="/" class="text-xl font-bold capitalize" name="trade with ai" />
       
        
        <flux:navbar class="-mb-px max-lg:hidden">
            <!-- <flux:navbar.item icon="information-circle" href="#">About</flux:navbar.item> -->
            
            <flux:separator vertical variant="subtle" class="my-2"/>

            
        </flux:navbar>

        <flux:spacer />

        @if (Route::has('login'))
            <flux:navbar class="me-4">
                @auth
                <flux:navbar.item icon="home" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" current>Home</flux:navbar.item>
                @else
                <flux:navbar.item class="max-lg:hidden" icon="lock-closed" href="{{ route('login') }}" label="Login" />
                @endauth
            </flux:navbar>
        @endif

        @auth
            <flux:dropdown position="top" align="start">
                <flux:profile name="{{ Auth::user()->name ?? 'User' }}" />

                <flux:menu>
                    <flux:navmenu.item href="{{ route('angel.profile') }}" icon="user">Profile</flux:navmenu.item>
                    <flux:menu.item icon="arrow-right-start-on-rectangle" href="{{ route('angel.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</flux:menu.item>
                    <form id="logout-form" action="{{ route('angel.logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </flux:menu>
            </flux:dropdown>
         @endauth
    </flux:header>