@extends('web.layout')

@section('content')
    <div class="container py-8">
        <h1 class="text-4xl font-bold mb-8 text-center">Inbox</h1>
        <div class="flex gap-3">
            <div class="w-1/6 card mb-60">
                <nav class="space-y-2">
                <a href="{{ route('inbox') }}" class="block py-2 px-4 rounded relative {{ request()->routeIs('inbox') ? 'bg-gray-200 font-semibold' : '' }} hover:before:content-[''] hover:before:absolute hover:before:top-0 hover:before:left-0 hover:before:h-full hover:before:w-1 hover:before:bg-blue-500 hover:before:rounded-sm">All Notifications</a>
                <a href="{{ route('inbox.invitations') }}" class="block py-2 px-4 rounded relative {{ request()->routeIs('inbox.invitations') ? 'bg-gray-200 font-semibold' : '' }} hover:before:content-[''] hover:before:absolute hover:before:top-0 hover:before:left-0 hover:before:h-full hover:before:w-1 hover:before:bg-blue-500 hover:before:rounded-sm">Invitations</a>
                </nav>
            </div>
                @if ($notifications->isEmpty())
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center justify-center mb-8">
                        <x-lucide-mail-open class="text-gray-600" width="200" height="200"/>
                        <p class="text-gray-600 text-center mt-16"><strong><span class="text-2xl">Your inbox is empty!</span></strong><br><br>Time to plan, sprint, and conquer your next big goal..</p>
                    </div>
                @else
                    <div class="w-5/6 flex flex-1 card" id="notificationList">
                    <div class="overflow-x-auto bg-white shadow-md rounded-lg p-6 mb-6 flex-1">
                        <form id="delete-selected-form" action="{{ route('inbox.delete') }}" method="POST" class="mb-4">
                            @csrf
                            
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-white border-b border-black rounded-t-lg">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-lg font-bold text-primary uppercase tracking-wider rounded-tl-lg">
                                            Notification
                                        </th>
                                        <th class="px-6 py-3 text-left text-lg font-bold text-primary uppercase tracking-wider rounded-tl-lg">
                                            <button type="submit">
                                                <x-lucide-trash-2 class="text-gray-600 hover:text-primary transition-colors duration-300" width="20" height="20"/>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="results-container">
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
                                                @include('web.sections.inbox.components._notification', ['$notifications' => $notifications])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                    
                @endif
                
            </div>
            
        </div>
        <div id="inbox-pagination-container" class="mt-4">
                        {{ $notifications->links() }}
                </div>
    </div>
@endsection
