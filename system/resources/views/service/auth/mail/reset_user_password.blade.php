@component('mail::message')
# Atur Ulang Sandi

Kami menerima permintaan Atur Ulang Sandi. Klik tombol dibawah ini untuk mengarahkan kehalaman atur ulang sandi.

@component('mail::panel')
<table>
	<tbody>
		<tr>
			<td>Alamat URL</td>
			<td>:</td>
			<td>
				<a href="{{$token}}" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#3869d4" 
					target="_blank" 
					data-saferedirecturl="https://www.google.com/url?q={{$token}}&amp;source=gmail&amp;&amp;usg=AOvVaw2hTpkH2yDWsTzAgYq3xRWM">{{$token}}</a>
			</td>
		</tr>
	</tbody>
</table>
@endcomponent

Sistem akan meminta password baru. Ganti password sesuai keinginan dan pastikan mengganti password secara berkala.

Terimakasih,<br>
{{ config('app.name') }}
@endcomponent