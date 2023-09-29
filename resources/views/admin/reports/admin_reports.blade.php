<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Summary Report</title>
    <link rel="shortcut icon" href="{{ public_path('assets/media/logos/mmg-infinity-logo.png')}} " />
    <style>
        .fonts {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        p,
        div,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
        }

        .row div {
            float: left;
            clear: none;
        }

        .table,
        .tr,
        .td,
        .th {
            border: 1px solid black;
            margin: 0;
            padding: 0;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .th {
            text-align: center;
            padding: 5px;
            font-weight: bold;
            font-size: 12px;
        }

        .td {
            padding: 3px
            /* width: auto;
            max-width: 100%; */
        }
    </style>
</head>

<body>
    <div style="width: 100%; text-align: center;">
        <img src="https://new-fedportal.mmgphil.org/assets/media/logos/MMG FEDERATION HEADER.jpg" style="width: 75%; object-fit: contain;">

        <h2 class="fonts" style="margin-top: 10px;">{{ $results[0]->chapterName }} Ticket Summary Report</h2>
        <p class="fonts">{{ date('M j, Y', strtotime($from)).' - '.date('M j, Y', strtotime($to)) }}</p>
    </div>

    <br> <br>

    <table style="width: 100%; border-collapse: collapse;" class="table">
        <tr>
            <th class="th" style="width: 2px">#</th>
            <th class="th" style="width: 10px !important">Status</th>
            <th class="th" style="width: 250px !important">Report Details</th>
            <th class="th" style="width: 250px !important">Action Taken</th>
        </tr>
        @php $ctr = 0; @endphp
        
        @foreach($results as $results)
        <tr class="tr">
            <td class="td" style="font-size: 11px; text-align:center">
                {{ $ctr+=1 }}
            </td>
            <td class="td" style="font-size: 11px; text-align:left; padding: 0px 7px">
                {{ $results->status }}
            </td>
            <td class="td" style="font-size: 11px; text-align:left; padding: 3px 7px; line-height: 1.3; width: 250px !important">
                <b>Name:</b> {{ $results->firstName . ' ' . $results->lastName  }} <br>
                <b>Date:</b> {{ date('M j, Y h:i A', strtotime($results->created_at)) }} <br>
                <b>Department:</b> {{ $results->department }} <br>
                <b>Type:</b> {{ $results->ticket_type }} <br>
                <b>Report Description:</b> {!! $results->narrative !!}
            </td>
            <td class="td" style="font-size: 11px; text-align:left; padding: 0px 7px; line-height: 1.3; width: 250px !important">
                @if ($results->status == 'RESOLVED')
                <b>Name:</b> {{ $results->resolvedBy }} <br>
                <b>Date:</b> {{ date('M j, Y h:i A', strtotime($results->resolvedDate)) }} <br>
                <b>Solution:</b> {{ $results->feedback }}
                @endif          
            </td>
        </tr>
        @endforeach
    </table>

    <br> <br>

    <table>
        <tr>
            <td style="width: 200px;font-weight:bold">Total Ticket:</td>
            <td>{{ $total }}</td>
        </tr>
        <tr>
            <td style="width: 200px;font-weight:bold">General Inquiry:</td>
            <td>
                @if (isset($categoryTotal[2]->total))
                    {{ $categoryTotal[2]->total }}
                @else
                    0
                @endif 
            </td>
        </tr>
        <tr>
            <td style="width: 200px;font-weight:bold">Implementation Support:</td>
            <td>
                @if (isset($categoryTotal[3]->total))
                    {{ $categoryTotal[3]->total }}
                @else
                    0
                @endif 
            </td>
        </tr>
        <tr>
            <td style="width: 200px;font-weight:bold">Error Encounter:</td>
            <td>
                @if (isset($categoryTotal[1]->total))
                    {{ $categoryTotal[1]->total }}
                @else
                    0
                @endif 
            </td>
        </tr>
        <tr>
            <td style="width: 200px;font-weight:bold">Change Request:</td>
            <td>
                @if (isset($categoryTotal[0]->total))
                    {{ $categoryTotal[0]->total }}
                @else
                    0
                @endif 
            </td>
        </tr>
        <tr>
            <td style="width: 200px;font-weight:bold">Others:</td>
            <td>
                @if (isset($categoryTotal[4]->total))
                    {{ $categoryTotal[4]->total }}
                @else
                    0
                @endif  
            </td>
        </tr>
    </table>
</body>

</html>