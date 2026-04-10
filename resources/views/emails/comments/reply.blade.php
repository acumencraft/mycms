<x-mail::message>
# Someone replied to your comment 💬

Hi **{{ $parentComment->user->name }}**,

Someone replied to your comment on the {{ config('agency.name') }} Blog.

<x-mail::panel>
**Your original comment:**
{{ Str::limit($parentComment->body, 200) }}
</x-mail::panel>

<x-mail::panel>
**{{ $reply->user->name }} replied:**
{{ Str::limit($reply->body, 200) }}
</x-mail::panel>

<x-mail::button :url="config('app.url') . '/blog/' . $reply->publication->slug . '#comment-' . $reply->id" color="primary">
View Reply
</x-mail::button>

If you no longer wish to receive these notifications, you can manage your preferences in your account settings.

Thanks,
**{{ config('agency.team_signature') }}**
</x-mail::message>
