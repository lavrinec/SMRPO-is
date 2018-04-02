<form>
    <div class="form-group">
        <label for="card_name" class="col-form-label">Ime naloge:</label>
        <input type="text" class="form-control" id="card_name">
    </div>
    <div class="form-group">
        <label for="description" class="col-form-label">Opis:</label>
        <textarea class="form-control" id="description"></textarea>
    </div>
    <div class="form-group">
        <label for="user_id" class="col-form-label">Lastnik:</label>
        <input type="number" class="form-control" id="user_id">
    </div>
    <div class="form-group">
        <label for="deadline" class="col-form-label">Rok:</label>
        <input type="date" class="form-control" id="deadline">
    </div>
    <div class="form-group">
        <label for="color" class="col-form-label">Barva:</label>
        <input type="color" class="form-control" id="color">
    </div>
    <div class="form-group">
        <label for="estimation" class="col-form-label">Ocena časa:</label>
        <input type="number" class="form-control" id="estimation">
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="is_critical" value="">Kritičen</label>
    </div>
    <div class="checkbox">
        <label><input type="checkbox" name="is_rejected" value="">Zavrnjen</label>
    </div>
</form>