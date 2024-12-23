@extends('web.layout')

@section('content')
    <section
        class="relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20 sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-40">
        <div class="relative z-10">
            <div
                class="absolute inset-x-0 top-1/2 -z-10 flex -translate-y-1/2 justify-center overflow-hidden [mask-image:radial-gradient(50%_45%_at_50%_55%,white,transparent)]">
                <svg class="h-[60rem] w-[100rem] flex-none stroke-blue-600 opacity-20" aria-hidden="true">
                    <defs>
                        <pattern id="e9033f3e-f665-41a6-84ef-756f6778e6fe" width="200" height="200" x="50%" y="50%"
                            patternUnits="userSpaceOnUse" patternTransform="translate(-100 0)">
                            <path d="M.5 200V.5H200" fill="none"></path>
                        </pattern>
                    </defs>
                    <svg x="50%" y="50%" class="overflow-visible fill-blue-50">
                        <path d="M-300 0h201v201h-201Z M300 200h201v201h-201Z" stroke-width="0"></path>
                    </svg>
                    <rect width="100%" height="100%" stroke-width="0" fill="url(#e9033f3e-f665-41a6-84ef-756f6778e6fe)">
                    </rect>
                </svg>
            </div>
        </div>
        <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                    Master Agile: <br>
                    <span class="text-primary">Scrumbled
                    </span>
                </h1>
                <h2 class="mt-6 text-lg leading-8 text-muted-foreground">
                    Scrumbled fosters an environment where agile project management is approachable and straightforward.

                </h2>
                <x-button variant="primary" size="md" href="/register" class="mt-8">
                    Get Started 
                    <svg class="w-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </x-button>
            </div>
            <div class="relative mt-10 container">
                <img class="w-full rounded-2xl border border-gray-100 shadow" src="{{ asset('images/hero.png') }}"
                    alt="Hero image">
            </div>
        </div>
    </section>

    <section class="bg-white py-24 sm:py-32 shadow-sm">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base/7 font-semibold text-primary">Streamline Scrum</h2>
                <p class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl lg:text-balance">
                    Everything you need to manage your Scrum projects</p>
                <p class="mt-6 text-lg/8 text-gray-600">Scrumbled simplifies Scrum processes, providing an intuitive and
                    effective project management tool for both beginners and experienced practitioners.</p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-primary">
                                <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
                            </div>
                            Create Projects & Invite Members
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Users can become Product Owners, Scrum Masters, or
                            Launch new projects effortlessly and invite team members to collaborate in real time.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-primary">
                                <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"/><path d="M3 10h18"/><path d="M16 19h6"/><path d="M19 16v6"/></svg>
                            </div>
                            Create Sprints
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Break your work into manageable sprints and track your
                            team's progress from start to finish.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-primary">
                                <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                            </div>
                            Add Tasks to Backlog & Sprints
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Organize your backlog and move tasks into active sprints
                            with a simple drag-and-drop interface.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-primary">
                                <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            </div>
                            Comment on Tasks
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Collaborate on tasks with team comments to ensure
                            everyone stays on the same page.</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
@endsection
