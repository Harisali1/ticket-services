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
padding:20px 50px;
background:#06111a;
}

.logo{
font-size:24px;
font-weight:bold;
color:var(--gold);
}

.nav a{
margin-left:25px;
text-decoration:none;
color:#fff;
}

.nav a:hover{
color:var(--gold);
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

.btn{
background:var(--gold);
color:#000;
padding:14px 28px;
border-radius:30px;
margin-top:20px;
font-weight:bold;
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
background:#06111a;
text-align:center;
padding:40px;
margin-top:60px;
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
<div class="logo">Divine Travel</div>
<nav class="nav">
<a href="#">Home</a>
<a href="#">Flights</a>
<a href="#">Contact</a>
</nav>
</header>

<section class="hero">
<img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e">
<div class="hero-overlay">
<h1 class="text-5xl font-bold">Professional <span style="color:#c9a55c">B2B Airline Solutions</span></h1>
<p class="mt-5 max-w-2xl">Instant ticketing, negotiated fares and powerful travel agency tools.</p>
<div class="btn">Start Booking</div>
</div>
</section>

<section class="section">
<h2 class="text-3xl mb-8">Popular Airline Deals</h2>

<div class="cards">

<div class="card">
<img src="https://via.placeholder.com/400x200">
<h3>Italy → Senegal</h3>
<p class="text-gray-400">Special B2B Fare</p>
</div>

<div class="card">
<img src="https://via.placeholder.com/400x200">
<h3>Dakar → Makkah</h3>
<p class="text-gray-400">Group Booking Available</p>
</div>

<div class="card">
<img src="https://via.placeholder.com/400x200">
<h3>Business Class Deals</h3>
<p class="text-gray-400">Exclusive Contracts</p>
</div>

</div>
</section>

<section class="section why">

<div>
<h2 class="text-3xl mb-4">Why Choose Divine Travel</h2>
<p class="text-gray-300">
Advanced B2B airline booking platform designed for travel agencies,
offering negotiated fares, real-time ticketing and dedicated support.
</p>
</div>

<div class="stats">
<div class="stat"><h2 class="text-2xl text-yellow-400">100+</h2><p>Agents</p></div>
<div class="stat"><h2 class="text-2xl text-yellow-400">30+</h2><p>Years Experience</p></div>
<div class="stat"><h2 class="text-2xl text-yellow-400">60K+</h2><p>Bookings</p></div>
<div class="stat"><h2 class="text-2xl text-yellow-400">24/7</h2><p>Support</p></div>
</div>

</section>

<section class="section">
<h2 class="text-3xl mb-8 text-center">Get In Touch</h2>

<div class="contact">

<img src="https://pngimg.com/uploads/traveler/traveler_PNG10.png">

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
<p>© 2026 Divine Travel — Professional B2B Airline Portal</p>
</footer>

</body>
</html>
