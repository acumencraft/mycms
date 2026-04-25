<x-mail::message>
# Cancellation Request Received

Hi {{ $subscription->user->name }},

We have received your subscription cancellation request for the **{{ $subscription->plan->name }}** plan.

Our team will process your request and contact you within 1-2 business days.

**Subscription Details:**
- Plan: {{ $subscription->plan->name }}
- Price: €{{ $subscription->plan->price }} / {{ $subscription->plan->billing_cycle }}
- Status: Cancellation Pending

If you changed your mind, please contact us as soon as possible.

<x-mail::button :url="config('app.url') . '/client-dashboard'" color="primary">
View Dashboard
</x-mail::button>

Thanks,
{{ config('agency.team_signature') }}
</x-mail::message>
