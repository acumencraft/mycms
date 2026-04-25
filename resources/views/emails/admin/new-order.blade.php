<x-mail::message>
# New Order Received 🆕

A new order has been placed on **{{ config('agency.full_name') }}**.

<x-mail::panel>
**Order #{{ $order->id }} Details**

- **Client:** {{ $order->client_name }}
- **Email:** {{ $order->email }}
- **Phone:** {{ $order->phone ?? 'N/A' }}
- **Domain:** {{ $order->domain }}
- **Website Type:** {{ $order->website_type }}
- **Budget Range:** {{ $order->budget_range ?? 'N/A' }}
- **Timeline:** {{ $order->timeline ?? 'N/A' }}
- **Placed At:** {{ $order->created_at->format('M j, Y H:i') }}
</x-mail::panel>

@if($order->project_description)
**Project Description:**
{{ $order->project_description }}
@endif

@if($order->additional_requirements)
**Additional Requirements:**
{{ $order->additional_requirements }}
@endif

<x-mail::button :url="config('app.url') . '/' . config('agency.admin_path', 'manage') . '/orders/' . $order->id . '/edit'" color="primary">
View Order in Admin
</x-mail::button>

Thanks,
**{{ config('agency.full_name') }} System**
</x-mail::message>
