  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-8">
                      <h1 class="m-0">
                          @yield('title')
                      </h1>
                  </div><!-- /.col -->
                  <div class="col-sm-4">
                      <ol class="breadcrumb float-sm-right">
                          @section('breadcrumb')
                          <li class="breadcrumb-item"><a href="/"><i class="nav-icon fa fa-house-chimney"></i> Dashboard</a></li>
                          @show
                      </ol>
                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      @yield('content')
      <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->