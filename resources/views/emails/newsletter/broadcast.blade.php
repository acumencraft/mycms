<x-mail::message>
{!! nl2br(e($emailBody)) !!}

<x-mail::button :url="config('app.url')" color="primary">
Visit Our Website
</x-mail::button>

<x-mail::subcopy>
You are receiving this email because you subscribed to {{ config('agency.name') }} Newsletter.
[Unsubscribe]({{ $subscriber->unsubscribeUrl() }}) from this newsletter.
</x-mail::subcopy>

Thanks,
**{{ config('agency.team_signature') }}**
</x-mail::message>
