@extends('admin.layout')
@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<style>
    .badge-role {
        font-size: 0.875em;
        padding: 0.375rem 0.75rem;
    }
    .role-owner { background-color: #dc3545; }
    .role-manager { background-color: #fd7e14; }
    .role-cashier { background-color: #198754; }
    .role-staff { background-color: #6f42c1; }
    .role-admin { background-color: #0d6efd; }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 col-md-12 order-1 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">จัดการผู้ใช้ในระบบ</h6>
                            <small class="text-muted">เฉพาะเจ้าของร้านเท่านั้นที่สามารถจัดการผู้ใช้ได้</small>
                        </div>
                        <a href="{{ route('admin.usersCreate') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> เพิ่มผู้ใช้ใหม่
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="usersTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ชื่อผู้ใช้</th>
                                        <th>อีเมล</th>
                                        <th>เบอร์โทร</th>
                                        <th>Role</th>
                                        <th class="text-center">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
var language = '{{asset("assets/js/datatable-language.js")}}';

$(document).ready(function() {
    $("#usersTable").DataTable({
        language: {
            url: language,
        },
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('admin.userslistData') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        },
        columns: [
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'tel',
                name: 'tel'
            },
            {
                data: 'role',
                name: 'role',
                render: function(data, type, row) {
                    var roleClass = 'role-' + data;
                    var roleName = '';
                    switch(data) {
                        case 'owner': roleName = 'เจ้าของ'; break;
                        case 'manager': roleName = 'ผู้จัดการ'; break;
                        case 'cashier': roleName = 'แคชเชียร์'; break;
                        case 'staff': roleName = 'พนักงาน'; break;
                        case 'admin': roleName = 'ผู้ดูแลระบบ'; break;
                        default: roleName = data;
                    }
                    return '<span class="badge badge-role ' + roleClass + '">' + roleName + '</span>';
                }
            },
            {
                data: 'action',
                name: 'action',
                class: 'text-center',
                orderable: false,
                searchable: false
            }
        ],
        order: [[0, 'asc']]
    });

    // ลบผู้ใช้
    $(document).on('click', '.deleteUser', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        Swal.fire({
            title: 'ยืนยันการลบ',
            text: "คุณต้องการลบผู้ใช้นี้ใช่หรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ตกลง    ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.usersDelete') }}",
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire(
                                'ลบแล้ว!',
                                response.message,
                                'success'
                            );
                            $('#usersTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire(
                                'เกิดข้อผิดพลาด!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'เกิดข้อผิดพลาด!',
                            'ไม่สามารถลบข้อมูลได้',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
@endsection