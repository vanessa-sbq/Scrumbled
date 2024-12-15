@extends('web.layout')

@section('content')
    <div class="container p-4 md:py-16 flex flex-col gap-2">
        <div class="flex gap-2">
            @if ($profileOwner->picture)
                <img class="h-24 w-24 rounded-full" src="{{ asset('storage/' . $profileOwner->picture) }}"
                    alt="Profile Picture">
            @else
                <img class="h-24 w-24 rounded-full" src="{{ asset('images/users/default.png') }}" alt="Profile Picture">
            @endif
            <div>
                <h2 class="text-2xl font-bold">{{ $profileOwner->full_name }}</h2>
                <h5>{{ $profileOwner->username }}</h5>
            </div>

            @if (Auth::check())
                @if ($user->username === $profileOwner->username)
                    <a href="{{ route('edit.profile.ui', ['username' => $user->username]) }}"
                        class="ml-auto place-self-start bg-primary text-white p-3 rounded hover:bg-blue-600">
                        Edit Profile
                    </a>
                @endif
            @endif
        </div>

        @if(Auth::check())
            @if($user->username === $profileOwner->username || $user->isInSameProject($profileOwner))
                <div>
                    <div class="md:flex md:gap-1">
                        <div class="flex flex-1 flex-wrap gap-2 flex-col">
                            @if ($projects->isEmpty())
                                <p class="grow text-gray-600">No public projects.</p>
                            @else
                                <div class="p-5 pl-0 flex flex-col gap-2">
                                    @foreach ($projects as $project)
                                        @if ($project->is_public || $user->username === $profileOwner->username)
                                            @include('web.sections.project.components._project', [
                                                'project' => $project,
                                            ])
                                        @endif
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
                                    <a href="mailto:{{ $profileOwner->email }}">{{ $profileOwner->email }}</a>
                                </div>
                                @switch($profileOwner->status)
                                    @case('NEEDS_CONFIRMATION')
                                        <h3>(Email not verified)</h3>
                                        @break

                                    @case('ACTIVE')
                                        <h3>(Active)</h3>
                                        @break

                                    @case('BANNED')
                                        <h3 class="text-red-700">(Banned)</h3>
                                @endswitch
                            </div>
                            <h3>Bio: {{ $profileOwner->bio }}</h3>
                        </div>
                    </div>
                </div>
            @endif
        @else
            {{-- If the user does not have access to this profile --}}
            <div class="text-center text-gray-600 mt-8">
                <h2 class="text-2xl font-bold">This Profile Is Private</h2>
                <p>You do not have permission to view this profile.</p>
            </div>
        @endif
    </div>
@endsection
