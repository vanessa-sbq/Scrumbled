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
                    <span class="text-blue-500">Scrumbled
                    </span>
                </h1>
                <h2 class="mt-6 text-lg leading-8 text-muted-foreground">
                    Scrumbled fosters an environment where agile project management is approachable and straightforward.

                </h2>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="/register"
                        class="px-6 py-2 inline-flex bg-primary text-white rounded-md hover:bg-primary/90 transition-colors items-center justify-center gap-2">Get
                        Started <x-lucide-chevron-right class="w-3.5" /></a>
                </div>
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
                <h2 class="text-base/7 font-semibold text-blue-500">Streamline Scrum</h2>
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
                                class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-blue-500">
                                <x-lucide-share-2 class="size-5 text-white" />
                            </div>
                            Create Projects & Invite Members
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Users can become Product Owners, Scrum Masters, or
                            Launch new projects effortlessly and invite team members to collaborate in real time.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-blue-500">
                                <x-lucide-calendar-plus class="size-5 text-white" />
                            </div>
                            Create Sprints
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Break your work into manageable sprints and track your
                            team's progress from start to finish.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-blue-500">
                                <x-lucide-pencil class="size-5 text-white" />
                            </div>
                            Add Tasks to Backlog & Sprints
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Organize your backlog and move tasks into active sprints
                            with a simple drag-and-drop interface.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div
                                class="absolute left-0 top-0 flex size-10 items-center justify-center rounded-lg bg-blue-500">
                                <x-lucide-message-square class="size-5 text-white" />
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
