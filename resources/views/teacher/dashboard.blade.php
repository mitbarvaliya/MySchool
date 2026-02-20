<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Teacher Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>

/* ====== GLOBAL ====== */
body{
    background:#f4f6f9;
    font-family:'Poppins',sans-serif;
}

.page-header{
    background:linear-gradient(90deg,#4e73df,#1cc88a);
    padding:20px 30px;
    border-radius:15px;
    color:white;
    margin-bottom:25px;
}

.page-header h2{
    margin:0;
    font-weight:600;
}

/* ====== CARD ====== */
.card-custom{
    background:white;
    border:none;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    padding:25px;
}

/* ====== BUTTONS ====== */
.btn-custom{
    border-radius:10px;
    padding:8px 18px;
    font-weight:500;
}

.btn-success{
    background:#1cc88a;
    border:none;
}

.btn-success:hover{
    background:#17a673;
}

.btn-primary{
    background:#4e73df;
    border:none;
}

.btn-primary:hover{
    background:#2e59d9;
}

.btn-danger{
    border:none;
}

/* ====== TABLE ====== */
.table thead{
    background:#4e73df;
    color:white;
}

.table{
    border-radius:12px;
    overflow:hidden;
}

.table td, .table th{
    vertical-align:middle;
}

/* ====== IMAGE STYLE ====== */
.student-img{
    width:50px;
    height:50px;
    object-fit:cover;
    border-radius:50%;
    border:2px solid #4e73df;
}

/* ====== MODAL ====== */
.modal-content{
    border-radius:15px;
    border:none;
}

.modal-header{
    background:#4e73df;
    color:white;
}

.modal-footer{
    border-top:none;
}

</style>
</head>
<body>

<div class="container mt-4">

    <!-- HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <h2>Welcome, {{ session('teacher_name') }} 👩‍🏫</h2>

        <button class="btn btn-light btn-custom"
                data-bs-toggle="modal"
                data-bs-target="#addStudentModal">
            <i class="bi bi-plus-circle"></i> Add Student
        </button>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- STUDENT TABLE CARD -->
    <div class="card-custom">

        <h4 class="mb-4"><i class="bi bi-people-fill"></i> Student Management</h4>

        @if($students->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th width="160">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>

                            <td>
                                @if($student->photo)
                                    <img src="{{ asset('students/'.$student->photo) }}"
                                         class="student-img">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>

                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone ?? '-' }}</td>

                            <td>
                                <button class="btn btn-sm btn-primary btn-custom"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $student->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('teacher.student.delete', $student->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger btn-custom"
                                            onclick="return confirm('Delete this student?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- UPDATE MODAL -->
                        <div class="modal fade" id="updateModal{{ $student->id }}" tabindex="-1">
                          <div class="modal-dialog">
                            <div class="modal-content">

                              <form action="{{ route('teacher.student.update', $student->id) }}"
                                    method="POST"
                                    enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                  <h5 class="modal-title">Update Student</h5>
                                  <button type="button" class="btn-close btn-close-white"
                                          data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                  <div class="mb-3 text-center">
                                    @if($student->photo)
                                        <img src="{{ asset('students/'.$student->photo) }}"
                                             class="student-img mb-2"
                                             style="width:80px;height:80px;">
                                    @endif
                                  </div>

                                  <div class="mb-3">
                                    <label>Name</label>
                                    <input type="text"
                                           class="form-control"
                                           name="name"
                                           value="{{ $student->name }}"
                                           required>
                                  </div>

                                  <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email"
                                           class="form-control"
                                           name="email"
                                           value="{{ $student->email }}"
                                           required>
                                  </div>

                                  <div class="mb-3">
                                    <label>Phone</label>
                                    <input type="text"
                                           class="form-control"
                                           name="phone"
                                           value="{{ $student->phone }}">
                                  </div>

                                  <div class="mb-3">
                                    <label>Change Image</label>
                                    <input type="file"
                                           class="form-control"
                                           name="photo">
                                  </div>

                                </div>

                                <div class="modal-footer">
                                  <button type="button"
                                          class="btn btn-secondary btn-custom"
                                          data-bs-dismiss="modal">
                                      Cancel
                                  </button>

                                  <button type="submit"
                                          class="btn btn-primary btn-custom">
                                      Update
                                  </button>
                                </div>

                              </form>

                            </div>
                          </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted">No students found.</p>
        @endif

    </div>

</div>
</body>
</html>
