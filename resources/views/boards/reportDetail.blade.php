<div class="box box-primary">
<div class = "box-body">
<form class="form-horizontal" method="POST" action="{{ route('boards.makeReport') }}">

@csrf

<div class="form-group">
    <label for="projects" class="col-sm-1 control-label">Projekt</label>

     <div class="col-sm-11">
     <select class="form-control" name="projects[]" id="usersgroupsselect"
                                                    multiple="multiple" placeholder="test">

                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}"
                                                    >{{ $project->board_name }}</option>
                                                @endforeach
                                            </select>
    </div>
    
</div>

<div class="form-group">
    <label for="type" class="col-sm-1 control-label">Tip kartice</label>

     <div class="col-sm-11">
        <select class="form-control" name="types[]" class="test" id = "test" multiple="multiple">                                                
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
               >
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



<div class="form-group">
    <div class="col-sm-offset-8 col-sm-4">
        <button type="submit" class="btn btn-primary">Pripravi poročilo</button>
    </div>
</div>
</form>
</div>
</div>
<script>
         (function() {
    $('#test').select2();
})();
        </script>