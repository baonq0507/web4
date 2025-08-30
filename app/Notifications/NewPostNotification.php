<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Post: ' . $this->post->title)
            ->greeting('Hello!')
            ->line('A new post has been published: ' . $this->post->title)
            ->line('Click the button below to read the post.')
            ->action('Read Post', url('/posts/' . $this->post->slug))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'slug' => $this->post->slug,
            'content' => $this->post->content,
            'image' => $this->post->image ? $this->post->image : null,
            'message' => 'New post published: ' . $this->post->title,
        ];
    }
} 