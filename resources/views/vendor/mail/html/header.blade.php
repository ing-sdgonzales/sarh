@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'SARH')
                <img src="https://conred.gob.gt/wp-content/uploads/logo-CONRED-normal.png" class="logo" alt="SARH"
                    style="height: 85px; width: 85px;">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
