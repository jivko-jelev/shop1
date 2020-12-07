@extends('admin.layouts.master')

@section('styles')
@endsection

@section('content')
    <div class="row">
        <form action="" class="form-horizontal" id="create-product" autocomplete="off">
            <div class="col-md-10">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ $title }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Име</label>

                                <div class="col-sm-10 error-div">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Име"
                                               value="{{ isset($product) ? $product->name : '' }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default">Запази</button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category" class="col-sm-2 control-label">Категория</label>

                                <div class="col-sm-3 error-div">
                                    <select class="form-control select2" id="category" name="category">
                                        <option value="">избери</option>
                                        @foreach($categories as $category)
                                            <option
                                                    value="{{ $category->id }}"{{ isset($product) && $category->id==$product->category_id ? ' selected' : '' }}>{{ $category->title }}
                                                ({{ $category->alias }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <label for="price" class="col-md-1 control-label">Цена</label>

                                <div class="col-md-2 error-div">
                                    <div class="input-group">
                                        <input type="number" step=".01" class="form-control" name="price" id="price"
                                               placeholder="Цена"
                                               value="{{ isset($product) ? $product->price : '' }}">
                                    </div>
                                </div>

                                <label for="promo_price" class="col-md-2 control-label">Промо цена</label>
                                <div class="col-md-2 error-div">
                                    <div class="input-group">
                                        <input type="number" step=".01" class="form-control" name="promo_price" id="promo_price"
                                               placeholder="Промо цена" value="{{ $product->promo_price ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category" class="col-sm-2 control-label">Тип</label>

                                <div class="col-sm-3 error-div">
                                    <select class="form-control" name="type" id="type">
                                        @foreach(\App\Functions::getEnumValues('products', 'type') as $type)
                                            <option
                                                    value="{{ $type }}"{{ isset($product) && $type==$product->type ? ' selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12 error-div">
                                    <textarea name="description"
                                              id="description">{{ isset($product) && $product->description ? $product->description : '' }}</textarea>
                                </div>
                            </div>

                            <div id="properties">
                                @isset($product)
                                    @include('admin.products.layouts.properties')
                                @endisset
                                <hr>
                            </div>
                            <div class="col-md-4 my-col-md-4">
                                <div class="box my-box" id="variations">
                                    <div class="box-header">
                                        <h3 class="box-title">Вариация</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        @if(isset($product) && $product->type=='Вариация')
                                            @include('admin.products.layouts.variations')
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @isset($product)
                <div class="col-md-2">
                    <a href="{{ route('product.show', $product->permalink) }}" class="btn btn-primary btn-block"
                       target="_blank">
                        Преглед
                    </a>
                </div>
            @endisset
            <div class="col-md-2">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Снимка</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button type="button" class="btn btn-default btn-block" id="select-picture-button" data-toggle="modal"
                                data-target="#select-picture-modal">
                            Избери снимка
                        </button>
                        <a href="#" id="remove-product-picture">Премахни снимката</a>
                        <p id="product-picture" class="img-responsive">
                            @if(isset($product) && isset($product->picture_id))
                                <img src="{{ $product->getThumbnail() }}">
                            @endif
                        </p>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Галерия</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button type="button" class="btn btn-default btn-block" id="select-pictures-button" data-toggle="modal"
                                data-target="#select-pictures-modal">
                            Избери снимки
                        </button>
                        <a href="#" id="remove-product-pictures">Премахни снимките</a>
                        <p id="product-pictures" class="product-pictures">
                            @if(isset($product))
                                @foreach($product->pictures as $picture)
                                    <img src="{{ URL::to($picture->thumbnails->where('size', 1)->first()->filename) }}">
                                @endforeach
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <p type="hidden" id="picture-id" name="picture_id">
                @if(isset($product) && $product->picture_id)
                    <input type="hidden" name="picture_id[]" value="{{ $product->picture_id }}">
                @endif
            </p>
            <p type="hidden" id="pictures-id" name="pictures_id">
                @if(isset($product) && isset($product->pictures))
                    @foreach($product->pictures as $pictures)
                        <input type="hidden" name="pictures_id[]" value="{{ $pictures->id }}">
                    @endforeach
                @endif
            </p>
        </form>
        <!-- Modal -->
        <div class="modal fade center" id="myModal" role="dialog">
        </div>

        <div class="modal fade" id="select-picture-modal" role="dialog">
            <div class="modal-dialog modal-xl">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Снимки</h4>
                    </div>
                    <div class="modal-body">
                        <select id="picture-selectable">
                        </select>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('pictures.store') }}" method="post" enctype="multipart/form-data"
                              class="product-picture-form">
                            <input type="file" name="picture[]" multiple="multiple" class="btn btn-success pull-left"
                                   id="product-picture-pictures">
                            <input type="submit" value="Upload Image" name="submit" class="btn btn-success pull-left">
                        </form>
                        <span class="pull-left pictures-num"></span>
                        <a class="btn btn-default" data-dismiss="modal">Затвори</a>
                        <button type="button" name="save" class="btn btn-primary pull-right">Запази</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="select-pictures-modal" role="dialog">
            <div class="modal-dialog modal-xl">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Снимки</h4>
                    </div>
                    <div class="modal-body">
                        <select id="pictures-selectable" multiple="multiple">
                        </select>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('pictures.store') }}" method="post" enctype="multipart/form-data"
                              class="product-picture-form">
                            <input type="file" name="picture[]" multiple="multiple" class="btn btn-success pull-left"
                                   id="product-pictures-pictures">
                            <input type="submit" value="Upload Image" name="submit" class="btn btn-success pull-left">
                        </form>
                        <span class="pull-left pictures-num"></span>
                        <a class="btn btn-default" data-dismiss="modal">Затвори</a>
                        <button type="button" name="save" class="btn btn-primary pull-right">Запази</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script type="text/javascript">
        var editor_config = {
            path_absolute: "{{ URL::to('/') }}/",
            selector: "#description",
            height: 300,
            fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern codesample"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic underline | fontselect | fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code",
            relative_urls: false,
            file_browser_callback: function (field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no"
                });
            }
        };

        tinyMCE.init(editor_config);


        $('#create-product').submit(function (e) {
            e.preventDefault();
            $("textarea[name=description]").val(tinyMCE.activeEditor.getContent());
            let form = $(this);
            $.ajax({
                url: "{{ $route }}",
                data: form.serialize(),
                method: "{{ $method }}",
                success: function (data) {
                    $('error').remove();
                    if (data['url']) {
                        window.location.replace(data['url']);
                    } else {
                        showSuccessMessage(data.message);
                    }
                },
                error: function (data) {
                    showErrors(data);
                }
            });
        });

        function productPicture(element) {
            let reloadPictures = function () {
                let map = [];
                pictureId.find('input').each(function () {
                    map.push($(this).val());
                });
                $.ajax({
                    method: 'post',
                    data: {picture: map},
                    dataType: 'json',
                    url: '{{ route('thumbnails.index') }}',
                    success: function (data) {
                        $(selectable).html('');
                        $(pictureModal).on('hidden.bs.modal', function () {
                            $(selectable).html('');
                            $('.product-picture-form').off();
                        });
                        $(selectable).append('<option></option>');
                        $('.pictures-num').html(`Снимки: ${data.length}`);
                        for (let i = 0; i < data.length; i++) {
                            let isSelected = '';
                            $(productPicture).find('img').each(function () {
                                if ($(this).attr('src') == '{{ URL::to('') }}/' + data[i].filename) {
                                    isSelected = 'selected';
                                    return;
                                }
                            });
                            let label = data[i].filename.substring(data[i].filename.lastIndexOf('/'));
                            label     = label.substring(0, label.lastIndexOf('-'));
                            label     = label.substring(1, 18);
                            $(selectable).append('<option data-img-src="{{ URL::to('') }}/' + `${data[i].filename}" value="${data[i].picture_id}" data-img-label="${label}" ${isSelected}></option>`);
                        }

                        $(selectable).imagepicker({
                            show_label: true,
                        });
                    },
                });
            };
            let initModal      = function () {
                majorButton.click(function (e) {
                    reloadPictures();
                    pictureModal.find('button[name="save"]').click(function (e) {
                        pictureModal.modal('hide');
                        if (selectable.val()) {
                            productPicture.html('');
                            pictureId.html('');
                            selectable.find('option:selected').each(function () {
                                productPicture.append(`<img src="${$(this).data('img-src')}">`);
                                pictureId.append(`<input type="hidden" name="${pictureId.attr('name')}[]" value="${$(this).val()}">`);
                            });
                        } else {
                            productPicture.html('');
                        }
                    });

                    pictureModal.find('.product-picture-form').submit(function (e) {
                        e.preventDefault();
                        $('#loading').show();
                        let form_data = new FormData();
                        let ins       = document.getElementById(picture.attr('id')).files.length;
                        for (let x = 0; x < ins; x++) {
                            form_data.append('picture[]', document.getElementById(picture.attr('id')).files[x]);
                        }
                        $.ajax({
                            url: '{{ route('pictures.store') }}',
                            method: 'post',
                            data: form_data,
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                reloadPictures();
                                showSuccessMessage('Снимките бяха качени успешно!');
                                $('#loading').hide();
                                let picturesNum = selectable.find('option').length - 1;
                                $('.pictures-num').html(`Снимки: ${picturesNum}`);
                            },
                            error: function (data) {
                                $('#loading').hide();
                                showError(data);
                            },
                        })
                    });
                });
            }

            let majorButton    = $(`#select-${element}-button`);
            let selectable     = $(`#${element}-selectable`);
            let pictureModal   = $(`#select-${element}-modal`);
            let productPicture = $(`#product-${element}`);
            let pictureId      = $(`#${element}-id`);
            let picture        = $(`#product-${element}-pictures`);
            $(`#remove-product-${element}`).click(function () {
                productPicture.html('');
                pictureId.html('');
            });

            initModal();
        };

        let picture        = productPicture('picture');
        let productGallery = productPicture('pictures');

        $('#category').change(function () {
            let val = $(this).val();
            $.ajax({
                url: `/admin/categories/${val}/properties`,
                method: 'get',
                success: function (data) {
                    $('#properties').html(data);
                },
                error: function (data) {
                }
            });
        });
        let variations    = $('#variations');
        let numVariations = 0;

        function addSubVariation() {
            return '<div class="error-div"><div class="input-group">\n' +
                `       <input type="text" class="form-control" name="new_subvariation[${numVariations++}]" placeholder="Стойност" value="">\n` +
                '       <span class="input-group-btn">\n' +
                '            <button type="button" class="btn btn-primary add-subvariation" title="Добави податрибут">\n' +
                '                  <i class="fa fa-plus" aria-hidden="true"></i>\n' +
                '            </button>\n' +
                '            <button type="button" class="btn btn-danger delete-subvariation" title="Изтрий">\n' +
                '                  <i class="fa fa-minus" aria-hidden="true"></i>\n' +
                '            </button>\n' +
                '       </span>\n' +
                '</div></div>\n';
        }

        $('[name="type"]').change(function () {
            if ($(this).val() == 'Вариация') {
                variations.find('.box-body').html(
                    `<div class="error-div"><input type="text" class="form-control" name="variation" placeholder="Вариация"></div>\n` +
                    addSubVariation());
                variations.show();
            } else if ($(this).val() == 'Обикновен') {
                variations.hide();
            }
        });

        $(document).on('click', '.add-subvariation', function () {
            variations.find('.box-body').append(
                addSubVariation());
        });

        $(document).on('click', '.delete-subvariation', function () {
            if (variations.find('.error-div').length > 2) {
                if ($(this).data('route')) {
                    let that = $(this);
                    Lobibox.confirm({
                        msg: `Наистина ли искате да изтриете податрибута: <strong>${that.data('title')}</strong>?`,
                        callback: function ($this, type) {
                            if (type === 'yes') {
                                $.ajax({
                                    url: `${that.data('route')}`,
                                    method: 'delete',
                                    success: function (data) {
                                        that.closest('.error-div').remove();
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
                    $(this).closest('.error-div').remove();
                }
            }
        });
    </script>
@endsection