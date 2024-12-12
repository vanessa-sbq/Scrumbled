<footer class="p-4">
    <div class="w-full container p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="/" class="mb-4 sm:mb-0 space-x-3">
                <img src="{{ asset('svg/logo.svg') }}" class="h-8" alt="Scrumbled Logo" />
            </a>
            @php
                $links = [
                    ['route' => 'projects', 'label' => 'Projects'],
                    ['route' => 'profiles', 'label' => 'Profiles'],
                    ['route' => 'about', 'label' => 'About Us'],
                    ['route' => 'contact', 'label' => 'Contact Us'],
                    ['route' => 'faq', 'label' => 'FAQ'],
                ];
            @endphp
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ route($link['route']) }}"
                            class="hover:underline me-4 md:me-6">{{ $link['label'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center">© 2024 <a href="/"
                class="hover:underline">Scrumbled</a>. All Rights Reserved.</span>
    </div>
</footer>
