<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Редакция</h4>
        </div>
        <!-- form start -->
        <form class="form-horizontal" id="form-edit-category" autocomplete="off" method="post"
              action="{{ route('categories.update', $current_category) }}">
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-4 control-label">Име</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Име"
                                   value="{{ $current_category->title }}">
                            <span class="error" id="title-error-modal"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alias" class="col-sm-4 control-label">Псевдоним</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="alias" id="alias" placeholder="Псевдоним"
                                   value="{{ $current_category->alias }}">
                            <span class="error" id="alias-error-modal"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="parent_id" class="col-sm-4 control-label">Главна Категория</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="parent_id" name="parent_id">
                                <option value="">Без</option>
                                @foreach($categories as $category)
                                    @if($category->id != $current_category->id)
                                        <option value="{{ $category->id }}"@if($current_category->parent_id==$category->id) selected @endif>{{ $category->title }} ({{ $category->alias }})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- /.box-body -->
                <a class="btn btn-default" data-dismiss="modal">Затвори</a>
                <button type="submit" id="submit" class="btn btn-primary pull-right">Промени</button>
                <!-- /.box-footer -->
            </div>
            @csrf
            @method('put')
        </form>
    </div>
</div>
<script>
    $('#submit').click(function (e) {
        e.preventDefault();
        var form = $("#form-edit-category");
        $.ajax({
            url: "{{ route('categories.update', $current_category) }}",
            context: document.body,
            data: form.serialize(),
            method: 'post',
            success: function (data) {
                showSuccessMessage(data.message);
                $('#myModal').modal('hide');
                table.ajax.reload(null, false);
            },
            error: function (data) {
                $('.error').html('');
                for (let i = 0; i < Object.keys(data.responseJSON.errors).length; i++) {
                    if (Object.keys(data.responseJSON.errors)[i] !== undefined) {
                        let key = Object.keys(data.responseJSON.errors)[i];
                        $(`#${key}-error-modal`).html(data.responseJSON.errors[key]);
                    }
                }
                Lobibox.notify('error', {
                    showClass: 'rollIn',
                    hideClass: 'rollOut',
                    msg: 'Възникна някаква грешка при опита за промяна на данните на категорията'
                });
            }
        })
    });
</script>
