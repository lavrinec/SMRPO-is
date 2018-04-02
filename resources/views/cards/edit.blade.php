<form id="updateCard" method="POST" action="{{ action('CardController@update', isset($card) ? $card->id : 0) }}">
    <input type="hidden" class="form-control" id="_token" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" class="form-control" id="column_id" name="column_id" value="1">
    <!--<input type="hidden" class="form-control" id="id" value="{{ isset($card) ? $card->id : '0' }}">-->
    <div class="form-group">
        <label for="card_name" class="col-form-label">Ime naloge:</label>
        <input type="text" class="form-control" id="card_name" name="card_name" value="{{ isset($card) ? $card->card_name : '' }}" required>
    </div>
    <div class="form-group">
        <label for="description" class="col-form-label">Opis:</label>
        <textarea class="form-control" id="description" name="description">{{ isset($card) ? $card->description : '' }}</textarea>
    </div>
    <div class="form-group">
        <label for="user_id" class="col-form-label">Lastnik:</label>
        <select class="form-control select2" id="user_id" name="user_id">
            @foreach($users as $user)
                <option value="0"></option>
                <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="deadline" class="col-form-label">Rok:</label>
        <input type="date" class="form-control" id="deadline" name="deadline"  value="{{ isset($card) ? $card->deadline : '' }}" required>
    </div>
    <div class="form-group">
        <label for="color" class="col-form-label">Barva:</label>
        <input type="color" class="form-control" id="color" name="color"  value="{{ isset($card) ? $card->color : '#6fdede' }}">
    </div>
    <div class="form-group">
        <label for="estimation" class="col-form-label">Ocena časa:</label>
        <input type="number" class="form-control" id="estimation" name="estimation"  value="{{ isset($card) ? $card->estimation : '' }}">
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="is_critical" {{ isset($card) && $card->is_critical ? 'checked' : '' }}>Kritičen</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="is_rejected" {{ isset($card) && $card->is_rejected ? 'checked' : '' }}>Zavrnjen</label>
    </div>
    <input type="submit" style="display: none;">
</form>
<script>
    var $disabledResults = $(".select2");
    $disabledResults.select2();
</script>