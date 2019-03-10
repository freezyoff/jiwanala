@component('mail::message')
# Selamat Datang di JIWANALA

Terimakasih telah bergabung dengan JIWANALA. 

Klik tombol dibawah ini untuk mengarahkan kehalaman membuat sandi.

@component('mail::button', ['url' => $token])
Buat Sandi/Password
@endcomponent

Apabila mengalami kesulitan klik tombol <b>Buat Sandi/Password</b>, klik tautan dibawah ini untuk mengarahkan kehalaman buat sandi.
@component('mail::panel')
<table>
    <tbody>
        <tr>
            <td><a href="{{$token}}" alt="Buat Sandi/Password" title="Buat Sandi/Password">Buat Sandi/Password</a></td>
        </tr>
    </tbody>
</table>
@endcomponent

Kami menantikan kerjasama yang baik dari anda.

Terimakasih,<br>
{{ config('app.name') }}
@endcomponent