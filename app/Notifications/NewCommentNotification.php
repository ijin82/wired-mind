<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New comment was added to your blog!')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line('New comment was added to your blog!')
                    ->line('Comment author: ' . $this->comment->user->name)
                    ->action('Check comment', route('post', [
                        'id' => $this->comment->post->id
                    ]))
                    ->line('Have a nice day!')
                    ->line("You can [unsubscribe here](" . route('unsubscribe', [
                        'hash' => $notifiable->unsubscribe_replies_token
                    ]) .")");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
