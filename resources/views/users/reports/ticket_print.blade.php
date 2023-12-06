<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Inventory Report</title>
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
            font-size: 13px;
        }

        .td {
            padding: 3px
        }
    </style>
</head>

<body>
    <div style="width: 100%; text-align: center;">
        <img src="https://new-fedportal.mmgphil.org/assets/media/logos/MMG FEDERATION HEADER.jpg" style="width: 75%; object-fit: contain;">
    </div>

    <br><br>

    <h2>Ticket #: <small>{{ $details->ticket_code }}</small></h2>
    <br>
    <table>
        <tr>
            <td style="width: 100px">
                <b>Status</b>
            </td>
            <td style="width: 200px">{{ $details->status }}</td>
            <td style="width: 60px">
                <b>Name</b>
            </td>
            <td>{{ $details->firstName.' '.$details->lastName }}</td>
        </tr>
        <tr>
            <td style="width: 100px">
                <b>Priority</b>
            </td>
            <td style="width: 200px">{{ $details->priority }}</td>
            <td style="width: 60px">
                <b>Email</b>
            </td>
            <td>{{ $details->email }}</td>
        </tr>
        <tr>
            <td style="width: 100px">
                <b>Department</b>
            </td>
            <td style="width: 200px">{{ $details->department }}</td>
            <td style="width: 60px">
                <b>Phone</b>
            </td>
            <td>{{ $details->number }}</td>
        </tr>
        <tr>
            <td style="width: 100px">
                <b>Date Created</b>
            </td>
            <td style="width: 200px">{{ $details->created_at }}</td>
            <td style="width: 60px">
                <b>Chapter</b>
            </td>
            <td>{{ $details->chapterName }}</td>
        </tr>
    </table>

    <br>
    <h2>Ticket Type: <small>{{ $details->ticket_type }}</small></h2>
    <br>
    
    <h4>Narrative</h4>
    {!! $details->narrative  !!}

    @if (count($comment) > 0)
    <br>
    <h2>Comments:</h2>

    @foreach ($comment as $comment)
        @php
            $formattedDate = \Carbon\Carbon::parse($comment->created_at)->format('M j, Y g:i A');
        @endphp

        <div style="margin-bottom: 15px">
            <h5>{{ $comment->sender }} <small> {{ $formattedDate }} </small></h5>
            {!! $comment->comments  !!}
        </div>
    @endforeach
@endif
</body>

</html>