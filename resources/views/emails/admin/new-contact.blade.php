<x-mail::message>
# New Contact Message 📩

You have received a new message via the contact form.

<x-mail::panel>
**Sender Details**

- **Name:** {{ $name }}
- **Email:** {{ $email }}
- **Subject:** {{ $contactSubject }}
</x-mail::panel>

**Message:**
{{ $messageText }}

<x-mail::button :url="'mailto:' . $email" color="primary">
Reply to {{ $name }}
</x-mail::button>

Thanks,
**{{ config('agency.system_signature') }}**
</x-mail::message>
