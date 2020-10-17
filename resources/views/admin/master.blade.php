<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/master.css') }}">
    @yield('head')
</head>
<body>
<section id="admin">
    <div  class="shadow-sm sticky-top bg-dark mb-3">
        <div class="container">
            <div class="row">
                <b-navbar toggleable="lg" type="dark" variant="dark" class="col-12">
                    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
                    <b-collapse id="nav-collapse" is-nav>
                        <b-navbar-nav>

                            <b-nav-item class="{{ request()->is('admin/banner') ? 'active' : '' }}" href="{{ route('banner.index') }}"><b-icon icon="images" class="mr-2"></b-icon>Banner</b-nav-item>
                            <b-nav-item class="{{ request()->is('admin/cvmaker') ? 'active' : '' }}" href="{{ route('cvmaker.index') }}"><b-icon icon="file-earmark-text" class="mr-2"></b-icon>CV Comp.</b-nav-item>
                            <b-nav-item class="{{ request()->is('admin/blog') ? 'active' : '' }}" href="{{ route('blog.index') }}"><b-icon icon="broadcast" class="mr-2"></b-icon>Blog</b-nav-item>
                        </b-navbar-nav>

                        <!-- Right aligned nav items -->
                        <b-navbar-nav class="ml-auto">
                            <b-nav-form>

                            <b-nav-item-dropdown right>
                                <!-- Using 'button-content' slot -->
                                <template v-slot:button-content>
                                    <em>User</em>
                                </template>
                                <b-dropdown-item href="{{ route('user.index') }}">Profile</b-dropdown-item>
                                <li class="presentation">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </b-nav-item-dropdown>
                        </b-navbar-nav>
                    </b-collapse>
                </b-navbar>
{{--                <ul class="col-11 mb-0">--}}

{{--                    <li class="d-inline-block mx-2">--}}
{{--                        <a class="btn btn-primary {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.index') }}"><b-icon icon="laptop" class="mr-2"></b-icon>Home</a>--}}
{{--                    </li>--}}
{{--                    <li class="d-inline-block mx-2">--}}
{{--                        <a class="btn btn-primary {{ request()->is('admin/banner') ? 'active' : '' }} " href="{{ route('banner.index') }}"><b-icon icon="images" class="mr-2"></b-icon>Banner</a>--}}
{{--                    </li>--}}
{{--                    <li class="d-inline-block mx-2">--}}
{{--                        <a class="btn btn-primary {{ request()->is('admin/cvmaker') ? 'active' : '' }} " href="{{ route('cvmaker.index') }}"><b-icon icon="file-earmark-text" class="mr-2"></b-icon>CV</a>--}}
{{--                    </li>--}}
{{--                    <li class="d-inline-block mx-2">--}}
{{--                        <a class="btn btn-primary {{ request()->is('admin/blog') ? 'active' : '' }} " href="{{ route('blog.index') }}"><b-icon icon="broadcast--}}
{{--" class="mr-2"></b-icon>Blog</a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--                <div class="col-1">--}}
{{--                    <button class="btn btn-primary">Logout</button>--}}
{{--                </div>--}}
            </div>

        </div>
    </div>
    @yield('body')
</section>

<script src="{{ mix('js/admin.js') }}"></script>
@yield('js')
</body>
</html>
