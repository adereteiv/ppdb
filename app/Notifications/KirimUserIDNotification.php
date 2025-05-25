<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class KirimUserIDNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $name;
    private string $userId;
    private string $nomorHp;
    private string $rawPassword;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $name,string $userId, string $nomorHp, string $rawPassword)
    {
        //
        $this->name = $name;
        $this->userId = $userId;
        $this->nomorHp = $nomorHp;
        $this->rawPassword = $rawPassword;
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
            ->subject('Akun Anda Berhasil dibuat!')
            ->greeting('Pembuatan akun untuk pendaftaran anak Anda melalui PPDB Online TK Negeri Pembina Sungai Kakap sudah berhasil!')
            ->line('Informasi berikut dapat Anda gunakan untuk login guna melengkapi pendaftaran.')
            ->line('Nama: ' . $this->name)
            ->line('User ID: ' . $this->userId)
            ->line('Nomor HP: ' . $this->nomorHp)
            ->line('Password: ' . $this->rawPassword)
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
