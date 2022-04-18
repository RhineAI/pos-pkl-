@extends('layouts.main')

@section('title')
Dashboard
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')


<div class="row mx-3" style="background-color: white">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="add('{{ route('satuan.store') }}')" class="btn btn-sm btn-flat btn-success btn-flat mx-2 my-3"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>

                {{-- @if (session()->has('success'))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <div>
                          <i class="bi bi-check-lg"  style="font-size: 1.2rem;"></i>
                           {{ session('success') }}
                        </div>
                      </div>
                @endif --}}

                <div class="box-body table-responsive">
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="8%">No</th>
                            <th>Satuan</th>
                            <th width="15%">Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
</div>
@includeIf('satuan.form')
@endsection

@push('scripts')
    <script>
        let table; 

        $(function () {
            table = $('.table').DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('satuan.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_satuan'},
                {data: 'act', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
                if (! e.preventDefault()) {
                    $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            alert(
                                Swal.fire({
                                title: 'Success',
                                text: 'Lanjut gak nih?',
                                icon: 'success',
                                confirmButtonText: 'Yoi'
                                })
                            );
                            table.ajax.reload();
                        })

                        .fail((errors) => {
                            alert(
                                Swal.fire({
                                title: 'Error!',
                                text: 'Te baleg',
                                icon: 'error',
                                confirmButtonText: 'meh'
                                })
                            );
                            table.ajax.reload();
            
                            return;
                        });
                }
        })
    });

    function add(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Satuan');
        
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_satuan]').focus();
    }

    function edit(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Satuan');
        
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_satuan]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_satuan]').val(response.nama_satuan);
                    table.ajax.reload();
                })

                .fail((errors) => {
                    alert(
                        Swal.fire({
                        title: 'Error!',
                        text: 'Te baleg',
                        icon: 'error',
                        confirmButtonText: 'meh'
                        })
                    );
                    table.ajax.reload();
            
                    return;
                });
        }

        function deleteData(url) {
            if(confirm('Yakin gk bang?')) {
                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                    .done((response) => {
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('huu');
                        table.ajax.reload();

                        return;
                    });
            }
        }

    
    </script>
@endpush