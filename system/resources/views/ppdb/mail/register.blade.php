@component('mail::message')

Assalamualaikum,

Alamat email anda telah didaftarkan pada sistem Penerimaan Siswa Dididik Baru Tahun Akademik 2019/2020 di Yayasan Pendidikan Islam Jiwanala.

Berikut informasi akses yang digunakan selama proses PPDB

@component('mail::panel')
<table>
	<tbody>
		<tr>
			<td>URL PPDB</td>
			<td>:</td>
			<td>{{secure_url('ppdb.jiwa-nala.org')}}</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>:</td>
			<td>{{$user->email}}</td>
		</tr>
		<tr>
			<td>Kode Akses</td>
			<td>:</td>
			<td>{{$user->token}}</td>
		</tr>
	</tbody>
</table>
@endcomponent

Mohon simpan informasi akses diatas dengan baik.

Terimakasih,<br>
{{ config('app.name') }}
@endcomponent