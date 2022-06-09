<style>
    .clock {
        position: absolute;
        top: 50%;
        left: 10%;
        transform: translateX(-50%) translateY(-50%);
        color: #36120e;
        font-size: 20px;
        font-family: 'Times New Roman';
        letter-spacing: 3px;
    }
</style>

<!-- Navbar -->

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <div class="col-md-10">
        <ul class="navbar-nav">
            <li class="nav-item my-2">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

            <div class="col-md-12" >
                    
                <div id="MyClockDisplay" class="clock" onload="showTime()"></div>

            </div>

        </ul>
        
    </div>

    <div class="col-md-2">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
               
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu open">
                    <a href="#" class="" data-toggle="dropdown">
                        <img src="{{ asset('images/'.Auth::user()->foto) }}" class="user-image images-profile"
                            alt="User Image">
                    </a>
                    <span class="hidden-xs">{{ auth()->user()->username }}</span>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('images/'.Auth::user()->foto) }}" class="img-circle images-profile"
                                alt="User Image">
    
                            <p>
                                <b>Username</b> : {{ auth()->user()->username }}
                                <br>
                                <b>Email</b> : {{ auth()->user()->email }}
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
       function showTime(){
                var date = new Date();
                const days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

                var d = days[date.getDay()]; // 0 - 23
                var h = date.getHours(); // 0 - 23
                var m = date.getMinutes(); // 0 - 59
                var s = date.getSeconds(); // 0 - 59
                var session = "AM";
                
                if(h == 0){
                    h = 12;
                }
                
                if(h > 12){
                    h = h - 12;
                    session = "PM";
                }
                
                h = (h < 10) ? "0" + h : h;
                m = (m < 10) ? "0" + m : m;
                s = (s < 10) ? "0" + s : s;
                
                var time = d + " " + h + ":" + m + ":" + s + " " + session;
                document.getElementById("MyClockDisplay").innerText = time;
                document.getElementById("MyClockDisplay").textContent = time;
                
                setTimeout(showTime, 1000);
                
            }

            showTime();
    </script>
