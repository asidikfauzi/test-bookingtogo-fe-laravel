@extends('layouts.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Family Lists</h1>
    <a href="{{route('createFamilyList')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="bi bi-plus-lg"></i>
        Family Lists
    </a>
</div>
<p class="mb-4">
    This is an index of family trees available on the English Wikipedia.
    It includes noble, politically important, and royal families as well
    as fictional families and thematic diagrams. This list is organized
    according to alphabetical order.
</p>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Family Lists</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="table-family-list" class="table table-bordered table-family-list" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Customer Name</th>
                        <th>Relation</th>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>View</th>
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
<!-- Contoh Modal -->
<div class="modal fade" id="yourModal" tabindex="-1" role="dialog" aria-labelledby="yourModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="yourModalLabel">Detail Family</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <p>FL ID: <span id="fl_id"></span></p>
            <p>CST ID: <span id="cst_id"></span></p>
            <p>FL Relation: <span id="fl_relation"></span></p>
            <p>FL Name: <span id="fl_name"></span></p>
            <p>FL DOB: <span id="fl_dob"></span></p>
            <p>Customers:</p>
            <ul>
                <li>CST ID: <span id="cst_id_inner"></span></li>
                <li>Nationality ID: <span id="nationality_id"></span></li>
                <li>CST Name: <span id="cst_name"></span></li>
                <li>CST DOB: <span id="cst_dob"></span></li>
                <li>CST Phone Number: <span id="cst_phone_num"></span></li>
                <li>CST Email: <span id="cst_email"></span></li>
                <li>Nationality:</li>
                <ul>
                <li>Nationality ID: <span id="nationality_id_inner"></span></li>
                <li>Nationality Name: <span id="nationality_name"></span></li>
                <li>Nationality Code: <span id="nationality_code"></span></li>
                </ul>
            </ul>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


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

    function showModal(data) {
        $('#fl_id').text(data.fl_id);
        $('#cst_id').text(data.cst_id);
        $('#fl_relation').text(data.fl_relation);
        $('#fl_name').text(data.fl_name);
        $('#fl_dob').text(data.fl_dob);
        // Menampilkan modal
        $('#yourModal').modal('show');
    }
    $(document).ready(function(){


        fetch_data();

        function fetch_data()
        {
            $('.table-family-list').DataTable({
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
                    url:"{{ route('getDataFamilyList') }}",
                },
                columns:[
                        {data: 'id',
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {data: 'cst_name', name: 'cst_name'},
                        {data: 'fl_relation', name: 'fl_relation'},
                        {data: 'fl_name', name: 'fl_name'},
                        {data: 'fl_dob', name:'fl_dob'},
                        {data: 'view', name: 'view'},
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
                    $.ajax({
                        url:  "{{ route('deleteFamilyList', ['id' => ':id']) }}".replace(':id', id),
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
