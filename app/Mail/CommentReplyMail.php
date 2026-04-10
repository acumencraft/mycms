<?php
namespace App\Mail;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
class CommentReplyMail extends Mailable
{
    use Queueable, SerializesModels;
    public function __construct(
        public Comment $reply,
        public Comment $parentComment,
    ) {}
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💬 Someone replied to your comment — ' . config('agency.name') . ' Blog',
        );
    }
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.comments.reply',
        );
    }
}
