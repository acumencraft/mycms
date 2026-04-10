<x-mail::message>
# Order Confirmed! 🎉

Dear **{{ $order->client_name }}**,

Thank you for placing your order with **{{ config('agency.full_name') }}**. We have received your request and will be in touch shortly.

<x-mail::panel>
**Order #{{ $order->id }} Summary**

- **Domain:** {{ $order->domain }}
- **Website Type:** {{ $order->website_type }}
- **Status:** {{ ucfirst($order->status) }}
@if($order->budget_range)
- **Budget Range:** {{ $order->budget_range }}
@endif
@if($order->timeline)
- **Timeline:** {{ $order->timeline }}
@endif
</x-mail::panel>

@if($order->project_description)
**Project Description:**
{{ $order->project_description }}
@endif

We will review your order and contact you within **1-2 business days**.

<x-mail::button :url="config('app.url') . '/client-dashboard'" color="primary">
View Your Dashboard
</x-mail::button>

If you have any questions, feel free to reply to this email.

Thanks,
**{{ config('agency.team_signature') }}**
</x-mail::message>
