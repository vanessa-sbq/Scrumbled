<header class='flex shadow-md py-4 px-4 sm:px-10 bg-white font-[sans-serif] min-h-[70px] tracking-wide relative z-50'>
    <script defer>
        function confirmLogout() {
            const logoutUrl = document.getElementById('logoutButton').getAttribute('data-url');
            if (logoutUrl) {
                window.location.href = logoutUrl;
            }
        }
    </script>
    <div class='flex flex-wrap items-center gap-5 w-full'>
        <a href="{{ url('/') }}">
            <img src="{{ asset('svg/icon.svg') }}" alt="logo" class='h-8 sm:hidden' />
            <img src="{{ asset('svg/logo.svg') }}" alt="logo" class='h-8 hidden sm:block' />
        </a>
        @if (Auth::guard('admin')->check())
            <button onclick="openModal('logoutConfirmModal')" id="logoutButton" class="ml-auto button bg-primary text-white px-4 py-2 rounded" data-url="{{route('admin.logout')}}">Back to Main Website</button>
        @endif
    </div>
    <x-modal id="logoutConfirmModal" title="Confirm Logout" closeButtonText="Cancel" saveButtonText="Logout" saveAction="confirmLogout" activeButtonColor="bg-primary" hoverButtonColor="bg-blue-600">
        <p>Are you sure you want to go back to the main website? This will log you out as an admin.</p>
    </x-modal>
</header>
