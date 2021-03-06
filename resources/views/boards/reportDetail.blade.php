<div class="box box-primary">
<div class="box-header">
                            <h3 class="box-title">Izbor kartic</h3>
                        </div>
<div class = "box-body" id = "box">
<!-- <p>"{{$board->structuredColumns}}"</p> -->
<form class="form-horizontal" method="POST" action="{{ route('boards.makeReport', $board->id)}}">

@csrf
<input type="hidden" class="form-control" id="board" name="board"
              value ="{{ $board->id}}" >
<div class="form-group">
    <label for="projects" class="col-sm-2 control-label">Projekt</label>

     <div class="col-sm-10">
     <select class="col-sm-12" style="width:100%" name="projects[]" id="proj" multiple="multiple" placeholder="test">

                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ isset($data['projects']) && in_array($project->id . "", $data['projects']) ? 'selected' : '' }}
                    >{{ $project->board_name }}</option>
                @endforeach
            </select>
    </div>
    
</div>

<div class="form-group">
    <label for="type" class="col-sm-2 control-label">Tip kartice</label>

     <div class="col-sm-10">
        <select class="col-sm-12" style="width:100%" name="types[]" class="test" id = "type" multiple="multiple">                                                
            <option value="normal" {{ isset($data['types']) && in_array("normal", $data['types']) ? 'selected' : '' }}> nova funkcionalnost </option>
            <option value="is_silver_bullet" {{ isset($data['types']) && in_array("is_silver_bullet", $data['types']) ? 'selected' : '' }}> silver bullet </option>
            <option value="is_rejected" {{ isset($data['types']) && in_array("is_rejected", $data['types']) ? 'selected' : '' }}> zavrnjena zgodba </option>
                                               
        </select>

       
    </div>
</div>
<div class="form-group">
<div><label for="time" class="col-sm-12 control-label" style = "text-align:left">Zahtevnost</label></div>
    
<label for="time_start" class="col-sm-1 control-label">od</label>
     <div class="col-sm-5">
        <input type="number" min=0 class="form-control" id="time_start" name="time_start"
        value="{{(isset($old_request))?$old_request->time_start:""}}"  >
    </div>
    <label for="time_end" class="col-sm-1 control-label">do</label>
    <div class="col-sm-5">
        <input type="number" min=0 class="form-control" id="time_end" name="time_end"
        value="{{(isset($old_request))?$old_request->time_end:""}}"     >
    </div>
</div>

<div class="form-group">
<label  class="col-sm-12 left control-label" style = "text-align:left">Čas kreiranja kartice</label>
    <label for="creation_start" class="col-sm-1 control-label">od</label>

     <div class="col-sm-11">
        <input type="date" class="form-control" id="creation_start" name="creation_start"
               placeholder="zacetek" value="{{(isset($old_request))?$old_request->creation_start:""}}" >
    </div>
    <label for="creation_end" class="col-sm-1 control-label">do</label>
    <div class="col-sm-11">
        <input type="date" class="form-control" id="creation_end" name="creation_end"
               placeholder="zacetek" value="{{(isset($old_request))?$old_request->creation_end:""}}">
    </div>
</div>

<div class="form-group">
<label  class="col-sm-12 left control-label" style = "text-align:left">Čas zaključka kartice</label>
    <label for="finish_start" class="col-sm-1 control-label">od</label>

     <div class="col-sm-11">
        <input type="date" class="form-control" id="finish_start" name="finish_start"
               placeholder="zacetek" value="{{(isset($old_request))?$old_request->finish_start:""}}" >
    </div>
    <label for="finish_end" class="col-sm-1 control-label">do</label>
    <div class="col-sm-11">
        <input type="date" class="form-control" id="finish_end" name="finish_end"
               placeholder="zacetek" value="{{(isset($old_request))?$old_request->finish_end:""}}">
    </div>
