<x-mail::message>
# New User Registered 👤

A new user has registered on **{{ config('agency.full_name') }}**.

<x-mail::panel>
**User Details**
- **Name:** {{ $user->name }}
- **Email:** {{ $user->email }}
- **Registered:** {{ $user->created_at->format('M d, Y H:i') }}
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/admin/users'" color="primary">
View in Admin Panel
</x-mail::button>

Thanks,
**{{ config('agency.team_signature') }}**
</x-mail::message>
