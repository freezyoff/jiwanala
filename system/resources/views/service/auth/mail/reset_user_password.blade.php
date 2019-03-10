@component('mail::message')
# Atur Ulang Sandi

Kami menerima permintaan Atur Ulang Sandi. Klik tombol dibawah ini untuk mengarahkan kehalaman atur ulang sandi.

@component('mail::button', ['url' => $token])
Reset Password
@endcomponent

Apabila mengalami kesulitan klik tombol <b>Reset Password</b>, klik tautan dibawah ini untuk mengarahkan kehalaman atur ulang sandi.
@component('mail::panel')
<table>
    <tbody>
        <tr>
            <td><a href="{{$token}}" alt="Reset Password" title="Reset Password">Reset Password</a></td>
        </tr>
    </tbody>
</table>
@endcomponent

Sistem akan meminta password baru. Ganti password sesuai keinginan dan pastikan mengganti password secara berkala.

Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
