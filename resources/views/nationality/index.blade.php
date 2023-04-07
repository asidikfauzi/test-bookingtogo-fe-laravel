@extends('layouts.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Nationalities</h1>
    <a href="{{route('createNationality')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i>
        Nationality
    </a>
</div>
<p class="mb-4">
    Nationality is a legal identification of a person in
    international law, establishing the person as a subject, a national,
    of a sovereign state. It affords the state jurisdiction over the person
    and affords the person the protection of the state against other states.
</p>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Nationality</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="table-nationality" class="table table-bordered table-nationality" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nationality Name</th>
                        <th>Nationality Code</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.3/dist/sweetalert2.min.css">




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<script type="text/javascript">
    $(document).ready(function(){
        fetch_data();

        function fetch_data()
        {
            $('.table-nationality').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sEmptyTable:   'Tidak ada data yang tersedia pada tabel ini',
                    sProcessing:   'Sedang memproses...',
                    sZeroRecords:  'Tidak ditemukan data yang sesuai',
                    sInfo:         'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                    sInfoEmpty:    'Menampilkan 0 sampai 0 dari 0 entri',
                    sInfoFiltered: '(disaring dari _MAX_ entri keseluruhan)',
                    sInfoPostFix:  '',
                    sSearch:       '',
                    sUrl:          '',
                    oPaginate: {
                    sFirst:    'Pertama',
                    sPrevious: 'Sebelumnya',
                    sNext:     'Selanjutnya',
                    sLast:     'Terakhir'
                    }
                },
                paging: true,
                responsive: true,
                // scrollY:"50%",
                scrollX: true,
                filter : true,
                lengthChange: false,
                scrollCollapse: true,
                fixedColumns:   {
                    heightMatch: 'none'
                },
                ajax: {
                    url:"{{ route('getDataNationalities') }}",
                },
                columns:[
                        {data: 'id',
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {data: 'nationality_name', name: 'nationality_name'},
                        {data: 'nationality_code', name: 'nationality_code'},
                        {data: 'edit', name: 'edit'},
                        {data: 'delete', name: 'delete'},
                ]
            });
        }
        $("body").on("click", ".modal-deletetab1", function() {
            var id = $(this).attr('data-id');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: "Yakin?",
                text: "kamu akan menghapus data ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Menggunakan metode DELETE dalam permintaan HTTP
                    $.ajax({
                        url:  "{{ route('deleteNationality', ['id' => ':id']) }}".replace(':id', id),
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            Swal.fire(
                                "Data berhasil dihapus",
                                "",
                                "success"
                            );
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                        error: function() {
                            Swal.fire(
                                "Terjadi kesalahan",
                                "Gagal menghapus data",
                                "error"
                            );
                        }
                    });
                } else {
                    Swal.fire(
                        "Data Tidak Jadi dihapus",
                        "",
                        "error"
                    );
                }
            });
        });

    });

</script>
