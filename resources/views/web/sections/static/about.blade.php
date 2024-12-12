@extends('web.layout')

@section('content')
    <section
        class="relative overflow-hidden bg-gradient-to-b from-blue-50 via-transparent to-transparent pb-12 pt-20 sm:pb-16 sm:pt-32 lg:pb-24 xl:pb-32 xl:pt-40">
        <div class="relative z-20 mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-foreground sm:text-6xl">
                    Simplifying Scrum to Empower Teams and Drive Agile Success.
                    </span>
                </h1>
                <h2 class="mt-6 text-lg leading-8 text-muted-foreground">
                    Scrumbled makes Scrum simple. Plan sprints, manage tasks, and collaborate with your team — all in one
                    intuitive platform designed to keep everyone aligned and productive.
                </h2>
            </div>
        </div>
    </section>

    <section class="bg-white py-24 relative">
        <div class="w-full max-w-7xl px-4 md:px-5 lg:px-5 mx-auto">
            <div class="w-full justify-start items-center gap-8 grid lg:grid-cols-2 grid-cols-1">
                <div class="w-full flex-col justify-start lg:items-start items-center gap-10 inline-flex">
                    <div class="w-full flex-col justify-start lg:items-start items-center gap-4 flex">
                        <h2 class="text-gray-900 text-4xl font-bold font-manrope leading-normal lg:text-start text-center">
                            Simplifying Scrum, Empowering Teams to Achieve More
                        </h2>
                        <p class="text-gray-500 text-base font-normal leading-relaxed lg:text-start text-center">
                            Scrumbled makes project management simple, intuitive, and effective. Our platform empowers teams
                            to organize sprints, manage tasks, and collaborate seamlessly — all in one place. Whether you're
                            a Product Owner, Scrum Master, or Developer, Scrumbled keeps everyone aligned and focused on
                            achieving sprint goals.
                        </p>
                    </div>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="/register"
                            class="px-3 py-2 inline-flex bg-primary text-white rounded-md hover:bg-primary/90 transition-colors items-center justify-center gap-2">Get
                            Started <x-lucide-chevron-right class="w-3.5" /></a>
                    </div>
                </div>
                <img class="lg:mx-0 mx-auto h-full rounded-3xl object-cover border border-muted shadow-md"
                    src="{{ asset('images/about.png') }}" alt="About Scrumbled Image" />
            </div>
        </div>
    </section>

    <section class="py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h2 class="font-manrope text-5xl text-center font-bold text-gray-900">Our Team</h2>
            </div>
            <div
                class="grid grid-cols-1 min-[500px]:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-8 max-w-xl mx-auto md:max-w-3xl lg:max-w-full">

                <div class="block group md:col-span-2 lg:col-span-1">
                    <div class="relative mb-6">
                        <img src="https://pagedone.io/asset/uploads/1696238374.png" alt="Antonio Abílio image"
                            class="w-40 h-40 rounded-full mx-auto transition-all duration-500 object-cover border border-solid border-transparent group-hover:border-blue-500" />
                    </div>
                    <h4
                        class="text-xl font-semibold text-gray-900 mb-2 capitalize text-center transition-all duration-500 group-hover:text-blue-500">
                        António Abílio
                    </h4>
                    <span class="text-gray-500 text-center block transition-all duration-500 group-hover:text-gray-900">
                        up202205469
                    </span>
                </div>

                <div class="block group md:col-span-2 lg:col-span-1">
                    <div class="relative mb-6">
                        <img src="https://pagedone.io/asset/uploads/1696238396.png" alt="Vanessa Queirós image"
                            class="w-40 h-40 rounded-full mx-auto transition-all duration-500 object-cover border border-solid border-transparent group-hover:border-blue-500" />
                    </div>
                    <h4
                        class="text-xl font-semibold text-gray-900 mb-2 capitalize text-center transition-all duration-500 group-hover:text-blue-500">
                        Vanessa Queirós
                    </h4>
                    <span class="text-gray-500 text-center block transition-all duration-500 group-hover:text-gray-900">
                        up202207919
                    </span>
                </div>

                <div class="block group md:col-span-2 lg:col-span-1">
                    <div class="relative mb-6">
                        <img src="https://pagedone.io/asset/uploads/1696238411.png" alt="Simão Neri image"
                            class="w-40 h-40 rounded-full mx-auto transition-all duration-500 object-cover border border-solid border-transparent group-hover:border-blue-500" />
                    </div>
                    <h4
                        class="text-xl font-semibold text-gray-900 mb-2 capitalize text-center transition-all duration-500 group-hover:text-blue-500">
                        João Santos
                    </h4>
                    <span class="text-gray-500 text-center block transition-all duration-500 group-hover:text-gray-900">
                        up202205794
                    </span>
                </div>

                <div class="block group md:col-span-2 lg:col-span-1">
                    <div class="relative mb-6">
                        <img src="https://pagedone.io/asset/uploads/1696238446.png" alt="João Santos image"
                            class="w-40 h-40 rounded-full mx-auto transition-all duration-500 object-cover border border-solid border-transparent group-hover:border-blue-500" />
                    </div>
                    <h4
                        class="text-xl font-semibold text-gray-900 mb-2 capitalize text-center transition-all duration-500 group-hover:text-blue-500">
                        Simão Neri
                    </h4>
                    <span class="text-gray-500 text-center block transition-all duration-500 group-hover:text-gray-900">
                        up202206370
                    </span>
                </div>

            </div>
        </div>
    </section>
@endsection
