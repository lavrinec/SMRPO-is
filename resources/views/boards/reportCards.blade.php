<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

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
                    <th>Ura</th>
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
                            <td data-sort="{{ $violation->created_at }}">
                                {{ date("d.m.Y", strtotime($violation->created_at)) }}
                            </td>
                            <td data-sort="{{ $violation->created_at }}">
                                {{ date("H:i", strtotime($violation->created_at)) }}
                            </td>
                            <td>{{ isset($violation->old_column) ? $violation->old_column->column_name : '' }}</td>
                            <td>{{ isset($violation->new_column) ? $violation->new_column->column_name : '' }}</td>
                            <td>
                                {{ isset($violation->user)
                                ? ($violation->user->id . '. ' . $violation->user->first_name . $violation->user->last_name)
                                : '' }}
                            </td>
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
                    <th>Ura</th>
                    <th>Iz</th>
                    <th>V</th>
                    <th>Uporabnik</th>
                    <th>Vzrok</th>
                </tr>
                </tfoot>
            </table>


        @elseif($report_type == 'workflow')
        </canvas><canvas id="myChart"></canvas>

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

<script>
let workflow = {!!$workflow!!};
let names = {!!$names!!};
console.log("to so names", names);
labels = [];
data = []
console.log("to je workflow", workflow);
workflow.forEach(
    function(column){
        col_data=[];
        labels=[];
    column.forEach(function(element) {
        
  labels.push(element[0]);
  col_data.push(element[1]);
});
    data.push(col_data)}
);


background_colors = [
    "rgba(151,2230,250,1)",
    "rgba(133,220,214,1)",
    "rgba(159,243,214,1)",
    "rgba(133,220,165,1)",
    "rgba(151,250,159,1)",
    "rgba(112,222,131,1)",
    "rgba(181,245,112,1)"
]
console.log("to je labels", labels);
console.log("to je data", data);
datasets = [];
for(i=0; i<data.length; i++){
    object = {
        label:names[i],
        data:data[i],
        backgroundColor:background_colors[i%background_colors.length]
    }
    datasets.push(object);
}
console.log("to so dataseti", datasets);
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: datasets.reverse()
  }, 
  options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        },
        elements: {
            line: {
                tension: 0, // disables bezier curves
            }
        }
    }
});
</script>