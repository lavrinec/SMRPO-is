<div class="box">
    <div class="box-header">
        <h3 class="box-title">Poročilo o karticah</h3>
    </div>

    <div class="box-body">
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
    </div>


</div>

<div class="box">
    @if(isset($average_time))

        <div class="box-header">
            <h3 class="box-title">Povprečni čas za izbrane kartice: {{$average_time}}</h3>
        </div>

    @endif
</div>