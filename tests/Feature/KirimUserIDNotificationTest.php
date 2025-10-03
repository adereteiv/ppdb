<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Notifications\KirimUserIDNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class KirimUserIDNotificationTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use DatabaseTransactions;

    public function test_mengirim_notifikasi_lewat_email_dengan_user_id(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'role_id' => 2,
        ]);

        // $user->notify(new KirimUserIDNotification($user->id));
        $user->notify(new KirimUserIDNotification($user->name, $user->id, $user->nomor_hp, $user->password));

        Notification::assertSentTo($user, KirimUserIDNotification::class, function ($notification, $channels) use ($user){
            $email = $notification->toMail($user);
            $emailContent = (string) $email->render();

            return str_contains($emailContent, "**ID Penguna Anda : ** " . $user->id);
        });
    }
}
