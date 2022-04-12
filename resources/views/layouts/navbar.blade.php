<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <div class="pull-rigth">
        <a href="#" class="btn btn-default btn-flat" onclick="$('#logout-form').submit()">Logout</a>
    </div>
</nav>

<form action="{{ route('logout') }}" method="post" id="logout-form" style="display:none;">
    @csrf
</form>

<!-- /.navbar -->