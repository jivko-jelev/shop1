@extends('admin.layouts.master')

@section('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ URL::to('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="col-xs-12">
                        <table id="categories" class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr role="row" class="heading">
                                <th>Име</th>
                                <th>Категория</th>
                                <th>Създаден на</th>
                                <th>Действие</th>
                            </tr>
                            <tr class="filter">
                                <form id="form-filter" autocomplete="off">
                                    <th><input type="text" class="form-control form-filter" name="filter[name]"></th>
                                    <th><input type="text" class="form-control form-filter" name="filter[category]"></th>
                                    <th class="filter-date">
                                        <div class="form-group">
                                            <div class="filter-date-from">
                                                <input type="text" class="form-control form-filter" name="filter[created_at_from]"
                                                       id="datepicker-from" placeholder="От">
                                            </div>
                                            <div class="filter-date-to">
                                                <input type="text" class="form-control form-filter" name="filter[created_at_to]"
                                                       id="datepicker-to" placeholder="До">
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="submit" name="filter" id="filter" class="btn btn-primary btn-secondary"
                                                    title="Търси"><i
                                                    class="fa fa-search"></i></button>
                                            <button type="submit" name="clear" id="clear" class="btn btn-danger btn-secondary"
                                                    title="Изчисти филтъра"><i
                                                    class="fa fa-times"></i></button>
                                        </div>
                                    </th>
                                </form>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Име</th>
                                <th>Категория</th>
                                <th>Създаден на</th>
                                <th>Действие</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
    </div>
@endsection

@section('scripts')
    <!-- DataTables -->
    <script src="{{ URL::to('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        let table;
        $(function () {
            table = $('#categories').DataTable({
                paging: true,
                lengthChange: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Всички"]],
                searching: false,
                ordering: true,
                info: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                order: [0, "asc"],
                columnDefs: [{
                    orderable: false,
                    targets: [3],
                }],
                ajax: {
                    "url": '{{ route('products.ajax') }}',
                    "type": "POST",
                    data: function (d) {
                        d.name            = $('input[name="filter[name]"]').val();
                        d.category_id     = $('input[name="filter[category_id]"]').val();
                        d.created_at_from = $('input[name="filter[created_at_from]"]').val();
                        d.created_at_to   = $('input[name="filter[created_at_to]"]').val();
                    }
                },
                columns: [
                    {data: 'name'},
                    {data: 'category_id'},
                    {data: 'created_at'},
                    {data: 'actions'},
                ],
                "fnDrawCallback": function (oSettings) {
                    $('#parent_id').html('');
                    let categoriesData = table.rows().data().sort();
                    let o              = new Option("Без", '');
                    $(o).html('Без');
                    $('#parent_id').append(o);
                    for (let i = 0; i < categoriesData.length; i++) {
                        let o = new Option(`${categoriesData[i]['title']} (${categoriesData[i]['alias']})`, categoriesData[i]['id']);
                        $(o).html(`${categoriesData[i]['title']} (${categoriesData[i]['alias']})`);
                        $('#parent_id').append(o);
                    }

                    $('.delete-product').click(function () {
                        let product   = $(this).data('product');
                        let productId = $(this).data('productId');
                        Lobibox.confirm({
                            msg: `Наистина ли искате да изтриете: <strong>${product}</strong> ?`,
                            callback: function ($this, type) {
                                if (type === 'yes') {
                                    $.ajax({
                                        url: `/admin/products/${productId}`,
                                        method: 'delete',
                                        success: function (data) {
                                            Lobibox.notify('success', {
                                                msg: `Продуктът <strong>${product}</strong> беше успешно изтрит.`
                                            });
                                            table.ajax.reload()
                                        }
                                    });
                                }
                            }
                        });
                    });

                }
            });
            $('#filter').click(function () {
                table.ajax.reload(null, true);
            });
            $('.form-filter').keypress(function (e) {
                if (e.which == 13) {
                    table.ajax.reload(null, true);
                }
            });
            $('#clear').click(function () {
                $('[name^="filter"]').val('');
                table.ajax.reload(null, false);
            });

        });

        $('#datepicker-from').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
        });

        $('#datepicker-to').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
        })

        $('#title').on('input', function () {
            $('#alias').val($(this).val());
        })

        $(document).keyup(function (e) {
            if (e.key === "Escape") {
                $('#myModal').modal('hide');
            }
        });
    </script>
@endsection