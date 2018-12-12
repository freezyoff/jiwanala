@component('mail::message')
# Atur Ulang Sandi

Kami menerima permintaan Atur Ulang Sandi. Klik tombol dibawah ini untuk mengarahkan kehalaman atur ulang sandi.

@component('mail::button', ['url' => $token])
Reset Password
@endcomponent

Sistem akan meminta password baru. Ganti password sesuai keinginan dan pastikan mengganti password secara berkala.

Terimakasih,<br>
{{ config('app.name') }}
@endcomponent