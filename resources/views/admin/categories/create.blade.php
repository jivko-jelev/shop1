@extends('admin.layouts.master')

@section('styles')
@endsection

@section('content')
    <div class="row" id="category-data">
        @include('admin.categories.partials.edit-content')
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.delete-property', function () {
            let that = $(this);
            if (that.data('saved') == 1) {
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
            if (that.data('saved') == 1) {
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
                if (that.closest('.property').find('input').length > 2) {
                    that.closest('.form-group').remove();
                }
            }
        });

        function grabSubmitButton() {
            $('#submit').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ $route }}',
                    method: '{{ $method }}',
                    data: $('#form-category').serialize(),
                    success: function (data) {
                        showSuccessMessage(data.message);
                        $('#category-data').html(data.content);
                        grabSubmitButton();
                    },
                    error: function (data) {
                        showErrors(data);
                    }
                });
            });
        }

        grabSubmitButton();

        let newSubProperty = 0;
        let newProperty    = 0;

        $(document).on('click', '.add-property-subproperty', function () {
            let index = $(this).closest('.property').data('index')
            let that  = $(this);
            newSubProperty++;
            $.ajax({
                url: '{{ route('categories.add-sub-property') }}',
                success: function (data) {

                    data = data.split('{new sub property}').join(newSubProperty);
                    data = data.split('{index}').join(index);
                    $(that).closest('.property').append(data);
                },
            });
        });

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
    </script>
@endsection