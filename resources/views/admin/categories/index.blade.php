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
                                <th>Псевдоним</th>
                                <th>Родителска категория</th>
                                <th>Действие</th>
                            </tr>
                            <tr class="filter">
                                <form id="form-filter">
                                    <th><input type="text" class="form-control form-filter" name="filter[title]"></th>
                                    <th><input type="text" class="form-control form-filter" name="filter[alias]"></th>
                                    <th><input type="text" class="form-control form-filter" name="filter[parent]"></th>
                                    <th>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="submit" name="clear" id="clear" class="btn btn-danger btn-secondary"
                                                    title="Изчисти филтъра">
                                                <i class="fa fa-times"></i>
                                            </button>
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
                                <th>Псевдоним</th>
                                <th>Родителска категория</th>
                                <th>Действие</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
                paging: false,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                processing: false,
                serverSide: false,
                orderCellsTop: true,
                order: [0, "asc"],
                columnDefs: [{
                    orderable: false,
                    targets: [3],
                }],
                data: {!! $data !!},
                columns: [
                    {data: 'title'},
                    {data: 'alias'},
                    {data: 'primary_category_title'},
                    {data: 'actions'},
                ],
            });
            $('#clear').click(function () {
                $('[name^="filter"]').val('');
                table
                    .search( '' )
                    .columns().search( '' )
                    .draw();
            });
            $('#categories thead tr:eq(1) th').each(function (i) {
                $('.form-filter', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });
        $('#title').on('input', function () {
            $('#alias').val($(this).val());
        })
        $(document).on('click', '.delete-category', function (e) {
            let target = $(e.target);
            if (target.is("i")) {
                target = target.parent();
            }

            Lobibox.confirm({
                msg: `Наистина ли искате да изтриете категорията: <strong>${target.data('title')}</strong>?`,
                callback: function ($this, type) {
                    if (type === 'yes') {
                        $.ajax({
                            url: `${target.data('route')}`,
                            method: 'delete',
                            success: function (data) {
                                Lobibox.notify('success', {
                                    msg: `Категорията <strong>${target.data('title')}</strong> беше успешно изтрита`
                                });
                                table.ajax.reload()
                            }
                        });
                    }
                }
            });

        });
    </script>
@endsection