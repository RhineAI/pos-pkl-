<style>
    .time {
        font-style: italic;
        font-size: 90px;
    }
</style>

<!-- Navbar -->

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <div class="col-md-11">
        <ul class="navbar-nav">
            <li class="nav-item mt-2">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

            <div class="col-md-5 mx-6" >
                <div class="wrapper">
                    
                    <div class="display mt-3"> 
                        <div id="time" style="font-size: 21px; font-style: bold; font-family: century;"></div>
                    </div>
                </div>
               </div>

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
    <script>
        setInterval(() => {
            const weekday = ["Minggu","Senin","Selasa","Rabu","Kamis","Juma't","Sabtu"];
            const eachmonths = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            const time = document.querySelector('#time');
            let date = new Date();
            let year = date.getFullYear();
            let month = eachmonths[date.getMonth()];
            let day = weekday[date.getDay()];
            let hours = date.getHours();
            let minutes = date.getMinutes();
            let seconds = date.getSeconds();
            
            time.textContent = day + ":" + hours + ":" + minutes + ":" + seconds;
        });
    </script>
