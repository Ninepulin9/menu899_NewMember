@extends('admin.layout')
@section('style')
<style>
    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
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
            <div class="col-lg-12 col-md-12 order-1">
                <div class="row d-flex justify-content-center">
                    <div class="col-8">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{route('admin.usersSave')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3">
                                            {{ strtoupper(substr($info->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h5 class="mb-1">แก้ไขผู้ใช้</h5>
                                            <small class="text-muted">{{ $info->name }}</small>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.users') }}" class="btn btn-secondary btn-sm">
                                        <i class="bx bx-arrow-back"></i> กลับ
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">ชื่อ <span class="required">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" required value="{{ old('name', $info->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <label for="email" class="form-label">อีเมล <span class="required">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" required value="{{ old('email', $info->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <label for="tel" class="form-label">เบอร์ติดต่อ <span class="required">*</span></label>
                                            <input type="text" class="form-control @error('tel') is-invalid @enderror" 
                                                   id="tel" name="tel" onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
                                                   maxlength="10" required value="{{ old('tel', $info->tel) }}">
                                            @error('tel')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <label for="password" class="form-label">รหัสผ่าน</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                       id="password" name="password" placeholder="เว้นว่างหากไม่ต้องการเปลี่ยน">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <i class="bx bx-hide" id="eyeIcon"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">หากต้องการเปลี่ยนรหัสผ่าน กรุณากรอกรหัสผ่านใหม่</small>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-12">
                                            <label for="role" class="form-label">สิทธิ์ <span class="required">*</span></label>
                                            <select class="form-control @error('role') is-invalid @enderror" name="role" id="role" required>
                                                <option value="">-- เลือกสิทธิ์ --</option>
                                                <option value="owner" {{ ($info->role == 'owner') ? 'selected' : '' }}>เจ้าของ (Owner)</option>
                                                <option value="manager" {{ ($info->role == 'manager') ? 'selected' : '' }}>ผู้จัดการ (Manager)</option>
                                                <option value="cashier" {{ ($info->role == 'cashier') ? 'selected' : '' }}>แคชเชียร์ (Cashier)</option>
                                                <option value="staff" {{ ($info->role == 'staff') ? 'selected' : '' }}>พนักงาน (Staff)</option>
                                                <option value="admin" {{ ($info->role == 'admin') ? 'selected' : '' }}>ผู้ดูแลระบบ (Admin)</option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- ข้อมูลเพิ่มเติม -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-12">
                                            <div class="card bg-light">
                                                <div class="card-body py-3">
                                                    <h6 class="mb-2"><i class="bx bx-info-circle"></i> ข้อมูลเพิ่มเติม</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <small class="text-muted d-block">วันที่สร้าง:</small>
                                                            <span>{{ $info->created_at->format('d/m/Y H:i') }}</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <small class="text-muted d-block">อัพเดทล่าสุด:</small>
                                                            <span>{{ $info->updated_at->format('d/m/Y H:i') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                        <i class="bx bx-arrow-back"></i> ยกเลิก
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-save"></i> บันทึกการแก้ไข
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ old('id', $info->id) }}">
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
});
</script>
@endsection