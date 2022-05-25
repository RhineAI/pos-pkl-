@extends('layouts.main')

@section('title')
Data Semua Supplier
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Supplier</li>
@endsection

@section('content')


<div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
                @if(session()->has('alert'))
                    <div class="p-3 alert alert-success d-flex text-white" id="alert">{{ session()->get('alert') }}</div>
                @endif

                @if(session()->has('update'))
                    
                    <div class=" p-3 alert alert-success d-flex text-white" id="update"><i class="fas fa-circle-check"></i>{{ session()->get('update') }}
                    </div>
                    @push('script')
                        <script>
                            $('#alert').ready(
                               alert(
                                    Swal.fire({
                                        title: 'Sukses!',
                                        text: 'P',
                                        icon: 'success',
                                        confirmButtonText: 'Lanjut',
                                        confirmButtonColor: '#28A745'
                                    })
                               );
                            );
                        </script>
                        
                    @endpush
           
                    
                @endif

                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('supplier.store') }}')" class="btn btn-sm btn-flat btn-primary btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="6%">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Telepon</th>
                            <th width="13%" class="text-center">Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
</div>
@includeIf('supplier.form')
@includeIf('supplier.produk')
@endsection

@push('scripts')
    <script>
        var time = document.getElementById("alert");

            setTimeout(function(){
            time.style.display = "none";
        }, 2000);

        var time = document.getElementById("update");

            setTimeout(function(){
            time.style.display = "none";
        }, 2000);

        let table;

        $(function () {
            table = $('.table').DataTable({
                processing: true,
                responsive: true,
                autoWidth: false,
                serverSide: true,
                ajax: {
                    url: '{{ route('supplier.data') }}',
                },
                columns: [
                   {data:'DT_RowIndex', searchable: false, sortable: false},
                   {data:'nama'},
                   {data:'alamat'},
                   {data:'telepon'},
                   {data:'aksi', searchable: false, sortable: false},
                ]
            });

            $('#modal-form').validator().on('submit', function (e) {
                if (! e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            Swal.fire({
                                title: 'Sukses!',
                                text: response,
                                icon: 'success',
                                confirmButtonText: 'Lanjut',
                                confirmButtonColor: '#28A745'
                            })
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Supplier yang diinput sudah ada',
                                icon: 'error',
                                confirmButtonText: 'Kembali',
                                confirmButtonColor: '#DC3545'
                            })
                            table.ajax.reload();
            
                            return;
                        });
                }
            });
        }); 

        function addForm(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Tambah Supplier Baru');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }  
        
        
        function editData(url) {
            $('#modal-form').modal('show')
            $('#modal-form .modal-title').text('Edit Supplier');

            $('#modal-form form')[0].reset();
            $('#modal-form form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=nama]').val(response.nama);
                    $('#modal-form [name=alamat]').val(response.alamat);
                    $('#modal-form [name=telepon]').val(response.telepon);
                })
                .fail((errors) => {
                    alert('Gagal mengubah data!');
                    return;
                });
        }

        
        function deleteData(url) {
            Swal.fire({
                title: 'Hapus Supplier yang dipilih?',
                icon: 'question',
                iconColor: '#DC3545',
                showDenyButton: true,
                denyButtonColor: '#838383',
                denyButtonText: 'Batal',
                confirmButtonText: 'Hapus',
                confirmButtonColor: '#DC3545'
                }).then((result) => {
                if (result.isConfirmed ) {
                    $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Supplier berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        }).then(function() {
                            location.reload()
                        })
                    })
                    .fail((errors) => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Supplier gagal dihapus',
                            icon: 'error',
                            confirmButtonText: 'Kembali',
                            confirmButtonColor: '#DC3545'
                        })                       
                        return;
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Supplier batal dihapus',
                        icon: 'warning',
                    })
                }
            })

            // success: function (data) {
                // if (data == 'success')
                //     swal("Deleted!", "User has been deleted", "success");
                //     window.location('/supplier');
                // else
                //     swal("cancelled", "User has not been deleted", "error");
            // }

        }

     

        $(document).on('click', '#tambahProdukSupplier', function () {
            let id_supplier = $(this).data('id_supplier');
            $('#modal-produk').modal('show')

            $('#id_supplier').val(id_supplier)
        })

        let arrProduct = []

        $(document).on('click', '#id_produk', function () {
            let id_produk = $(this).val()

            if($(this).is(':checked')) {
                arrProduct.push(id_produk)
            } else {
                let index = arrProduct.indexOf(id_produk)
                if(index > -1) {
                    arrProduct.splice(index, 1)
                }
            }
        })

        $("#simpanProduct").on('submit', function (e) {
            e.preventDefault()

            let finalData = {
                id_produk: arrProduct,
                id_supplier: $("#id_supplier").val(),
                _token: "{{ csrf_token() }}"
            }

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: finalData,
                success:function (response) {
                    if(response.status == true) {
                        $('#modal-produk').modal('hide');
                        Swal.fire({
                            title: 'Sukses!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Lanjut',
                            confirmButtonColor: '#28A745'
                        })
                        table.ajax.reload();
                    }
                }
            })
        })

       
    </script>
@endpush
