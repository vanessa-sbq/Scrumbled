@foreach ($users as $user)
    @php
        $imagePath = $user->picture ? 'storage/' . $user->picture : 'images/users/default.png';
    @endphp
    <tr>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
            <div class="flex items-center space-x-3">
                <img src="{{ asset($imagePath) }}" alt="{{ $user->full_name }}" class="w-8 h-8 rounded-full">
                <div>
                    <span>{{ $user->full_name }}</span>
                    <div class="text-muted-foreground text-sm">{{ $user->username }}</div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">{{ $user->email }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm hidden md:table-cell">
            <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium
                                        @if ($user->status === 'NEEDS_CONFIRMATION') bg-yellow-100 text-yellow-800
                                        @elseif ($user->status === 'BANNED')
                                            bg-red-100 text-red-800
                                        @else
                                            bg-green-100 text-green-800 @endif">
                {{ $user->status }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
            <div class="flex space-x-2">
                <form method="POST"
                    action="{{ $user->status === 'BANNED' ? route('admin.users.unban', $user->id) : route('admin.users.ban', $user->id) }}">
                    @csrf
                    @method('POST')
                    <button type="submit"
                        class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700 transition">
                        {{ $user->status === 'BANNED' ? 'Unban' : 'Ban' }}
                    </button>
                </form>
                <a href="{{ route('admin.users.edit', $user->username) }}"
                    class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-700 transition">
                    Edit
                </a>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
            <!-- <a href="{{ route('admin.users.show', $user->username) }}" target="_blank" rel="noopener"
                class="bg-primary text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                View Profile
            </a> -->

            <button class="inline-flex items-center justify-center rounded-md transition-colors bg-gray-200 text-gray-800 hover:bg-gray-300 px-6 py-2 text-base " id="admin_user_view_profile">
                View Profile
            </button>
            <x-modal id="admin_view_user_modal" title="Admin View User profile" closeButtonText="Cancel" saveButtonText="Proceed" saveAction="adminUserViewProfile" activeButtonColor="bg-red-600" hoverButtonColor="bg-red-700">
                <p>aDASDKASKD</p>
            </x-modal>
        </td>
    </tr>
@endforeach

@push('scripts')
    <script src=" {{ asset('js/modal.js') }} "></script>
    <script src=" {{ asset('js/admin.js') }} "></script>
    <script>console.log('JavaScript is working');</script>
@endpush
