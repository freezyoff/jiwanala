@component('mail::message')
# Selamat Datang di JIWANALA

Terimakasih telah bergabung dengan JIWANALA. 

Klik tombol dibawah ini untuk membuat sandi.

@component('mail::button', ['url' => $token])
Buat Sandi/Password
@endcomponent

Kami menantikan kerjasama yang baik dari anda.

Terimakasih,<br>
{{ config('app.name') }}
@endcomponent