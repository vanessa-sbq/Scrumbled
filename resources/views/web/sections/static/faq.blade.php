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
                @php
                    $faqs = [
                        [
                            'question' => 'How do I create a new project?',
                            'answer' =>
                                'To create a new project, navigate to the "Projects" section from the main menu and click on the "Create Project" button. Fill in the required details such as project title, description, and other relevant information, then click "Save".',
                        ],
                        [
                            'question' => 'How can I edit my profile?',
                            'answer' =>
                                'To edit your profile, go to your profile page by clicking on your username in the top-right corner. On your profile page, click the "Edit Profile" button. Make the necessary changes and click "Save" to update your profile.',
                        ],
                        [
                            'question' => 'How do I assign a task to a developer?',
                            'answer' =>
                                'To assign a task to a developer, navigate to the task details page. If the task is part of a sprint backlog, you will see an "Assign to Me" button if no developer is assigned. Click this button to assign the task to yourself. If you are an admin or the project owner, you can also assign the task to other developers from the task details page.',
                        ],
                        [
                            'question' => 'What should I do if I can\'t see other people\'s projects?',
                            'answer' =>
                                'If you can\'t see other people\'s projects, it might be because their profiles are set to private. Only public projects are visible to other users. If you believe this is an error, please contact the project owner or an admin.',
                        ],
                        [
                            'question' => 'How do I manage notifications?',
                            'answer' =>
                                'You can manage your notifications by navigating to the "Inbox" section from the main menu. Here, you can view all notifications, invitations, and other updates. You can also delete selected notifications by checking the boxes next to them and clicking the "Delete Selected" button.',
                        ],
                        [
                            'question' => 'How do I join a project?',
                            'answer' =>
                                'To join a project, you need to receive an invitation from the project owner or an admin. Once you receive an invitation, you can accept it from the "Inbox" section under "Invitations".',
                        ],
                        [
                            'question' => 'How do I view my assigned tasks?',
                            'answer' =>
                                'To view your assigned tasks, navigate to the "Tasks" section from the main menu. Here, you will see a list of all tasks assigned to you. You can click on each task to view its details and update its status.',
                        ],
                        [
                            'question' => 'How do I change the status of a task?',
                            'answer' =>
                                'To change the status of a task, go to the task details page. Here, you can update the task status by selecting the appropriate status from the dropdown menu and clicking "Save".',
                        ],
                        [
                            'question' => 'How do I archive a project?',
                            'answer' =>
                                'To archive a project, navigate to the project settings page. Here, you will find an option to archive the project. Once archived, the project will be marked as archived and will not be editable until it is unarchived.',
                        ],
                        [
                            'question' => 'How do I edit or delete a comment?',
                            'answer' =>
                                'To edit or delete a comment, navigate to the task or project where the comment was made. Find the comment you want to edit or delete, and click the "Edit" or "Delete" button next to it. Make the necessary changes or confirm the deletion.',
                        ],
                        [
                            'question' => 'How do I view the sprint backlog?',
                            'answer' =>
                                'To view the sprint backlog, navigate to the "Sprints" section from the main menu. Select the sprint you want to view, and you will see a list of all tasks in the sprint backlog.',
                        ],
                        [
                            'question' => 'How do I change the product owner of a project?',
                            'answer' =>
                                'To change the product owner of a project, navigate to the project settings page. Here, you will find an option to transfer the product owner role to another user. Select the new product owner and confirm the change.',
                        ],
                        [
                            'question' => 'How do I mark a task as completed?',
                            'answer' =>
                                'To mark a task as completed, go to the task details page. Change the task status to "Completed" from the dropdown menu and click "Save". The task will be marked as completed and moved to the completed tasks list.',
                        ],
                        [
                            'question' => 'How do I view my notifications?',
                            'answer' =>
                                'To view your notifications, navigate to the "Inbox" section from the main menu. Here, you will see a list of all your notifications, including task assignments, project updates, and invitations.',
                        ],
                        [
                            'question' => 'How do I set my profile to private?',
                            'answer' =>
                                'To set your profile to private, go to your profile settings page. Here, you will find an option to change your profile visibility. Select "Private" and save the changes. Your profile will now be visible only to you and admins.',
                        ],
                    ];
                @endphp

                @foreach ($faqs as $faq)
                    <div
                        class="accordion border border-solid border-gray-300 p-4 rounded-xl transition duration-500 mb-8 lg:p-4">
                        <button
                            class="accordion-toggle group inline-flex items-center justify-between text-left text-lg leading-8 text-black font-semibold w-full transition duration-500 hover:text-primary">
                            <h5>{{ $faq['question'] }}</h5>
                            <svg class="chevron w-4 h-4 transition-transform duration-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="accordion-content w-full overflow-hidden max-h-0 transition-all duration-500">
                            <p class="text-base font-normal leading-6 mt-2">
                                {{ $faq['answer'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@once
    @push('scripts')
        <script src="{{ asset('js/faq.js') }}"></script>
    @endpush
@endonce
