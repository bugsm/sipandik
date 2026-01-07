@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://diskominfotik.lampungprov.go.id/berkas/uploads//photos/1/logo.png" class="logo" alt="Diskominfotik Logo">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
