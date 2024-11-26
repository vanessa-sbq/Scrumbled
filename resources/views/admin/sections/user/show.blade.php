@extends('admin.layout')

@section('content')
    <section class="container p-4 md:py-16 flex flex-col gap-2">
        <div class="flex gap-2">
            <img src="{{ $user->picture ? asset('storage/' . $user->picture) : asset('images/users/default.png') }}"
                alt="{{ $user->full_name }}'s profile picture" class="h-24 w-24 h-24 w-24 rounded-full">
            <div>
                <h2 class="text-2xl font-bold">{{ $user->full_name }}</h2>
                <h5>{{ $user->username }}</h5>
            </div>

            <a href="{{ route('admin.users.showEdit', ['username' => $user->username]) }}"
                class="ml-auto place-self-start bg-primary text-white p-3 rounded">
                Edit Profile
            </a>
        </div>
        <div class="md:flex md:gap-1">
            <div class="flex flex-1 flex-wrap gap-2 flex-col">
                @if ($projects->isEmpty())
                    <p class="grow text-gray-600">No public projects.</p>
                @else
                    <div class="p-5 pl-0 flex flex-col gap-2">
                        @foreach ($projects as $project)
                            @include('web.sections.project.components._project', ['project' => $project])
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex flex-1 flex-col max-w-min gap-4">
                <h2 class="text-lg font-bold">Info</h2>
                <div id="email-info">
                    <div class="flex items-center gap-0.5">
                        <svg viewBox="0 0 16 16" width="16" height="16">
                            <path
                                d="M1.75 2h12.5c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 14.25 14H1.75A1.75 1.75 0 0 1 0 12.25v-8.5C0 2.784.784 2 1.75 2ZM1.5 12.251c0 .138.112.25.25.25h12.5a.25.25 0 0 0 .25-.25V5.809L8.38 9.397a.75.75 0 0 1-.76 0L1.5 5.809v6.442Zm13-8.181v-.32a.25.25 0 0 0-.25-.25H1.75a.25.25 0 0 0-.25.25v.32L8 7.88Z">
                            </path>
                        </svg>
                        <a href="mailto:{{ $user->email }}" class="hover:underline">{{ $user->email }}</a>
                    </div>
                    @switch($user->status)
                        @case('NEEDS_CONFIRMATION')
                            <h3>(Email not verified)</h3>
                        @break

                        @case('ACTIVE')
                            <h3>(Active)</h3>
                        @break

                        @case('BANNED')
                            <h3 class="text-red-700">(Banned)</h3>
                        @endswitch
                        <h3>Bio: {{ $user->bio }}</h3>
                    </div>
                </div>
            </div>
        </section>
    @endsection
