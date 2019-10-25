<?php
/**
 * @var \Eliepse\Charts\HeatWeekCalendar\HeatWeekCalendar $heatmap
 * @var \Eliepse\Charts\HeatWeekCalendar\HeatRow $hour
 * @var \Eliepse\Charts\HeatWeekCalendar\HeatCell $day
 */
?>
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
    @foreach($heatmap->getData() as $hour)
        <tr>
            @foreach($hour as $day)
                @if($day > 0)
                    @php
                        switch ($day) {
                        case 3: $bg = '#63B3ED'; break;
                        case 2: $bg = '#90CDF4'; break;
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
