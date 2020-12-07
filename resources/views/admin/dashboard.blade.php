@extends('admin.layouts.master')

@section('content')
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ $numUsers }}</h3>

                <p>Потребители</p>
            </div>
            <div class="icon">
                <i class="ion ion-person"></i>
            </div>
            <a href="{{ route('users') }}" class="small-box-footer">Повече <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $numUsersRegisteredToday }}</h3>

                <p>Регистрирани днес</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('users') }}" class="small-box-footer">Повече <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ \App\Product::all()->count() }}</h3>

                <p>Продукти</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-box"></i>
            </div>
            <a href="{{ route('products.index.admin') }}" class="small-box-footer">Повече <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
@endsection
