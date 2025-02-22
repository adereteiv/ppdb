<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class KirimUserIDNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $userId;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $userId)
    {
        //
        $this->userId = $userId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $email = (new MailMessage)
            ->subject('ID Pengguna Anda')
            ->greeting('Pendaftaran anak Anda melalui PPDB Online TK Negeri Pembina Sungai Kakap sudah masuk.')
            ->line(' Silakan melakukan login dengan ID Pengguna untuk melengkapi pendaftaran.')
            ->line('**ID Penguna Anda : ** '.$this->userId)
            ->line(' Mohon untuk menjaga informasi ini.')
            ->action('Lanjutkan ke halaman Login', url('/login'))
            ->line('Atas perhatiannya kami mengucapkan terima kasih!')
            ->line('(Apabila Anda tidak mendaftar, silakan abaikan email ini.)');

        return ($email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
