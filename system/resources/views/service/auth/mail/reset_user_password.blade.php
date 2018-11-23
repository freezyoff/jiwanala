@component('mail::message')
# Atur Ulang Sandi

Kami menerima permintaan Atur Ulang Sandi. Klik tombol dibawah untuk mengarahkan laman web.

@component('mail::button', ['url' => $url])
Atur Ulang Sandi
@endcomponent

Apabila anda tidak merasa mengajukan permitaan atur ulang sandi, abaikan email ini. 

Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
