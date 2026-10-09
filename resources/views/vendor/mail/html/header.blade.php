@props(['url'])
@php
    $logoUrl = \App\Models\Pengaturan::url('logo', 'logo-smpn216.png');
    $host = parse_url($logoUrl, PHP_URL_HOST);
    $logoPublik = $host
        && !in_array($host, ['localhost', '127.0.0.1'])
        && !\Illuminate\Support\Str::endsWith($host, ['.test', '.local']);

    $logoFile = public_path(ltrim(urldecode(parse_url($logoUrl, PHP_URL_PATH) ?? ''), '/'));
    $logoSrc = $logoPublik ? $logoUrl : (is_file($logoFile) ? 'cid:logo-smpn216' : null);
@endphp
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
@if ($logoSrc)
<img src="{{ $logoSrc }}" alt="Logo SMPN 216 Jakarta" width="64" height="64"
     style="display:block;margin:0 auto 12px;width:64px;height:64px;border-radius:50%;object-fit:contain;background:#ffffff;">
@endif
<span style="display:block;font-size:20px;font-weight:700;color:#16324B;line-height:1.3;">MindCheck</span>
<span style="display:block;font-size:12px;font-weight:500;color:#52687D;margin-top:2px;">SMPN 216 Jakarta · Portal Skrining Kesehatan Mental</span>
</a>
</td>
</tr>