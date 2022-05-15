<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <div class="col-md-11">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </div>
    <div class="col-md-1">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu open">
                    <a href="#" class="" data-toggle="dropdown">
                        <img src="{{ asset('images/'.Auth::user()->foto) }}" class="user-image images-profile"
                            alt="User Image">
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('images/'.Auth::user()->foto) }}" class="img-circle images-profile"
                                alt="User Image">
    
                            <p>
                                <b>Username</b> : <i>{{ auth()->user()->username }}</i>
                                <br>
                                <b>Email</b> : <i>{{ auth()->user()->email }}</i>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="">
                                <a href="{{ route('user.profile') }}" class="btn btn-success btn-flat btn-sm"><i class="fa fa-pen-to-square"></i> Update Profile</a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="#" class="btn btn-danger btn-flat btn-sm"
                                    onclick="$('#logout-form').submit()"><i class="fa fa-arrow-right-from-bracket"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<form action="{{ route('logout') }}" method="post" id="logout-form" style="display:none;">
    @csrf
</form>
<!-- /.navbar -->