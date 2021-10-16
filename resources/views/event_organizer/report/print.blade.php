<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Print Report</title>  
    <link rel="shortcut icon"
          href="{{ CRUDBooster::getSetting('favicon')?asset(CRUDBooster::getSetting('favicon')):asset('vendor/crudbooster/assets/logo_crudbooster.png') }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <table class='table table-bordered' style="table-layout:fixed;">
        <thead>
            <tr>
                <th colspan="2" class="text-center">EVENT DETAILS</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="index==0">
                <th>Event Name</th>
                <td>{{$event->name}}</td>
            </tr>
            <tr v-if="index==0">
                <th>Event Organizer</th>
                <td>{{ CRUDBooster::myName() }}</td>
            </tr>
            <tr v-if="index==0">
                <th>Event Status</th>
                <td>{{$event->status}}</td>
            </tr>
            <tr v-if="index==0">
                <th>Created Date</th>
                <td>{{$event->created_at}}</td>
            </tr>
            <tr v-if="index==0">
                <th>Held</th>
                <td>{{$event->date_start}} until {{$event->date_end}}</td>
            </tr>
            <tr v-if="index==0">
                <th>Number of Categories</th>
                <td>{{count($categories)}}</td>
            </tr>
            <tr>
                <th>Draw Categories</th>
                @if(count($categories)>0)
                <td>
                    <ul>
                        @foreach($categories as $category)
                            @if($category->is_draw==1)
                                <li>{{$category->name}} &nbsp;&nbsp;<span class="label label-success">(Drawn - {{$category->total_winner}} winners)</span></li>
                            @else
                                <li>{{$category->name}}</li>
                            @endif
                        @endforeach
                    </ul>
                </td>
                @else
                <td> - </td>
                @endif
            </tr>
        </tbody>
    </table>

    <br>
    <table class='table'>
        <thead>
            <tr>
                <th colspan="3" class="text-center">WINNERS DETAILS</th>
            </tr>
        </thead>
            @foreach($winners as $row)
                @if($loop->index==0 || $winners[$loop->index-1]->category_name != $row->category_name)
                    <tr>
                        <td colspan="3" style="margin-top: 5px">
                            <b>{{$row->category_name}}</b>
                        </td>
                    </tr>
                    @php
                        $i = 1;
                    @endphp
                @endif

                @if($row->name != '')
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->email}}</td>
                </tr>
                @else
                <tr>
                    <td colspan="3">No winners available</td>
                </tr>
                @endif

                @php
                    $i++;
                @endphp
            @endforeach
    </table>
<script type="text/javascript">
    window.print();
</script>
</body>
</html>