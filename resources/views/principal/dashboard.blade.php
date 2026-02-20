<!DOCTYPE html>
<html>
<head>
    <title>Principal Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ===== GLOBAL ===== */
body{
    background:#f4f6f9;
    font-family:'Poppins', sans-serif;
}

/* ===== HEADER ===== */
.dashboard-header{
    background:linear-gradient(90deg,#4e73df,#1cc88a);
    padding:20px 30px;
    border-radius:15px;
    color:white;
    margin-bottom:30px;
}

.dashboard-header img{
    border:3px solid white;
}

/* ===== CARDS ===== */
.card-custom{
    border:none;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    overflow:hidden;
}

.card-header-custom{
    font-weight:600;
    padding:15px 20px;
    color:white;
}

/* ===== TABLE ===== */
.table th{
    font-weight:600;
}

.table td, .table th{
    vertical-align:middle;
}

.table thead{
    background:#4e73df;
    color:white;
}

/* ===== IMAGES ===== */
.profile-img{
    width:50px;
    height:50px;
    object-fit:cover;
    border-radius:50%;
    border:2px solid #4e73df;
}

/* ===== BUTTONS ===== */
.btn-success{
    background:#1cc88a;
    border:none;
}

.btn-success:hover{
    background:#17a673;
}

.btn-danger{
    border:none;
}

.btn-sm{
    border-radius:8px;
}

/* ===== SECTION SPACING ===== */
.section-title{
    font-size:20px;
    font-weight:600;
}

</style>
</head>

<body>

<div class="container-fluid mt-4">

    <!-- ================= HEADER ================= -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center gap-3">

            @if($principal && $principal->photo)
                <img src="{{ asset('principals/'.$principal->photo) }}"
                     width="65"
                     height="65"
                     class="rounded-circle"
                     style="object-fit: cover;">
            @else
                <img src="https://via.placeholder.com/65"
                     class="rounded-circle">
            @endif

            <div>
                <h3 class="mb-0">Welcome, {{ session('principal_name') }} 👑</h3>
                <small>Principal Control Panel</small>
            </div>
        </div>

        <form action="{{ route('principal.logout') }}" method="POST">
            @csrf
            <button class="btn btn-light btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>

    </div>


    <!-- ================= STUDENTS SECTION ================= -->
    <div class="card card-custom mb-5">

        <div class="card-header card-header-custom bg-primary">
            <i class="bi bi-people-fill"></i> All Students
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="220">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($students as $student)
                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        @if($student->photo)
                            <img src="{{ asset('students/'.$student->photo) }}"
                                 class="profile-img">
                        @else
                            <img src="https://via.placeholder.com/50"
                                 class="profile-img">
                        @endif
                    </td>

                    <!-- UPDATE FORM -->
                    <form method="POST"
                          action="{{ route('principal.student.update', $student->id) }}">
                        @csrf
                        @method('PUT')

                        <td>
                            <input type="text"
                                   name="name"
                                   value="{{ $student->name }}"
                                   class="form-control">
                        </td>

                        <td>
                            <input type="email"
                                   name="email"
                                   value="{{ $student->email }}"
                                   class="form-control">
                        </td>

                        <td class="d-flex gap-2">

                            <button class="btn btn-success btn-sm">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                    </form>

                    <!-- DELETE FORM -->
                    <form method="POST"
                          action="{{ route('principal.student.delete', $student->id) }}">
                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('Delete this student?')"
                                class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>

                        </td>
                </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>


    <!-- ================= TEACHERS SECTION ================= -->
    <div class="card card-custom">

        <div class="card-header card-header-custom bg-dark">
            <i class="bi bi-person-badge-fill"></i> All Teachers
        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="220">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($teachers as $teacher)
                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        @if($teacher->photo)
                            <img src="{{ asset('teachers/'.$teacher->photo) }}"
                                 class="profile-img">
                        @else
                            <img src="https://via.placeholder.com/50"
                                 class="profile-img">
                        @endif
                    </td>

                    <!-- UPDATE FORM -->
                    <form method="POST"
                          action="{{ route('principal.teacher.update', $teacher->id) }}">
                        @csrf
                        @method('PUT')

                        <td>
                            <input type="text"
                                   name="name"
                                   value="{{ $teacher->name }}"
                                   class="form-control">
                        </td>

                        <td>
                            <input type="email"
                                   name="email"
                                   value="{{ $teacher->email }}"
                                   class="form-control">
                        </td>

                        <td class="d-flex gap-2">

                            <button class="btn btn-success btn-sm">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                    </form>

                    <!-- DELETE FORM -->
                    <form method="POST"
                          action="{{ route('principal.teacher.delete', $teacher->id) }}">
                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('Delete this teacher?')"
                                class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>

                        </td>
                </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>
