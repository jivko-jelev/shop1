<div class="property" data-index="{new property}">
    <hr>
    <div class="form-group">
        <label for="property[{new property}]" class="col-sm-4 control-label">Нов атрибут</label>
        <div class="col-sm-8 error-div">
            <div class="input-group">
                <input type="text" class="form-control property" name="new_property[{new property}]"
                       id="property[{new property}]" placeholder="Атрибут">
                <span class="input-group-btn">
                   <button type="button" class="btn btn-primary add-property">Добави</button>
                   <button type="button" class="btn btn-danger delete-property">Изтрий</button>
               </span>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-4">
            <div class="input-group">
                <input type="checkbox"
                       class="icheckbox_minimal-blue"
                       name="multiple[{new property}]"
                       id="multiple[{new property}]">
                <label for="multiple[{new property}]">Възможност за избиране на повече от един податрибут</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="subproperty[{new property}][0]" class="col-sm-4 control-label">Нов податрибут
        </label>
        <div class="col-sm-8 error-div">
            <div class="input-group">
                <input type="text" class="form-control subproperty" name="new_subproperty[{new property}][0]"
                       id="subproperty[{new property}][0]" placeholder="Податрибут"
                       value="">
                <span class="input-group-btn">
                <button type="button" class="btn btn-primary add-property-subproperty"
                        title="Добави податрибут">
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
</div>