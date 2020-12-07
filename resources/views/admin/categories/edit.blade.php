@extends('admin.layouts.master')

@section('content')
    <div class="row" id="category-data">
        @include('admin.categories.partials.edit-content')
    </div>
@endsection

@section('scripts')
    <script>
        let newSubProperty = 0;
        let newProperty    = 0;

        $(document).on('click', '.add-property', function () {
            $.ajax({
                url: '{{ route('categories.add-property') }}',
                success: function (data) {
                    newProperty++;
                    newSubProperty++
                    data = data.split('{new property}').join(newProperty);
                    $('#form-category').find('.modal-footer').last().before(data);
                },
            });
        });

        $(document).on('click', '.add-subproperty, .add-property-subproperty', function () {
            let index = $(this).closest('.property').data('index');
            let that  = $(this);
            $.ajax({
                url: '{{ route('categories.add-sub-property') }}',
                success: function (data) {
                    newSubProperty++;

                    data = data.split('{new sub property}').join(newSubProperty);
                    data = data.split('{index}').join(index);
                    $(that).closest('.property').append(data);
                },
            });
        });

        $(document).on('click', '.delete-property', function () {
            let that = $(this);
            if (that.data('route')) {
                Lobibox.confirm({
                    msg: `Наистина ли искате да изтриете атрибута: <strong>${$(this).data('title')}</strong>?`,
                    callback: function ($this, type) {
                        if (type === 'yes') {
                            $.ajax({
                                url: `${that.data('route')}`,
                                method: 'delete',
                                success: function (data) {
                                    that.closest('.property').remove();
                                    Lobibox.notify('success', {
                                        msg: `Атрибутът <strong>${that.data('title')}</strong> беше успешно изтрит`
                                    });
                                }
                            });
                        }
                    }
                });
            } else {
                that.closest('.property').remove();
            }
        });

        $(document).on('click', '.delete-subproperty', function () {
            let that = $(this);
            if (that.data('route')) {
                Lobibox.confirm({
                    msg: `Наистина ли искате да изтриете податрибута: <strong>${that.data('title')}</strong>?`,
                    callback: function ($this, type) {
                        if (type === 'yes') {
                            $.ajax({
                                url: `${that.data('route')}`,
                                method: 'delete',
                                success: function (data) {
                                    let parent = that.closest('.property');
                                    that.closest('.form-group').remove();
                                    let count = 0;
                                    parent.find('label').each(function () {
                                        if (count++ > 0) {
                                            $(this).html(`Податрибут #${count - 1}`);
                                        }

                                    });
                                    Lobibox.notify('success', {
                                        msg: `Податрибутът <strong>${that.data('title')}</strong> беше успешно изтрит`
                                    });
                                },
                                error: function (data) {
                                    showError(data);
                                }
                            });
                        }
                    }
                });
            } else {
                console.log(that.closest('.property').find('.subproperty').length );
                if (that.closest('.property').find('.subproperty').length > 1) {
                    that.closest('.form-group').remove();
                }
            }
        });

        function grabSubmitButton() {
            $('#submit').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('categories.update', $category->id) }}',
                    method: 'put',
                    data: $('#form-category').serialize(),
                    success: function (data) {
                        showSuccessMessage(data.message);
                        $('#category-data').html(data.content);
                        grabSubmitButton();
                    },
                    error: function (data) {
                        console.log(data);
                        showErrors(data);
                    }
                });
            });
        }

        grabSubmitButton();
    </script>
@endsection
