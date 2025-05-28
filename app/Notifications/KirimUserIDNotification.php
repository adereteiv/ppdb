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
    public function __construct(string $name, string $userId, string $nomorHp, string $rawPassword)
    {
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
        $loginUrl = url('/login'); // atau gunakan config('app.url') . '/login' jika perlu

        return (new MailMessage)
            ->subject('Akun Anda Berhasil Dibuat - PPDB TK Negeri Pembina Sungai Kakap')
            ->greeting('Halo, ' . $this->name . ' 👋')
            ->line('Pendaftaran akun untuk PPDB Online TK Negeri Pembina Sungai Kakap telah berhasil.')
            ->line('')
            ->line('Berikut adalah informasi akun Anda:')
            ->line('**User ID:** ' . $this->userId)
            ->line('**Nomor HP:** ' . $this->nomorHp)
            ->line('**Password:** ' . $this->rawPassword)
            ->line('_Mohon simpan informasi ini dengan baik dan rahasiakan dari orang lain._')
            ->action('Login Sekarang', $loginUrl)
            ->line('Terima kasih telah mendaftar. Jika Anda tidak merasa melakukan pendaftaran ini, abaikan email ini.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'name' => $this->name,
            'user_id' => $this->userId,
            'nomor_hp' => $this->nomorHp,
            'password' => bcrypt($this->rawPassword)
        ];
    }
}
