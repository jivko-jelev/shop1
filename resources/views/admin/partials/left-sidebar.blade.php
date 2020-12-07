<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ URL::to('dist/img/user2-160x160.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li @if(request()->routeIs('dashboard')) class="active" @endif>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Табло</span>
                </a>
            </li>
            <li @if(request()->routeIs('categories.create')) class="active" @endif>
                <a href="{{ route('categories.create') }}">
                    <i class="fa fa-list"></i>
                    <span>Създай Категория</span>
                </a>
            </li>
            <li @if(request()->routeIs('categories')) class="active" @endif>
                <a href="{{ route('categories') }}">
                    <i class="fa fa-list"></i>
                    <span>Категории</span>
                </a>
            </li>
            <li @if(request()->routeIs('users')) class="active" @endif>
                <a href="{{ route('users') }}">
                    <i class="fa fa-users"></i>
                    <span>Потребители</span>
                </a>
            </li>
            <li @if(request()->routeIs('products.create')) class="active" @endif>
                <a href="{{ route('products.create') }}">
                    <i class="fa fa-product-hunt"></i>
                    <span>Създай Продукт</span>
                </a>
            </li>
            <li @if(request()->routeIs('products.index.admin')) class="active" @endif>
                <a href="{{ route('products.index.admin') }}">
                    <i class="fa fa-product-hunt"></i>
                    <span>Списък на продуктите</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
