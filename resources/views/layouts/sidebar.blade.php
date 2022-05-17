  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
          <i class="ml-3 mr-3 nav-icon fa fa-shop"></i>
          <span class="brand-text font-weight-light"><b>{{ config ('app.name') }}</b></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="/images/iqbal.jpeg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="{{ route('dashboard') }}" class="d-block">{{ auth()->user()->username }}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                  {{-- Dashboard --}}
                  <li class="nav-item">
                      <a href="{{ route('dashboard') }}" class="nav-link">
                          <i class="nav-icon fa fa-house-chimney"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>

                  <li class="nav-header">MAIN MENU</li>

                  {{-- Produk --}}
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-shopping-bag"></i>
                          <p>
                              Produk
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview ml-4">
                          <li class="nav-item">
                              <a href="{{ route('kategori.index') }}" class="nav-link">
                                  <p>Kategori Produk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('satuan.index') }}" class="nav-link">
                                  <p>Satuan Produk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('produk.index') }}" class="nav-link">
                                  <p>Data Produk</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  {{-- Stok --}}
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-box"></i>
                          <p>
                              Stok
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview ml-4">
                          <li class="nav-item">
                              <a href="{{ route('stokmasuk.index') }}" class="nav-link">
                                  <p>Stok Masuk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ route('stokkeluar.index') }}" class="nav-link">
                                  <p>Stok Keluar</p>
                              </a>
                          </li>
                      </ul>
                  </li>         

                  {{-- Transaksi --}}
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-shopping-cart"></i>
                          <p>
                              Transaksi
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview ml-4">
                          <li class="nav-item">
                              <a href="{{ route('pembelian.index') }}" class="nav-link">
                                  <p>Pembelian</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="" class="nav-link">
                                  <p>Penjualan</p>
                                  <i class="right fas fa-angle-left"></i>
                              </a>
                              <ul class="nav nav-treeview ml-4">
                                <li class="nav-item">
                                    <a href="{{ route('transaksi.baru') }}" class="nav-link">
                                        <p>Transaksi Baru</p>                 
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('transaksi.index') }}" class="nav-link">
                                        <p>Transaksi Aktif</p>
                                    </a>
                                </li>
                              </ul>
                          </li>
                          
                      </ul>
                  </li>

                  {{-- Daftar Penjualan --}}
                <li class="nav-item">
                    <a href="{{ route('daftarpenjualan.index') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-clipboard-list"></i>
                        <p>
                            Daftar Penjualan
                        </p>
                    </a>
                </li>

                  {{-- Supplier --}}
                <li class="nav-item">
                    <a href="{{ route('supplier.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-truck"></i>
                        <p>
                            Supplier
                        </p>
                    </a>
                </li>

                  {{-- Laporan --}}
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-chart-pie"></i>
                          <p>
                              Laporan
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview ml-4">
                          <li class="nav-item">
                              <a href="{{ route('reportpenjualan.index') }}" class="nav-link">
                                  <p>Laporan Penjualan</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  {{-- Users --}}
                  <li class="nav-item">
                      <a href="{{ route('users.index') }}" class="nav-link">
                          <i class="nav-icon fa fa-users"></i>
                          <p>
                              Pengguna
                          </p>
                      </a>
                  </li>

                  {{-- Settings --}}
                  <li class="nav-item">
                      <a href="{{ route('setting.index') }}" class="nav-link">
                          <i class="nav-icon fa fa-cog"></i>
                          <p>
                              Pengaturan
                          </p>
                      </a>
                  </li>

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>