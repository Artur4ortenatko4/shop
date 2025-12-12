<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Новий користувач зареєстрований')
            ->view('emails.admin_notification') // Шлях до вашого шаблону Email
            ->with([
                'name' => $this->user->name, // Передаємо ім'я користувача
                'email' => $this->user->email, // Передаємо Email користувача
                // Додайте інші дані, які вам потрібні
            ]);
    }
}
