<x-mail::message>
# Purchase Confirmed! 🎉

Dear **{{ $purchase->user->name }}**,

Thank you for your purchase! Your digital product is ready to download.

<x-mail::panel>
**Purchase Summary**
- **Product:** {{ $purchase->version->product->name }}
- **Version:** {{ $purchase->version->version_number }}
- **Amount Paid:** ${{ number_format($purchase->amount, 2) }}
- **Transaction ID:** {{ $purchase->transaction_id }}
- **License Key:** `{{ $purchase->license_key }}`
- **Download Limit:** {{ $purchase->download_limit }} downloads
@if($purchase->download_expires_at)
- **Access Expires:** {{ $purchase->download_expires_at->format('M d, Y') }}
@endif
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/client-dashboard'" color="primary">
Go to Dashboard & Download
</x-mail::button>

If you have any questions, feel free to reply to this email.

Thanks,
**{{ config('agency.team_signature') }}**
</x-mail::message>
