<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MySchool Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>

/* ================= THEME ================= */
:root{
    --bg-color:#f4f6f9;
    --text-color:#212529;
    --sidebar-bg:#1e1e2f;
    --card-bg:#ffffff;
    --header-bg:linear-gradient(135deg,#667eea,#764ba2);
}

body.dark{
    --bg-color:#121212;
    --text-color:#f1f1f1;
    --sidebar-bg:#000000;
    --card-bg:#1e1e1e;
    --header-bg:linear-gradient(135deg,#232526,#414345);
}

body{
    background:var(--bg-color);
    color:var(--text-color);
    font-family:'Segoe UI',sans-serif;
    transition:0.3s;
}

/* ================= SIDEBAR ================= */
.sidebar{
    background:var(--sidebar-bg);
    min-height:100vh;
    color:white;
    padding:25px;
    position:fixed;
    width:250px;
}

.sidebar img{
    width:100px;
    border-radius:50%;
    border:3px solid white;
}

.sidebar .nav-link{
    color:white;
    margin:10px 0;
    padding:10px;
    border-radius:8px;
    transition:0.3s;
}

.sidebar .nav-link:hover{
    background:linear-gradient(90deg,#ff512f,#dd2476);
}

/* ================= MAIN ================= */
.main-content{
    margin-left:250px;
}

.header{
    background:var(--header-bg);
    color:white;
    padding:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* ================= SLIDER ================= */
.carousel-item img{
    height:450px;
    object-fit:cover;
    border-radius:15px;
}

/* ================= EVENTS ================= */
.event-card{
    background:var(--card-bg);
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
    transition:0.4s;
}

.event-card img{
    height:230px;
    width:100%;
    object-fit:cover;
    transition:0.4s;
}

.event-card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 40px rgba(0,0,0,0.25);
}

.event-card:hover img{
    transform:scale(1.05);
}

.event-card h5{
    padding:15px;
    font-weight:600;
}

/* ================= PROFESSIONAL CONTACT ================= */
.contact-section{
    background:var(--card-bg);
    padding:70px 0;
}

.contact-box{
    background:white;
    padding:40px;
    border-radius:15px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

body.dark .contact-box{
    background:#1e1e1e;
}

.contact-box h3{
    margin-bottom:25px;
    font-weight:600;
}

.form-control{
    height:50px;
    border-radius:8px;
}

textarea.form-control{
    height:auto;
}

.contact-btn{
    height:50px;
    border-radius:8px;
    font-weight:600;
}

/* ================= FOOTER ================= */
.footer{
    background:var(--sidebar-bg);
    color:white;
    padding:30px;
    text-align:center;
}

.footer i{
    font-size:22px;
    margin:0 10px;
    cursor:pointer;
    transition:0.3s;
}

.footer i:hover{
    color:#ffc107;
}

/* ================= RESPONSIVE ================= */
@media(max-width:768px){
    .sidebar{
        position:relative;
        width:100%;
    }
    .main-content{
        margin-left:0;
    }
}

</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar text-center">
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png">
    <h4>MySchool</h4>
    <p>Rajkot</p>
    <hr>
    <ul class="nav flex-column text-start">
        <li class="nav-item"><a class="nav-link" href="#">Student</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Teacher</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Principal</a></li>
    </ul>
</div>

<div class="main-content">

    <!-- HEADER -->
    <div class="header">
        <h2>Welcome to MySchool</h2>
        <button class="btn btn-light" onclick="toggleTheme()">
            <i class="bi bi-moon-stars-fill"></i> Toggle Theme
        </button>
    </div>

    <!-- POPUP -->
    <div class="modal fade" id="courseModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
          <h4>Select Course</h4>
          <button class="btn btn-primary m-2">BCA</button>
          <button class="btn btn-success m-2">BBA</button>
          <button class="btn btn-warning m-2">B.Com</button>
          <button class="btn btn-info m-2">MCA</button>
          <button class="btn btn-danger m-2">MBA</button>
          <div class="text-end mt-4">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- SLIDER -->
    <div id="schoolCarousel" class="carousel slide container mt-5" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://images.pexels.com/photos/256541/pexels-photo-256541.jpeg">
        </div>
        <div class="carousel-item">
          <img src="https://images.pexels.com/photos/4145190/pexels-photo-4145190.jpeg">
        </div>
      </div>
    </div>

    <!-- FESTIVALS -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Indian Festivals & Events</h2>
        <div class="row g-4">

            <div class="col-md-4">
                <div class="event-card text-center">
                    <img src="https://images.pexels.com/photos/11687701/pexels-photo-11687701.jpeg">
                    <h5>Holi</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card text-center">
                    <img src="https://images.pexels.com/photos/786003/pexels-photo-786003.jpeg">
                    <h5>Diwali</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card text-center">
                    <img src="https://images.pexels.com/photos/1303086/pexels-photo-1303086.jpeg">
                    <h5>Christmas</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card text-center">
                    <img src="https://images.pexels.com/photos/236047/pexels-photo-236047.jpeg">
                    <h5>Kite Festival</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card text-center">
                    <img src="https://images.pexels.com/photos/1763075/pexels-photo-1763075.jpeg">
                    <h5>Ganesh Chaturthi</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="event-card text-center">
                    <img src="https://images.pexels.com/photos/1444442/pexels-photo-1444442.jpeg">
                    <h5>Navratri</h5>
                </div>
            </div>

        </div>
    </div>

    <!-- PROFESSIONAL CONTACT -->
    <section class="contact-section mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="contact-box">
                        <h3 class="text-center">Get In Touch</h3>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" placeholder="Full Name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="email" class="form-control" placeholder="Email Address">
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" placeholder="Your Message"></textarea>
                            </div>
                            <button class="btn btn-primary w-100 contact-btn">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <div class="footer">
        <h4>MySchool</h4>
        <p>Kothariya Chokdi, Rajkot - 360022</p>
        <div>
            <i class="bi bi-facebook"></i>
            <i class="bi bi-instagram"></i>
            <i class="bi bi-youtube"></i>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleTheme(){
    document.body.classList.toggle("dark");
}

window.onload = function(){
    var myModal = new bootstrap.Modal(document.getElementById('courseModal'));
    myModal.show();
}
</script>

</body>
</html>
