@component('mail::message')

Assalamualaikum,

Alamat email anda telah didaftarkan pada sistem Penerimaan Siswa Dididik Baru Tahun Akademik 2019/2020 di <span style="font-weight:bold">Yayasan Pendidikan Islam Jiwanala</span>.

Berikut informasi akses yang digunakan selama proses PPDB

@component('mail::panel')
<table>
	<tbody>
		<tr>
			<td>URL PPDB</td>
			<td>:</td>
			<td>{{route('ppdb.landing')}}</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>:</td>
			<td>{{$user->email}}</td>
		</tr>
		<tr>
			<td>Kode Akses</td>
			<td>:</td>
			<td>{{$token}}</td>
		</tr>
	</tbody>
</table>
@endcomponent

Mohon simpan informasi akses diatas dengan baik sampai proses PPDB selesai.

Terimakasih,<br>
{{ config('app.name') }}
@endcomponent