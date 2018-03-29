@if ($errors->has('msg'))
    <br>
    <div class="alert alert-danger">
        {{ $errors->first('msg') }}
    </div>
@endif