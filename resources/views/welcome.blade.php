<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Divine Travel B2B Portal</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>

body{
font-family:Segoe UI, sans-serif;
background:#081520;
color:#fff;
}

:root{
--gold:#c9a55c;
--card:#0f2533;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:10px 30px;
    background:#9b7e43;
}

.logo{
    font-size:24px;
    font-weight:bold;
    color:var(--gold);
    display:flex;
    align-items:center;
    gap:10px;
}

.logo-heading{
    color:white;
}

.nav{
    display:flex;
    align-items:center;
    gap:20px;
}

.nav a{
    text-decoration:none;
    color:#fff;
    font-weight:500;
}


.btn{
    padding:8px 18px;
    border-radius:25px;
    font-size:14px;
    font-weight:600;
    transition:0.3s;
    background:var(--gold);
}

/* Sign In */
.btn-outline{
    border:2px solid #ffffffff;
    color:#6c63ff;
}

.btn-outline:hover{
    color:#000000;
}

/* HERO */
.hero{
height:620px;
position:relative;
}

.hero img{
width:100%;
height:100%;
object-fit:cover;
}

.hero-overlay{
position:absolute;
inset:0;
background:rgba(0,0,0,.65);
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
text-align:center;
padding:20px;
}



/* SECTION */
.section{
max-width:1200px;
margin:auto;
padding:80px 20px;
}

/* CARDS */
.cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
gap:30px;
}

.card{
background:var(--card);
padding:20px;
border-radius:15px;
transition:.3s;
}

.card:hover{
transform:translateY(-8px);
}

.card img{
border-radius:10px;
margin-bottom:15px;
}

/* WHY */
.why{
    background-color: #c9a55c;
}

.why-choose-grid{
    padding:5%;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:40px;
    align-items:center;
}
.stats{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:20px;
}

.stat{
background:var(--card);
padding:30px;
border-radius:12px;
text-align:center;
}

/* CONTACT */
.contact{
max-width:1200px;
margin:auto;
display:grid;
grid-template-columns:1fr 1fr;
background:#0f2533;
border-radius:20px;
overflow:hidden;
}

.contact img{
width:100%;
height:100%;
object-fit:cover;
}

.contact-form{
padding:50px;
}

.contact-form input,
.contact-form textarea{
width:100%;
padding:12px;
margin-bottom:15px;
border:none;
border-radius:6px;
background:#081520;
color:#fff;
}

/* FOOTER */
.footer{
    background:#0f172a;
    color:#fff;
    padding:25px 20px 15px;
    font-size:14px;
}

.footer-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    flex-wrap:wrap;
    gap:15px;
}

.footer-left,
.footer-center,
.footer-right{
    display:flex;
    flex-direction:column;
    gap:5px;
}

.footer-center{
    text-align:center;
}

.footer-bottom{
    text-align:center;
    margin-top:15px;
    padding-top:10px;
    border-top:1px solid #334155;
    color:#94a3b8;
}

/* mobile responsive */
@media(max-width:768px){
    .footer-top{
        flex-direction:column;
        text-align:center;
        align-items:center;
    }
}



/* RESPONSIVE */
@media(max-width:900px){

.why{
grid-template-columns:1fr;
}

.contact{
grid-template-columns:1fr;
}

.hero h1{
font-size:28px;
}

.header{
flex-direction:column;
gap:10px;
}

}

</style>
</head>

<body>

<header class="header">
<div class="logo">
    <img src="{{ asset('images/logo.jpg') }}" height="80" width="80">
    <span class="logo-heading">Divine Travel</span>
</div>
<nav class="nav">
    <a href="#">Home</a>
    <a href="#">Flights</a>
    <a href="#">Contact</a>

    <div class="auth-buttons">
        <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
        <a href="{{ route('register') }}" class="btn btn-outline">Sign Up</a>
    </div>
</nav>

</header>

<section class="hero">
<img src="{{ asset('images/home/slider.jpg') }}">
<div class="hero-overlay">
<h1 class="text-5xl font-bold">Professional <span style="color:#c9a55c">B2B Airline Solutions</span></h1>
<p class="mt-5 max-w-2xl">Instant ticketing, negotiated fares and powerful travel agency tools.</p>
<div class="btn mt-4">Start Booking</div>
</div>
</section>

<section class="section">
<h2 class="text-3xl mb-8">Popular Airline Deals</h2>

<div class="cards">

<div class="card">
<img src="{{ asset('images/home/italy-rome.jpg') }}">
<h3>Italy → Senegal</h3>
<p class="text-gray-400">Special B2B Fare</p>
</div>

<div class="card">
<img src="{{ asset('images/home/makkah.jpg') }}">
<h3>Dakar → Makkah</h3>
<p class="text-gray-400">Group Booking Available</p>
</div>

<div class="card">
<img src="{{ asset('images/home/image.jpg') }}">
<h3>Business Class Deals</h3>
<p class="text-gray-400">Exclusive Contracts</p>
</div>

</div>
</section>

<section class="why">
    <div class="why-choose-grid">
        <div>
            <h2 class="text-3xl mb-4">Why Choose Divine Travel</h2>
            <p class="text-gray-300">
            Advanced B2B airline booking platform designed for travel agencies,
            offering negotiated fares, real-time ticketing and dedicated support.
            </p>
        </div>

        <div class="stats">
            <div class="stat"><h2 class="text-2xl text-yellow-400">100+</h2><p>Agents</p></div>
            <div class="stat"><h2 class="text-2xl text-yellow-400">7+</h2><p>Years Experience</p></div>
            <div class="stat"><h2 class="text-2xl text-yellow-400">10K+</h2><p>Bookings</p></div>
            <div class="stat"><h2 class="text-2xl text-yellow-400">24/7</h2><p>Support</p></div>
        </div>
    </div>
</section>

<section class="section">
<h2 class="text-3xl mb-8 text-center">Get In Touch</h2>

<div class="contact">

<img src="{{ asset('images/home/get-in-touch.jpg') }}">

<div class="contact-form">
<input placeholder="Full Name">
<input placeholder="Email Address">
<input placeholder="Subject">
<textarea rows="4" placeholder="Message"></textarea>
<div class="btn">Send Message</div>
</div>

</div>
</section>

<footer class="footer">
    <div class="footer-top">

        <!-- LEFT -->
        <div class="footer-left">
            <p>📞 0039 3533713515</p>
            <p>☎️ 0039 0571522542</p>
        </div>

        <!-- CENTER ADDRESS -->
        <div class="footer-center">
            <p>📍 Corso Giuseppe Mazzini, 71</p>
            <p>56029 Santa Croce sull'Arno PI, Italy</p>
        </div>

        <!-- RIGHT -->
        <div class="footer-right">
            <p>📧 booking@divinetravel.it</p>
            <p>👤 Khan Atta Muhammad</p>
        </div>

    </div>

    <div class="footer-bottom">
        © 2026 Divine Travel — Professional B2B Airline Portal
    </div>
</footer>




</body>
</html>
