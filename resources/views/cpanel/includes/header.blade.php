<header id="page-header">
    <div class="content-header">
        <div id=""></div>
        <div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual dropdown-toggle" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-server"></i>
                    <span class="d-none d-sm-inline ml-1">Server: {{ $serverName }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg p-0 hide" aria-labelledby="page-header-user-dropdown" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-105px, 38px, 0px);" x-placement="bottom-end">
                    <div class="rounded-top font-w600 text-center bg-body-light p-3">
                        <div class="mb-1">
                            <i class="fa fa-users text-black-75 mr-1"></i> {{ $online }}
                        </div>
                        <span class="badge badge-success d-inline-block mb-3">
                            <i class="fa fa-spinner fa-spin mr-1"></i> Running
                        </span>
                        <div class="row gutters-tiny">
                            <div class="col-6">
                                <button type="button" class="btn btn-sm btn-alt-danger btn-block">
                                    <i class="fa fa-stop mr-1"></i> Stop
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-sm btn-alt-warning btn-block">
                                    <i class="fa fa-redo mr-1"></i> Restart
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item" href="javascript:void(0)">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-w600">
                                    Server: {{ $serverName }}
                                </span>
                                <i class="fa fa-fw fa-server ml-1"></i>
                            </div>
                            <div class="font-size-sm">
                                <i class="fa fa-circle text-success mr-1"></i> {{ $ip }}
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block">{{ Auth::user()->name }}</span>
                    <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                    <div class="bg-primary rounded-top font-w600 text-white text-center p-3">
                        Cá nhân
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item" href="{{ route('cpanel.profile') }}">
                            <i class="far fa-fw fa-user mr-1"></i> {{ __('index.profile') }}
                        </a>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                            <a class="dropdown-item" href="javascript:void(0)" onclick="document.getElementById('logout-form').submit()">
                                <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> {{ __('index.logout') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual" id="page-header-language-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-language"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-language-dropdown">
                    @php
                    $language = session('language-admin');
                    @endphp
                    <div class="bg-primary rounded-top font-w600 text-white text-center p-3">
                        <img src="{{ asset('assets/images/flags/' . $language . '.png') }}" style="width: 20px; height: 20px;" class="me-2">
                        {{ __('index.' . $language) }}
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item" href="{{ route('cpanel.change-language', ['lang' => 'en']) }}">
                            <img src="{{ asset('assets/images/flags/en.png') }}" style="width: 20px; height: 20px;" class="me-2"> {{ __('index.english') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('cpanel.change-language', ['lang' => 'vi']) }}">
                            <img src="{{ asset('assets/images/flags/vi.png') }}" style="width: 20px; height: 20px;" class="me-2"> {{ __('index.vietnamese') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('cpanel.change-language', ['lang' => 'ja']) }}">
                            <img src="{{ asset('assets/images/flags/ja.png') }}" style="width: 20px; height: 20px;" class="me-2"> {{ __('index.japanese') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('cpanel.change-language', ['lang' => 'ko']) }}">
                            <img src="{{ asset('assets/images/flags/ko.png') }}" style="width: 20px; height: 20px;" class="me-2"> {{ __('index.korean') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('cpanel.change-language', ['lang' => 'th']) }}">
                            <img src="{{ asset('assets/images/flags/th.png?v=1') }}" style="width: 20px; height: 20px;" class="me-2"> {{ __('index.thai') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('cpanel.change-language', ['lang' => 'zh']) }}">
                            <img src="{{ asset('assets/images/flags/zh.png') }}" style="width: 20px; height: 20px;" class="me-2"> {{ __('index.chinese') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('cpanel.change-language', ['lang' => 'id']) }}">
                            <img src="{{ asset('assets/images/flags/id.png') }}" style="width: 20px; height: 20px;" class="me-2"> {{ __('index.indonesia') }}
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="page-header-loader" class="overlay-header bg-header-dark">
        <div class="bg-white-10">
            <div class="content-header">
                <div class="w-100 text-center">
                    <i class="fa fa-fw fa-sun fa-spin text-white"></i>
                </div>
            </div>
        </div>
    </div>
</header>