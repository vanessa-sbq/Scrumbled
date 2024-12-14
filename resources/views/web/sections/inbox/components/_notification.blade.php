<tr>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
        @if ($notification->type == "INVITE")
            <div class="flex items-center space-x-3">
                    Invitation to project {{ \App\Models\Project::find($notification->project_id)->title }}
            </div>
        @endif
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-full">
    </td>
</tr>




