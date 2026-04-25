<x-mail::message>
# New Cancellation Request

A client has requested to cancel their subscription.

**Client:** {{ $subscription->user->name }} ({{ $subscription->user->email }})
**Plan:** {{ $subscription->plan->name }}
**Price:** €{{ $subscription->plan->price }} / {{ $subscription->plan->billing_cycle }}
**Started:** {{ $subscription->starts_at?->format('M d, Y') }}

<x-mail::button :url="config('app.url') . '/' . config('agency.admin_path', 'manage') . '/subscriptions'" color="primary">
View Subscriptions
</x-mail::button>

{{ config('agency.system_signature') }}
</x-mail::message>
