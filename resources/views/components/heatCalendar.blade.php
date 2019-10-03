<table class="w-100" style="table-layout: fixed" border="0">
    <thead>
    <tr class="text-center" style="color: #4FD1C5">
        <th>
            <small>L</small>
        </th>
        <th>
            <small>M</small>
        </th>
        <th>
            <small>M</small>
        </th>
        <th>
            <small>J</small>
        </th>
        <th>
            <small>V</small>
        </th>
        <th>
            <small>S</small>
        </th>
        <th>
            <small>D</small>
        </th>
    </tr>
    </thead>
    <tbody style="background-color: #F7FAFC">
    @foreach($stats[$campus->id] as $hour => $days)
        <tr>
            @foreach(App\Enums\DaysEnum::getKeys() as $day)
                @if(isset($days[$day]))
                    @php
                        switch ($days[$day]) {
                        case 2: $bg = '#63B3ED'; break;
                        case 1: $bg = '#90CDF4'; break;
                        default: $bg = '#BEE3F8';
                        }
                    @endphp
                    <td style="height: .6rem; background-color: {{ $bg }}"></td>
                @else
                    <td style="height: .6rem;"></td>
                @endif
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
