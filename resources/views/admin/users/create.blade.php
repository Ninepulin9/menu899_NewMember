@extends('admin.layout')
@section('style')
<style>
    .form-label {
        font-weight: 600;
        color: #566a7f;
    }
    .card-header {
        border-bottom: 1px solid rgba(75, 70, 92, 0.1);
    }
    .required {
        color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">เพิ่มผู้ใช้ใหม่</h5>
                                <small class="text-muted">กรอกข้อมูลผู้ใช้ที่ต้องการเพิ่มเข้าสู่ระบบ</small>
                            </div>
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back"></i> กลับ
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.usersSave') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">ชื่อผู้ใช้ <span class="required">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">อีเมล <span class="required">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tel" class="form-label">เบอร์โทรศัพท์ <span class="required">*</span></label>
                                    <input type="tel" class="form-control @error('tel') is-invalid @enderror" 
                                           id="tel" name="tel" value="{{ old('tel') }}" required>
                                    @error('tel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label">บทบาท <span class="required">*</span></label>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="">-- เลือกบทบาท --</option>
                                        <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>เจ้าของ (Owner)</option>
                                        <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>ผู้จัดการ (Manager)</option>
                                        <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>แคชเชียร์ (Cashier)</option>
                                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>พนักงาน (Staff)</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>ผู้ดูแลระบบ (Admin)</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">รหัสผ่าน <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bx bx-hide" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">ยืนยันรหัสผ่าน <span class="required">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" 
                                           name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <h6><i class="bx bx-info-circle"></i> ข้อมูลสิทธิ์การใช้งาน</h6>
                                        <ul class="mb-0">
                                            <li><strong>เจ้าของ (Owner):</strong> ใช้งานได้ทุกฟีเจอร์ รวมถึงการตั้งค่าระบบและจัดการผู้ใช้</li>
                                            <li><strong>ผู้จัดการ (Manager):</strong> จัดการข้อมูลพื้นฐาน เมนู สต็อก รายจ่าย</li>
                                            <li><strong>แคชเชียร์ (Cashier):</strong> จัดการออร์เดอร์และการชำระเงิน</li>
                                            <li><strong>พนักงาน (Staff):</strong> ดูและอัพเดทสถานะออร์เดอร์</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <a href="{{ route('admin.users') }}" class="btn btn-secondary me-2">ยกเลิก</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save"></i> บันทึกข้อมูล
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').click(function() {
        const password = $('#password');
        const eyeIcon = $('#eyeIcon');
        
        if (password.attr('type') === 'password') {
            password.attr('type', 'text');
            eyeIcon.removeClass('bx-hide').addClass('bx-show');
        } else {
            password.attr('type', 'password');
            eyeIcon.removeClass('bx-show').addClass('bx-hide');
        }
    });

    // Password confirmation validation
    $('#password_confirmation').on('keyup', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();
        
        if (confirmPassword !== password) {
            $(this).removeClass('is-valid').addClass('is-invalid');
        } else if (confirmPassword.length > 0) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });

    // Form validation
    $('form').on('submit', function(e) {
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();
        
        if (password !== confirmPassword) {
            e.preventDefault();
            $('#password_confirmation').addClass('is-invalid');
            alert('รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน');
        }
        
        if (password.length < 8) {
            e.preventDefault();
            $('#password').addClass('is-invalid');
            alert('รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร');
        }
    });
});
</script>
@endsection