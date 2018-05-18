<div class="box">
    <div class="box-header">
        <h3 class="box-title">Poročilo o karticah</h3>
    </div>

    <div class="box-body">
        @if($report_type == 'wip')
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>št.</th>
                        <th>Kartica</th>
                        <th>Datum</th>
                        <th>Iz</th>
                        <th>V</th>
                        <th>Uporabnik</th>
                        <th>Vzrok</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($cards as $index => $card)
                    @foreach($card->wipViolations as $violation)
                        <tr>
                            <td width="40px">{{ ++$data['counter'] }}</td>
                            <td>
                                {{ $card->card_name }}
                            </td>
                            <td>{{ date("d.m.Y", strtotime($violation->created_at)) }}</td>
                            <td>{{ isset($violation->old_column) ? $violation->old_column->column_name : '' }}</td>
                            <td>{{ isset($violation->new_column) ? $violation->new_column->column_name : '' }}</td>
                            <td>{{ isset($violation->user) ? ($violation->user->id . '. ' . $violation->user->first_name . $violation->user->last_name) : '' }}</td>
                            <td>{{ $violation->reason }}</td>


                        </tr>
                    @endforeach
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>št.</th>
                        <th>Kartica</th>
                        <th>Datum</th>
                        <th>Iz</th>
                        <th>V</th>
                        <th>Uporabnik</th>
                        <th>Vzrok</th>
                    </tr>
                </tfoot>
            </table>
        @else
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>št.</th>
                    <th>Ime</th>
                    <th>Zahtevnost</th>
                    <th>Lead time</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cards as $index => $card)
                    <tr>
                        <td width="40px">{{ $index+1 }}</td>
                        <td>
                            {{ $card->card_name }}
                        </td>
                        <td>{{ $card->estimation }}</td>
                        <td>{{ $card->lead }}</td>


                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>št.</th>
                    <th>Ime</th>
                    <th>Zahtevnost</th>
                    <th>Lead time</th>

                </tr>
                </tfoot>
            </table>
        @endif
    </div>


</div>

<div class="box">
    @if(isset($average_time))

        <div class="box-header">
            <h3 class="box-title">Povprečni čas za izbrane kartice: {{$average_time}}</h3>
        </div>

    @endif
</div>