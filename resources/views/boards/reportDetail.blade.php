<div class="box box-primary">
<div class="box-header">
                            <h3 class="box-title">Izbor kartic</h3>
                        </div>
<div class = "box-body">
<!-- <p>"{{$board->structuredColumns}}"</p> -->
<form class="form-horizontal" method="POST" action="{{ route('boards.makeReport', $board->id)}}">

@csrf
<input type="hidden" class="form-control" id="board" name="board"
              value ="{{ $board->id}}" >
<div class="form-group">
    <label for="projects" class="col-sm-2 control-label">Projekt</label>

     <div class="col-sm-10">
     <select class="col-sm-12" style="width:100%" name="projects[]" id="test" multiple="multiple" placeholder="test">

                @foreach($projects as $project)
                    <option value="{{ $project->id }}" 
                    >{{ $project->board_name }}</option>
                @endforeach
            </select>
    </div>
    
</div>

<div class="form-group">
    <label for="type" class="col-sm-2 control-label">Tip kartice</label>

     <div class="col-sm-10">
        <select class="col-sm-12" style="width:100%" name="types[]" class="test" id = "test" multiple="multiple">                                                
            <option value="normal"> nova funkcionalnost </option>
            <option value="is_silver_bullet"> silver bullet </option>
            <option value="is_rejected"> zavrnjena zgodba </option>
                                               
        </select>

       
    </div>
</div>
<div class="form-group">
<div><label for="time" class="col-sm-12 control-label" style = "text-align:left">Zahtevnost</label></div>
    
<label for="time_start" class="col-sm-1 control-label">od</label>
     <div class="col-sm-5">
        <input type="number" min=0 class="form-control" id="time_start" name="time_start"
        value="{{ old('time_start') }}"  >
    </div>
    <label for="time_end" class="col-sm-1 control-label">do</label>
    <div class="col-sm-5">
        <input type="number" min=0 class="form-control" id="time_end" name="time_end"
               >
    </div>
</div>

<div class="form-group">
<label  class="col-sm-12 left control-label" style = "text-align:left">Čas kreiranja kartice</label>
    <label for="creation_start" class="col-sm-1 control-label">od</label>

     <div class="col-sm-11">
        <input type="date" class="form-control" id="creation_start" name="creation_start"
               placeholder="zacetek">
    </div>
    <label for="creation_end" class="col-sm-1 control-label">do</label>
    <div class="col-sm-11">
        <input type="date" class="form-control" id="creation_end" name="creation_end"
               placeholder="zacetek">
    </div>
</div>

<div class="form-group">
<label  class="col-sm-12 left control-label" style = "text-align:left">Čas zaključka kartice</label>
    <label for="finish_start" class="col-sm-1 control-label">od</label>

     <div class="col-sm-11">
        <input type="date" class="form-control" id="finish_start" name="finish_start"
               placeholder="zacetek">
    </div>
    <label for="finish_end" class="col-sm-1 control-label">do</label>
    <div class="col-sm-11">
        <input type="date" class="form-control" id="finish_end" name="finish_end"
               placeholder="zacetek">
    </div>
</div>
<div class="form-group">
<label  class="col-sm-12 left control-label" style = "text-align:left">Čas začetka razvoja</label>
    <label for="dev_start" class="col-sm-1 control-label">od</label>

     <div class="col-sm-11">
        <input type="date" class="form-control" id="dev_start" name="dev_start"
               placeholder="zacetek">
    </div>
    <label for="dev_end" class="col-sm-1 control-label">do</label>
    <div class="col-sm-11">
        <input type="date" class="form-control" id="dev_end" name="dev_end"
               placeholder="zacetek">
    </div>
</div>

<div class="form-group" >
<div><label for="time" class="col-sm-12 control-label" style = "text-align:left">Med stolpci</label></div>
    
<div class="col-sm-6" >
<div style ="font-weight: bold">Začetni stolpec</div>
        <select class="form-control" onchange="checkColumns()" name="start_column"  id = "start_column">                                                
            
                                               
        </select>
</div>
<div class="col-sm-6">
<div style ="font-weight: bold" id="jquery">Končni stolpec</div>
        <select class="form-control" onchange="checkColumns()" name="end_column"  id = "end_column">                                                
           
                                               
        </select>
    
</div>

<div  class="col-sm-12" id ="select_columns"></div>

</div>

<div class="form-group">
    <label for="type" class="col-sm-2 control-label">Prikaži čas v: </label>

     <div class="col-sm-10">
        <select class="form-control" name="show_time"  id = "show_time">                                                
            <option value="d"> dnevih </option>
            <option value="h"> urah </option>
            <option value="m"> minutah </option>
                                               
        </select>

       
    </div>
</div>

<input type="hidden" name="leaves" id="leaves">

<div class="form-group">
    <div class="col-sm-offset-7 col-sm-4">
        <button type="submit" class="btn btn-primary" id="submit_report">Pripravi poročilo</button>
    </div>
</div>


</form>
</div>
</div>


<script>
//(function(){$("#test").select2({data:[]});})();

window.onload = function () {
    findColumns();
    //console.log("log");
    //console.log($("#test"));
    $("#test").select2();
}




function checkColumns(){
                var end = $("#end_column").val();
                var start = $("#start_column").val();
                var startIndex = leaves.findIndex(x => x.id==start);
                var endIndex = leaves.findIndex(x => x.id==end);
                if (startIndex>endIndex){
                    $("#error").remove();
                    $("#select_columns").append(" <p id='error'>Drugi stolpec mora biti večji ali enak prvemu</p>");
                    $("#submit_report").attr("disabled", "disabled");
                   
                }else{
                    $("#error").remove();
                    $("#submit_report").removeAttr("disabled");     
                }
}

var board = {!! $board !!};


        var rootColumns = board.structured_columns;
        var leaves = getAllLeaves();
        console.log(rootColumns);

        function findColumns(){
            
           
            
            var leaves = getAllLeaves();
            var leave_ids = [];
             console.log("zakljucil get all leaves");
  
                 for (var i = 0; i < leaves.length; i++) {
                $("#end_column").append("<option value="+leaves[i].id +">"+leaves[i].column_name+" </option>");
                $("#start_column").append("<option value="+leaves[i].id +">"+leaves[i].column_name+" </option>");
                        leave_ids.push(leaves[i].id);
                 }

                 $("#leaves").attr("value", leave_ids);

        }
        function getAllLeaves() {
            var leavesX = [];
            console.log("znotraj get all leaves");

            if (rootColumns.length > 0) {
                console.log("if se poklice");
                for (var col in rootColumns) {
                    console.log("klicem col");
                    console.log(col);
                    if (rootColumns.hasOwnProperty(col)) {
                        leavesX = leavesX.concat(getLeaves(rootColumns[col]));
                    }
                }
            }

             console.log("leaves");
             console.log(leavesX);

            return leavesX;

        }
        function getLeaves(column) {
            var leaves = [];

            if (column.all_children == 0) {
                return [column];
            }
            else {
                for (var key in column.all_children) {
                    if (column.all_children.hasOwnProperty(key)) {
                        leaves = leaves.concat(getLeaves(column.all_children[key]));
                    }
                }
                return leaves;
            }
        }
        </script>