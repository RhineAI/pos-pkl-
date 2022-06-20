@extends('layouts.main')

@section('title')
Daftar Pembelian
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Daftar Pembelian</li>
@endsection

@if(session()->has('failed'))
<div class="alert alert-danger text-white" id="alert"><i class="fa fa-circle-check"></i>
    &nbsp; {{ session()->get('alert') }}
</div>
@endif

@section('content')
<div class="row mx-3">
    <div class="col-md-12 p-3 mb-3" style="background-color: white">
        <div class="box">
            
            <div class="box-header with-border">
                <button onclick="addForm()" class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i> Tambah Transaksi</button>

                @empty(! session('id_pembelian'))
                    <a href="{{ route('pembelian_detail.index') }}" class="btn btn-flat btn-info btn-sm mx-2 my-3"><i class="fa fa-pencil"></i> Transaksi Aktif</a>
                @endempty
                    
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped table-bordered table-pembelian">
                    <thead>
                        <th width="6%">No</th>
                        <th class="text-center">Tanggal</th>
                        <th width="12%" class="text-center">Invoice</th>
                        <th width="20%" class="text-center">Nama Supplier</th>
                        <th class="text-center">Total Item</th>
                        <th class="text-center">Total Harga</th>
                        <th class="text-center">Diskon</th>
                        <th class="text-center">Total Bayar</th>
                        <th width="8%" class="text-center">Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')
@includeIf('pembelian.return')
@endsection

@push('scripts')
<script>
    let table, table1, table2;

    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-pembelian').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pembelian.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'kode_pembelian'},
                {data: 'supplier'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('.table-supplier').DataTable();

        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            info: false,
            paginate: false,
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'barcode'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},  
                {data: 'subtotal'},
            ]
        })

        table2 = $('.table-return').DataTable({
            processing: true,
            bSort: false,
            info: false,
            paginate: false,
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'barcode'},
                {data: 'nama_produk'},
                {data: 'harga_beli'},
                {data: 'jumlah'},
                {data: 'jumlah2'},
                {data: 'subtotal'},
                {data: 'aksi'},
            ]
        })
    });

    $(document).on('click', '#returnBarang', function(e) {
        e.preventDefault()
        let row = $(this).closest('tr')

        let id = $(this).data('id')
        let jumlah = parseInt(row.find('td:eq(4)').text())
        let retur = parseInt(row.find('td:eq(5)').find('input').val())

        $.ajax({
            method: 'PATCH',
            url: $(this).data('route'),
            data: {
                id_pembelian_detail: id,
                jumlah: retur,
                _token: "{{ csrf_token() }}",
            },
            cache: false,
            dataType: 'json',
            success:function(response) {
                console.log(response)
                if(response.status == true) {
                    Swal.fire({
                        title: 'Produk berhasil di retur!',
                        icon: 'success',
                        confirmButtonText: 'Onghey!',
                    }).then(function () {
                        $('#returnBarang').modal('hide');
                        
                        table.ajax.reload();
                    })
                }
            }
        })
    })

    $(document).on('keyup change', '#jumlah', function (e) {
        let row = $(this).closest('tr')

        let jumlah = parseInt(row.find('td:eq(4)').text())
        let jumlahBaru = $(this).val()

        if(jumlahBaru > jumlah ) {
            Swal.fire({
                title: 'Jumlah retur melebih batas!',
                icon: 'info',
                confirmButtonText: 'Lanjut',
            }) 
            $(this).val(jumlah)
        }else if(jumlahBaru<0) {
            Swal.fire({
                title: 'Tentukan Jumlah retur!',
                icon: 'info',
                confirmButtonText: 'Lanjut',
            })
            $(this).val(0)
        }
        // if(jumlah <0) {
        //     Swal.fire({
        //         title: 'Jumlah retur melebih batas!',
        //         icon: 'info',
        //         confirmButtonText: 'Lanjut',
        //     })
        //     $(this).val(jumlah)
        // }

    })

    function addForm() {
        $('#modal-supplier').modal('show');
    }

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }

    function returnBarang(url) {
        $('#modal-return').modal('show');
        $('#modal-return .modal-title').text('Return Barang')

        table2.ajax.url(url);
        table2.ajax.reload();

    }

    $(document).on('click', '#return', function () {
        let id_pembelian = $(this).data('id_pembelian');
      
    })


    function deleteData(url) {
            Swal.fire({
                title: 'Hapus Data Pembelian  yang dipilih?',
                icon: 'question',
                iconColor: '#DC3545',
                showDenyButton: true,
                denyButtonColor: '#838383',
                denyButtonText: 'Batal',
                confirmButtonText: 'Hapus',
                confirmButtonColor: '#DC3545'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data Pembelian berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }) 
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Salah satu stok Produk habis, tidak bisa dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Data Pembelian batal dihapus',
                        icon: 'warning',
                    })
                }
            })
        }
</script>
@endpush