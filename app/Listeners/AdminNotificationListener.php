<?php

namespace App\Listeners;


use App\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNotification;
use App\Models\User;
class AdminNotificationListener
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // Отримайте об'єкт користувача з події
        $user = $event->user;

        // Отримайте список адміністраторів, яким потрібно відправити Email
        $admins = User::where('role', 'admin')->get();

        // Відправте Email кожному адміністратору
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new AdminNotification($user));
        }
    }
}

