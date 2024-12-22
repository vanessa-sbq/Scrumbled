@extends('web.layout')

@section('content')
    <div class="container py-8 px-4">
        <h1 class="text-4xl font-bold mb-8">Inbox</h1>
        <div class="flex flex-col md:flex-row gap-3">
            <div class="w-full md:w-1/6 mb-4 md:mb-0">
                <nav class="space-y-2 sticky top-4">
                    <a href="{{ route('inbox') }}"
                        class="block py-2 px-4 rounded relative {{ request()->routeIs('inbox') ? 'bg-gray-200 font-semibold' : '' }} hover:before:content-[''] hover:before:absolute hover:before:top-0 hover:before:left-0 hover:before:h-full hover:before:w-1 hover:before:bg-blue-500 hover:before:rounded-sm">All
                        Notifications</a>
                    <a href="{{ route('inbox.invitations') }}"
                        class="block py-2 px-4 rounded relative {{ request()->routeIs('inbox.invitations') ? 'bg-gray-200 font-semibold' : '' }} hover:before:content-[''] hover:before:absolute hover:before:top-0 hover:before:left-0 hover:before:h-full hover:before:w-1 hover:before:bg-blue-500 hover:before:rounded-sm">Invitations</a>
                </nav>
            </div>
            @if (empty($notificationInfos))
                <div class="w-full md:w-5/6 flex flex-col items-center justify-center mb-8">
                    <x-lucide-mail-open class="text-gray-600" width="200" height="200" />
                    <p class="text-gray-600 text-center mt-16"><strong><span class="text-2xl">Your inbox is
                                empty!</span></strong><br><br>Time to plan, sprint, and conquer your next big goal..</p>
                </div>
            @else
                <div class="w-full md:w-5/6 flex flex-1" id="notificationList">
                    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6 mb-6 flex-1">
                        <form id="delete-selected-form" action="{{ route('inbox.delete') }}" method="POST" class="mb-4">
                            @csrf
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-white border-b border-black rounded-t-lg">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-lg font-bold text-primary uppercase tracking-wider rounded-tl-lg">
                                            Notification
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-sm font-semibold text-primary uppercase tracking-wider rounded-tr-lg">
                                            <button type="submit"
                                                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-500/90 transition">
                                                Delete Selected
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="results-container">
                                    @foreach ($notificationInfos as $notificationInfo)
                                        <tr>
                                            <td colspan="2"
                                                class="px-6 py-4 whitespace-normal text-sm font-medium text-gray-900 w-full">
                                                @include('web.sections.inbox.components._notification', [
                                                    'notificationInfo' => $notificationInfo,
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div id="inbox-pagination-container" class="mt-4">
        {{ $notifications->links() }}
    </div>
@endsection
