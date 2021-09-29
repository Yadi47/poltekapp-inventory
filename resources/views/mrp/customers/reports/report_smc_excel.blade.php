<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>

<body>
    <h3 style="text-align: center"></h3>
    <table>
        <thead>
            <tr>
                <td style="height: 20x; width:15px; font-size:14px; text-align:center">CUSTOMER</td>
                <td
                    style="height: 20x; width:15px; text-align:center; background-color:#FE7802; font-size:14px; vertical-align:middle; font-weight: bold;">
                    <span style="vertical-align: middle">
                        DOCK-CD
                    </span>
                </td>
                <td
                    style="height: 20x; width:15px; text-align:center; background-color:#FE7802; font-size:14px; vertical-align:middle; font-weight: bold;">
                    PART_NAME
                </td>
                <td
                    style="height: 20x; width:15px; text-align:center; background-color:#FE7802; font-size:14px; vertical-align:middle; font-weight: bold;">
                    PART_NO
                </td>
                @foreach ($header_date as $date)
                    <td style="height: 20x; text-align: center; width:15px; font-size:14px;">
                        {{ $date }}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{-- Forecast Table looping in controller --}}
            {!! $sum['col'] !!}
        </tbody>
    </table>
</body>

</html>
