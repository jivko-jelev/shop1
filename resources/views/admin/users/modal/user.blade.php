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

                        <div class="col-sm-8 error-div">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Потребителско Име"
                                   value="{{ $user->name }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">Имейл</label>

                        <div class="col-sm-8 error-div">
                            <input type="text" class="form-control" name="email" id="email" placeholder="Имейл"
                                   value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-4 control-label">Парола</label>

                        <div class="col-sm-8 error-div">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Парола">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="col-sm-4 control-label">Повтори
                            Паролата</label>

                        <div class="col-sm-8 error-div">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Повтори Паролата">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="col-sm-4 control-label">Име</label>

                        <div class="col-sm-8 error-div">
                            <input type="text" class="form-control" name="first_name" placeholder="Име"
                                   value="{{ $user->first_name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-sm-4 control-label">Фамилия</label>

                        <div class="col-sm-8 error-div">
                            <input type="text" class="form-control" name="last_name" placeholder="Фамилия"
                                   value="{{ $user->last_name }}">
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
                showSuccessMessage(data.message)
                $('#myModal').modal('hide');
                $('.content').html(data.html);
            },
            error: function (data) {
                showErrors(data);
            }
        })
    })

</script>
