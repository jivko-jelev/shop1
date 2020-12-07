<div class="form-group">
    <label for="subproperty[{new sub property}]" class="col-sm-4 control-label">Нов податрибут</label>
    <div class="col-sm-8 error-div">
        <div class="input-group">
            <input type="text" class="form-control subproperty" name="new_subproperty[{index}][{new sub property}]"
                   id="subproperty-{new sub property}" placeholder="Податрибут"
                   value="">
            <span class="input-group-btn">
            <button type="button" class="btn btn-primary add-property-subproperty" title="Добави податрибут">
                <i class="fa fa-plus" aria-hidden="true"></i>
            </button>
            <button type="button" class="btn btn-danger delete-subproperty" title="Изтрий">
                <i class="fa fa-minus" aria-hidden="true"></i>
            </button>
        </span>
        </div>
        <span class="error" id="alias-error-modal"></span>
    </div>
</div>