</div>
<div class="form-group">
<label  class="col-sm-12 left control-label" style = "text-align:left">Čas začetka razvoja</label>
    <label for="dev_start" class="col-sm-1 control-label">od</label>

     <div class="col-sm-11">
        <input type="date" class="form-control" id="dev_start" name="dev_start"
               placeholder="zacetek" value="{{(isset($old_request))?$old_request->dev_start:""}}">
    </div>
    <label for="dev_end" class="col-sm-1 control-label">do</label>
    <div class="col-sm-11">
        <input type="date" class="form-control" id="dev_end" name="dev_end"
               placeholder="zacetek" value="{{(isset($old_request))?$old_request->dev_end:""}}">
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
        <select class="form-control" name="show_time"  id = "show_time" >                                                
            <option value="d" {{ isset($data['show_time']) && "d" == $data['show_time'] ? 'selected' : '' }}> dnevih </option>
            <option value="h" {{ isset($data['show_time']) && "h" == $data['show_time'] ? 'selected' : '' }}> urah </option>
            <option value="m" {{ isset($data['show_time']) && "m" == $data['show_time'] ? 'selected' : '' }}> minutah </option>
                                               
        </select>
    </div>
</div>
    <div class="form-group" id = "krneki" >
        <label for="type" class="col-sm-2 control-label">Tip poročila: </label>

        <div class="col-sm-10">
            <select class="form-control" onchange="getval(this);" name="report_type"  id = "report_type" >
                <option value="time" {{ isset($data['report_type']) && "time" == $data['report_type'] ? 'selected' : '' }}> Povprečni potreben čas </option>
                <option value="wip" {{ isset($data['report_type']) && "wip" == $data['report_type'] ? 'selected' : '' }}> Kršitve omejitev WIP </option>
                <option value="workflow" {{ isset($data['report_type']) && "workflow" == $data['report_type'] ? 'selected' : '' }}> Diagram delovnega toka </option>
            </select>


        </div>
    </div>

    <div class="form-group">
</div>

<p>{{(isset($old_request))?$old_request->time_start:""}}</p>

<input type="hidden" name="leaves" id="leaves">

<div class="form-group" id = "zadnji">
    <div class="col-sm-offset-7 col-sm-4">
        <button type="submit" class="btn btn-primary" id="submit_report">Pripravi poročilo</button>
    </div>
</div>


</form>
</div>
</div>


<script>
//(function(){$("#test").select2({data:[]});})();
h = "h";
d = "d";
m = "m";

function getval(sel)
{    console.log(sel.value);
    if(sel.value=="workflow"){
        $("#workflow-time").remove();
    $( `
    <div class="form-group" id = "workflow-time">
<label  class="col-sm-12 left control-label" style = "text-align:left">Časovni interval poročila</label>
    <label for="creation_start" class="col-sm-1 control-label">od</label>

     <div class="col-sm-11">
        <input type="date" class="form-control" id="report_start" name="report_start"
             value="{{(isset($old_request))?$old_request->report_start:""}}" >
    </div>
    <label for="creation_end" class="col-sm-1 control-label">do</label>
    <div class="col-sm-11">
        <input type="date" class="form-control" id="report_end" name="report_end"
               value="{{(isset($old_request))?$old_request->report_end:""}}">
    </div>
</div>
    ` ).insertAfter( "#krneki" );
    }else{
        $("#workflow-time").remove();
    }
 
}




old_request = {{(isset($old_request->time_start))&&$old_request->time_start!=""?$old_request->time_start:"null"}};
projects = '{{(isset($old_request->projects))&&$old_request->projects!=""?(implode(", ",array_map('strval',$old_request->projects))):"null"}}';
//test = projects;
proj_array = projects.split(",");

old_start_column = {{(isset($old_request->start_column))&&$old_request->start_column!=""?$old_request->start_column:"null"}};
old_end_column = {{(isset($old_request->end_column))&&$old_request->end_column!=""?$old_request->end_column:"null"}};
old_show_time = {{(isset($old_request->show_time))&&$old_request->show_time!=""?$old_request->show_time:"null"}};

console.log(old_start_column!=null?old_start_column:"prazna izjava");
window.onload = function () {
    findColumns();
    selected = document.getElementById("report_type");
    console.log(selected);
    getval(selected);
    //console.log("log");
    console.log("test " + proj_array);
    $("#proj").select2();
    $("#type").select2();
    //$("#type").val(old_request!=null?);
    if(old_show_time!=null) $("#show_time").val(old_show_time);


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
                 if(old_start_column!=null) $("#start_column").val(String(old_start_column));
                 if(old_end_column!=null) $("#end_column").val(String(old_end_column));

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