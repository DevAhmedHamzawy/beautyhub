<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Password;

class AdminCreatedNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // إنشاء reset token
        $token = Password::broker('admins')->createToken($notifiable);

        // لينك reset password
        $resetUrl = url(route('admin.reset-password', [
            'token' => $token,
            'email' => $notifiable->email,
        ], false));

        return (new MailMessage)
            ->subject('Your Admin Account Has Been Created')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your admin account has been created successfully.')
            ->line('Click the button below to set your password.')
            ->action('Reset Password', $resetUrl)
            ->line('If you did not expect this email, please ignore it.');
    }
}
