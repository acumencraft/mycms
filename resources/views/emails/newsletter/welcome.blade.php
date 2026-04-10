<x-mail::message>
# Welcome to {{ config('agency.name') }} Newsletter! 🎉

{{ $subscriber->name ? 'Hi **' . $subscriber->name . '**,' : 'Hi there,' }}

Thank you for subscribing to the **{{ config('agency.full_name') }}** newsletter. You will receive updates on:

- 🚀 Web development tips & tricks
- 💡 New services and offers
- 📝 Latest blog posts and guides
- 🎯 Industry news and insights

<x-mail::button :url="config('app.url')" color="primary">
Visit Our Website
</x-mail::button>

If you ever wish to unsubscribe, simply click the link below.

<x-mail::subcopy>
[Unsubscribe]({{ $subscriber->unsubscribeUrl() }}) from this newsletter.
</x-mail::subcopy>

Thanks,
**{{ config('agency.team_signature') }}**
</x-mail::message>
