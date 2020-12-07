<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Редакция</h4>
        </div>
        <!-- form start -->
        <form class="form-horizontal" id="form-edit-user" autocomplete="off" method="post" action="{{ route('users.update', $user) }}">
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Потребителско Име</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Потребителско Име"
                                   value="{{ old('name', $user->name) }}" autocomplete="off">
                            <span class="error" id="name-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">Имейл</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Имейл"
                                   value="{{ old('email', $user->email) }}">
                            <span class="error" id="email-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-4 control-label">Парола</label>

                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Парола">
                            <span class="error" id="password-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="col-sm-4 control-label">Повтори
                            Паролата</label>

                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Повтори Паролата">
                            <span class="error" id="password_confirmation-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="col-sm-4 control-label">Име</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="first_name" placeholder="Име"
                                   value="{{ old('first_name', $user->first_name) }}">
                            <span class="error" id="first_name-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-sm-4 control-label">Фамилия</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="last_name" placeholder="Фамилия"
                                   value="{{ old('last_name', $user->last_name) }}">
                            <span class="error" id="last_name-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sex" class="col-sm-4 control-label">Пол</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="sex" name="sex">
                                @if(!$user->sex)
                                    <option value="" selected disabled>Изберете</option>
                                @endif
                                <option value="мъж" @if($user->sex=='Мъж') selected @endif>Мъж</option>
                                <option value="жена" @if($user->sex=='Жена') selected @endif>Жена</option>
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
        var form = $("#form-edit-user");
        $.ajax({
            url: "{{ route('users.update', $user) }}",
            context: document.body,
            data: form.serialize(),
            method: 'post',
            success: function (data) {
                Lobibox.notify('success', {
                    showClass: 'rollIn',
                    hideClass: 'rollOut',
                    msg: JSON.parse(data).message
                });
                $('#myModal').modal('hide');
                table.ajax.reload(null, false);
            },
            error: function (data) {
                $('.error').html('');
                for (let i = 0; i < Object.keys(data.responseJSON.errors).length; i++) {
                    if (Object.keys(data.responseJSON.errors)[i] !== undefined) {
                        let key = Object.keys(data.responseJSON.errors)[i];
                        $('#' + key + '-error').html(data.responseJSON.errors[key]);
                    }
                }
                Lobibox.notify('error', {
                    showClass: 'rollIn',
                    hideClass: 'rollOut',
                    msg: 'Възникна някаква грешка при опита за промяна на данните на потребителя'
                });
            }
        })
    })

</script>
