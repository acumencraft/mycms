<x-mail::message>
# New Subscription Request

A client has requested a new subscription.

**Client:** {{ $subscription->user->name }} ({{ $subscription->user->email }})
**Plan:** {{ $subscription->plan->name }}
**Price:** €{{ $subscription->plan->price }} / {{ $subscription->plan->billing_cycle }}

Please activate their subscription in the admin panel.

<x-mail::button :url="config('app.url') . '/' . config('agency.admin_path', 'manage') . '/subscriptions'" color="primary">
View Subscriptions
</x-mail::button>

{{ config('agency.system_signature') }}
</x-mail::message>
