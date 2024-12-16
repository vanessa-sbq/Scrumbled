@extends('web.layout')

@section('content')
    <!-- Features Section -->
    <section class="py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-16">
                <h2 class="text-4xl font-manrope text-center font-bold text-gray-900 leading-[3.25rem]">
                    Frequently Asked Questions
                </h2>
            </div>
            <div class="accordion-group" data-accordion="default-accordion">
                <!-- Question 1 -->
                <div
                    class="accordion border border-solid border-gray-300 p-4 rounded-xl transition duration-500 mb-8 lg:p-4">
                    <button
                        class="accordion-toggle group inline-flex items-center justify-between text-left text-lg font-normal leading-8 text-gray-900 w-full transition duration-500 hover:text-primary">
                        <h5>How can I reset my password?</h5>
                        <x-lucide-chevron-down class="chevron w-4 h-4 transition-transform duration-500" />
                    </button>
                    <div class="accordion-content w-full overflow-hidden max-h-0 transition-all duration-500">
                        <p class="text-base text-gray-900 font-normal leading-6">
                            To reset your password, go to the login page and click "Forgot Password." Enter your email
                            address, and we will send you a link to reset it.
                        </p>
                    </div>
                </div>

                <!-- Question 2 -->
                <div
                    class="accordion border border-solid border-gray-300 p-4 rounded-xl transition duration-500 mb-8 lg:p-4">
                    <button
                        class="accordion-toggle group inline-flex items-center justify-between text-left text-lg font-normal leading-8 text-gray-900 w-full transition duration-500 hover:text-primary">
                        <h5>How do I update my billing information?</h5>
                        <x-lucide-chevron-down class="chevron w-4 h-4 transition-transform duration-500" />
                    </button>
                    <div class="accordion-content w-full overflow-hidden max-h-0 transition-all duration-500">
                        <p class="text-base text-gray-900 font-normal leading-6">
                            To update your billing information, log in to your account, navigate to "Settings," and select
                            "Billing Information" to update your payment method.
                        </p>
                    </div>
                </div>

                <!-- Question 3 -->
                <div
                    class="accordion border border-solid border-gray-300 p-4 rounded-xl transition duration-500 mb-8 lg:p-4">
                    <button
                        class="accordion-toggle group inline-flex items-center justify-between text-left text-lg font-normal leading-8 text-gray-900 w-full transition duration-500 hover:text-primary">
                        <h5>How can I contact customer support?</h5>
                        <x-lucide-chevron-down class="chevron w-4 h-4 transition-transform duration-500" />
                    </button>
                    <div class="accordion-content w-full overflow-hidden max-h-0 transition-all duration-500">
                        <p class="text-base text-gray-900 font-normal leading-6">
                            You can contact customer support through the "Help" section of your account dashboard or by
                            emailing support@example.com.
                        </p>
                    </div>
                </div>

                <!-- Question 4 -->
                <div
                    class="accordion border border-solid border-gray-300 p-4 rounded-xl transition duration-500 mb-8 lg:p-4">
                    <button
                        class="accordion-toggle group inline-flex items-center justify-between text-left text-lg font-normal leading-8 text-gray-900 w-full transition duration-500 hover:text-primary">
                        <h5>How do I delete my account?</h5>
                        <x-lucide-chevron-down class="chevron w-4 h-4 transition-transform duration-500" />
                    </button>
                    <div class="accordion-content w-full overflow-hidden max-h-0 transition-all duration-500">
                        <p class="text-base text-gray-900 font-normal leading-6">
                            To delete your account, go to "Settings," scroll down to "Delete Account," and follow the
                            on-screen instructions to permanently remove your data.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@once
    @push('scripts')
        <script src="{{ asset('js/faq.js') }}"></script>
    @endpush
@endonce
