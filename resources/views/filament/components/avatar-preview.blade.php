<div>
    @if($record?->user?->avatar)
        <img src="{{ asset('avatars/' . $record->user->avatar) }}"
             alt="Avatar" class="w-16 h-16 rounded-full">
        <p class="text-xs text-gray-400 mt-1">Set by user</p>
    @else
        <img src="{{ asset('avatars/default.svg') }}"
             alt="Default Avatar" class="w-16 h-16 rounded-full opacity-50">
        <p class="text-xs text-gray-400 mt-1">No avatar set</p>
    @endif
</div>
