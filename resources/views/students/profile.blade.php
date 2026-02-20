<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ================= THEME VARIABLES ================= */
:root{
    --bg-color:#f4f6f9;
    --text-color:#212529;
    --sidebar-bg:#1e1e2f;
    --card-bg:#ffffff;
    --primary:#0d6efd;
}

body.dark{
    --bg-color:#121212;
    --text-color:#f1f1f1;
    --sidebar-bg:#000000;
    --card-bg:#1e1e1e;
    --primary:#4e73df;
}

body{
    background:var(--bg-color);
    color:var(--text-color);
    font-family:'Poppins',sans-serif;
    transition:0.3s ease;
}

/* ================= SIDEBAR ================= */
.sidebar{
    width:260px;
    min-height:100vh;
    background:var(--sidebar-bg);
    color:white;
    position:fixed;
    padding:30px 20px;
}

.sidebar img{
    width:110px;
    height:110px;
    object-fit:cover;
    border-radius:50%;
    border:4px solid var(--primary);
}

.sidebar .nav-link{
    color:white;
    margin:10px 0;
    padding:10px;
    border-radius:8px;
    transition:0.3s;
}

.sidebar .nav-link:hover{
    background:linear-gradient(90deg,#4e73df,#1cc88a);
}

/* Active Menu */
.sidebar .active{
    background:linear-gradient(90deg,#4e73df,#1cc88a);
}

/* ================= MAIN ================= */
.main{
    margin-left:260px;
    padding:30px;
}

/* ================= TOPBAR ================= */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

/* ================= TOGGLE ================= */
.theme-toggle{
    display:flex;
    align-items:center;
    gap:10px;
}

.theme-toggle i{
    font-size:22px;
}

/* ================= CARD ================= */
.card{
    background:var(--card-bg);
    border:none;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    .sidebar{
        position:relative;
        width:100%;
    }
    .main{
        margin-left:0;
    }
}

</style>
</head>
<body>

<!-- ================= SIDEBAR ================= -->
<div class="sidebar text-center">

    @if($student->photo)
        <img src="{{ asset('students/'.$student->photo) }}">
    @else
        <img src="https://via.placeholder.com/150">
    @endif

    <h5 class="mt-3">{{ $student->name }}</h5>
    <p class="small text-light">Student Panel</p>

    <hr class="bg-light">

    <ul class="nav flex-column text-start">
        <li class="nav-item">
            <a href="{{ route('students.dashboard') }}" class="nav-link">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('student.profile') }}" class="nav-link active">
                <i class="bi bi-person me-2"></i> Profile
            </a>
        </li>
        <li class="nav-item">
            <a href="/students/logout" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>

</div>

<!-- ================= MAIN CONTENT ================= -->
<div class="main">

    <div class="topbar">
        <h3>My Profile 👤</h3>

        <!-- Dark / Light Toggle -->
        <div class="theme-toggle">
            <i class="bi bi-sun-fill text-warning"></i>

            <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" id="themeToggle">
            </div>

            <i class="bi bi-moon-fill text-info"></i>
        </div>
    </div>

    <!-- ================= PROFILE CARD ================= -->
    <div class="card p-5 text-center">

        @if($student->photo)
            <img src="{{ asset('students/'.$student->photo) }}"
                 class="rounded-circle mb-4"
                 width="150" height="150">
        @endif

        <h4 class="mb-4 text-primary">{{ $student->name }}</h4>

        <div class="row text-start">
            <div class="col-md-6 mb-3">
                <strong>Email:</strong>
                <p>{{ $student->email }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Phone:</strong>
                <p>{{ $student->phone }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <strong>Account Created:</strong>
                <p>{{ $student->created_at->format('d M Y') }}</p>
            </div>
        </div>

    </div>

</div>

<!-- ================= SCRIPTS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const toggle = document.getElementById("themeToggle");

// Load saved theme
if(localStorage.getItem("theme") === "dark"){
    document.body.classList.add("dark");
    toggle.checked = true;
}

toggle.addEventListener("change", function(){
    document.body.classList.toggle("dark");

    if(document.body.classList.contains("dark")){
        localStorage.setItem("theme","dark");
    } else {
        localStorage.setItem("theme","light");
    }
});
</script>

</body>
</html>
