<?php

namespace App\Providers;

use App\Models\Pengaturan;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Lampirkan logo ke email (CID) supaya tampil di Gmail walau masih di localhost.
        $embedLogo = function ($message) {
            $logoUrl = Pengaturan::url('logo', 'logo-smpn216.png');
            $path = public_path(ltrim(urldecode(parse_url($logoUrl, PHP_URL_PATH) ?? ''), '/'));

            if (is_file($path)) {
                $message->embedFromPath($path, 'logo-smpn216');
            }
        };

        // Email reset password
        ResetPassword::toMailUsing(function ($notifiable, $token) use ($embedLogo) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Atur ulang password MindCheck')
                ->greeting('Halo, ' . $notifiable->name)
                ->line('Kami menerima permintaan untuk mengatur ulang password akunmu.')
                ->action('Atur ulang password', $url)
                ->line('Tautan ini berlaku selama 60 menit.')
                ->line('Jika kamu tidak merasa memintanya, abaikan saja email ini. Passwordmu tidak akan berubah.')
                ->salutation('Salam, MindCheck SMPN 216 Jakarta')
                ->withSymfonyMessage($embedLogo);
        });

        // Email verifikasi pendaftaran
        VerifyEmail::toMailUsing(function ($notifiable, $url) use ($embedLogo) {
            return (new MailMessage)
                ->subject('Verifikasi email akun MindCheck')
                ->greeting('Halo, ' . $notifiable->name)
                ->line('Terima kasih sudah mendaftar di MindCheck SMPN 216 Jakarta.')
                ->line('Klik tombol di bawah ini untuk memverifikasi emailmu dan mengaktifkan akun.')
                ->action('Verifikasi email', $url)
                ->line('Tautan ini berlaku selama 60 menit.')
                ->line('Jika kamu tidak merasa mendaftar, abaikan saja email ini.')
                ->salutation('Salam, MindCheck SMPN 216 Jakarta')
                ->withSymfonyMessage($embedLogo);
        });
    }
}