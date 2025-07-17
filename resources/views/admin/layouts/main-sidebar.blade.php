<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('assets/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('assets/img/brand/logo-white.png') }}" class="main-logo dark-theme"
                alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . ($page = 'index')) }}"><img
                src="{{ URL::asset('assets/img/brand/favicon-white.png') }}" class="logo-icon dark-theme"
                alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround" src="{{ auth()->user()->img_path }}"><span
                        class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ auth()->user()->name }}</h4>
                    <span class="mb-0 text-muted">{{ Auth::user()->roles->pluck('name')[0] }}</span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category">{{ trans('dashboard.main') }}</li>


            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.dashboard') }}">
                    <i class="side-menu__icon fe fe-home"></i>
                    &nbsp;&nbsp;<span class="side-menu__label">{{ trans('dashboard.dashboard') }}</span></a>
            </li>



            <li class="side-item side-item-category">{{ trans('dashboard.users') }}</li>

            @canany(['view_user', 'add_user', 'edit_user', 'delete_user', 'active_user', 'restore_user'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}">
                        <i class="side-menu__icon fe fe-users"></i>
                        &nbsp;&nbsp;<span class="side-menu__label">{{ trans('user.users') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('view_user')
                            <li><a class="slide-item"
                                    href="{{ route('admin.users.index') }}">{{ trans('user.show_users') }}</a>
                            </li>
                        @endcan
                        @can('add_user')
                            <li><a class="slide-item"
                                    href="{{ route('admin.users.create') }}">{{ trans('user.add_new_user') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany



            <li class="side-item side-item-category">{{ trans('dashboard.admin') }}</li>

            @canany(['view_admin', 'add_admin', 'edit_admin', 'delete_admin', 'active_admin', 'restore_admin'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}">
                        <i class="side-menu__icon fas fa-user-shield"></i>
                        &nbsp;&nbsp;<span class="side-menu__label">{{ trans('admin.admins') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('view_admin')
                            <li><a class="slide-item"
                                    href="{{ route('admin.admins.index') }}">{{ trans('admin.show_admins') }}</a>
                            </li>
                        @endcan
                        @can('add_admin')
                            <li><a class="slide-item"
                                    href="{{ route('admin.admins.create') }}">{{ trans('admin.add_new_admin') }}</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['view_role', 'add_role', 'edit_role', 'delete_role', 'active_role', 'restore_role'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}">
                        <i class="side-menu__icon fas fa-user-tag"></i>
                        &nbsp;&nbsp;<span class="side-menu__label">{{ trans('roles.roles') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('view_role')
                            <li><a class="slide-item"
                                    href="{{ route('admin.roles.index') }}">{{ trans('roles.show_roles') }}</a>
                            </li>
                        @endcan
                        @can('add_role')
                            <li><a class="slide-item"
                                    href="{{ route('admin.roles.create') }}">{{ trans('roles.add_new_role') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany


            <li class="side-item side-item-category">{{ trans('dashboard.categories_and_brands') }}</li>

            @canany(['view_category', 'add_category', 'edit_category', 'delete_category', 'active_category',
                'restore_category', 'add_home_category'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . ($page = '#')) }}">
                        <i class="side-menu__icon fe fe-grid"></i>
                        &nbsp;&nbsp;<span class="side-menu__label">{{ trans('category.categories') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('view_category')
                            <li><a class="slide-item"
                                    href="{{ route('admin.categories.index') }}">{{ trans('category.show_categories') }}</a>
                            </li>
                        @endcan
                        @can('add_category')
                            <li><a class="slide-item"
                                    href="{{ route('admin.categories.create') }}">{{ trans('category.add_new_category') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <li class="side-item side-item-category">{{ trans('dashboard.product_settings') }}</li>

            @canany(['view_tax', 'add_tax', 'edit_tax', 'delete_tax', 'active_tax', 'restore_tax'])
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.taxes.index') }}">
                        <i class="side-menu__icon fa fa-receipt"></i>
                        &nbsp;&nbsp;<span class="side-menu__label">{{ trans('tax.taxes') }}</span></a>
                </li>
            @endcanany



            <li class="side-item side-item-category">{{ trans('dashboard.activity_logs') }}</li>

            @can('view_activity_log')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.activity_logs') }}">
                        <i class="side-menu__icon fa fa-history"></i>&nbsp;&nbsp;<span
                            class="side-menu__label">{{ trans('dashboard.activity_logs') }}</span></a>
                </li>
            @endcan

        </ul>
    </div>
</aside>
<!-- main-sidebar -->
