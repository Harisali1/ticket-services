<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divine Travel - B2B Airline Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-50">

<!-- Header -->
<header class="bg-white shadow-md fixed w-full z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center space-x-4">
            <img src="https://via.placeholder.com/150x50?text=Divine+Travel" alt="Logo" class="h-10">
            <nav class="hidden md:flex space-x-6">
                <a href="#" class="text-gray-700 hover:text-purple-600 font-medium">Home</a>
                <a href="#" class="text-gray-700 hover:text-purple-600 font-medium">Services</a>
                <a href="#" class="text-gray-700 hover:text-purple-600 font-medium">Partners</a>
                <a href="#" class="text-gray-700 hover:text-purple-600 font-medium">News</a>
                <a href="#" class="text-gray-700 hover:text-purple-600 font-medium">Contact</a>
            </nav>
        </div>
        <div class="flex items-center space-x-4">
            <a href="{{route('login')}}" class="text-gray-700 hover:text-purple-600">Login</a>
            <a href="#" class="text-gray-700 hover:text-purple-600">Register</a>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="relative h-[600px] bg-cover bg-center" style="background-image: url('https://via.placeholder.com/1920x600?text=Airlines');">
    <div class="absolute inset-0 bg-purple-900 bg-opacity-60 flex flex-col justify-center items-center text-center text-white">
        <h1 class="text-5xl font-bold mb-4 animate-bounce">POWERFUL <span class="text-yellow-400">B2B Airline Solutions</span></h1>
        <p class="text-xl mb-6">Connect with top airlines, manage bookings, and boost your business efficiency.</p>
        <a href="#" class="bg-purple-600 hover:bg-yellow-500 px-6 py-3 rounded-full text-white font-semibold transition">Get Started</a>
    </div>
</section>

<!-- Search / Booking Panel -->
<section class="bg-gradient-to-r from-orange-400 to-purple-600 p-6 -mt-16 relative z-10 rounded-xl mx-6 shadow-lg">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex space-x-2">
            <button class="bg-white text-purple-600 px-4 py-2 rounded-full font-medium shadow">Flights</button>
            <button class="bg-transparent text-white px-4 py-2 rounded-full font-medium hover:bg-white hover:text-purple-600">Charters</button>
            <button class="bg-transparent text-white px-4 py-2 rounded-full font-medium hover:bg-white hover:text-purple-600">Corporate Packages</button>
        </div>
        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 w-full md:w-auto">
            <input type="text" placeholder="Destination / Airline" class="p-2 rounded w-full md:w-48">
            <input type="date" class="p-2 rounded w-full md:w-40">
            <input type="date" class="p-2 rounded w-full md:w-40">
            <select class="p-2 rounded">
                <option>1 Passenger</option>
                <option>2 Passengers</option>
            </select>
            <select class="p-2 rounded">
                <option>0 Children</option>
                <option>1 Child</option>
            </select>
            <button class="bg-purple-900 text-white px-4 py-2 rounded hover:bg-yellow-500 transition">Search Flights</button>
        </div>
    </div>
</section>

<!-- Featured Airlines -->
<section class="container mx-auto py-16 px-6 text-center">
    <h2 class="text-3xl font-bold mb-4">Our Partner Airlines</h2>
    <p class="text-gray-600 mb-8">We provide exclusive B2B access to top international airlines.</p>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-cover bg-center h-80 rounded-lg relative shadow-lg" style="background-image: url('https://via.placeholder.com/400x300?text=Emirates');">
            <div class="absolute bottom-0 bg-purple-900 bg-opacity-70 w-full p-4 rounded-b-lg text-white">
                <h3 class="text-xl font-bold">Emirates</h3>
                <p>Special B2B Rates Available</p>
                <button class="mt-2 bg-yellow-400 text-purple-900 px-3 py-1 rounded">See Details</button>
            </div>
        </div>
        <div class="bg-cover bg-center h-80 rounded-lg relative shadow-lg" style="background-image: url('https://via.placeholder.com/400x300?text=Qatar');">
            <div class="absolute bottom-0 bg-purple-900 bg-opacity-70 w-full p-4 rounded-b-lg text-white">
                <h3 class="text-xl font-bold">Qatar Airways</h3>
                <p>Exclusive B2B Deals</p>
                <button class="mt-2 bg-yellow-400 text-purple-900 px-3 py-1 rounded">See Details</button>
            </div>
        </div>
        <div class="bg-cover bg-center h-80 rounded-lg relative shadow-lg" style="background-image: url('https://via.placeholder.com/400x300?text=Singapore');">
            <div class="absolute bottom-0 bg-purple-900 bg-opacity-70 w-full p-4 rounded-b-lg text-white">
                <h3 class="text-xl font-bold">Singapore Airlines</h3>
                <p>Premium B2B Offers</p>
                <button class="mt-2 bg-yellow-400 text-purple-900 px-3 py-1 rounded">See Details</button>
            </div>
        </div>
    </div>
</section>

<!-- Special Corporate Package -->
<section class="relative py-16 bg-cover bg-center" style="background-image: url('https://via.placeholder.com/1920x500?text=Corporate');">
    <div class="bg-white bg-opacity-90 mx-6 md:mx-32 p-12 rounded-lg text-center shadow-lg">
        <h2 class="text-3xl font-bold mb-2">CORPORATE TRAVEL PACKAGE</h2>
        <p class="text-yellow-400 mb-4">★★★★★</p>
        <p class="text-gray-600 mb-6">Tailored airline packages for your company, including special rates and dedicated support.</p>
        <button class="bg-orange-400 text-white px-6 py-3 rounded hover:bg-purple-600 transition">Book Now</button>
    </div>
</section>

<!-- B2B Offers -->
<section class="container mx-auto py-16 px-6">
    <h2 class="text-3xl font-bold mb-8 text-center">Exclusive Airline B2B Deals</h2>
    <div class="grid md:grid-cols-4 gap-6">
        <div class="bg-white rounded shadow-lg overflow-hidden">
            <img src="https://via.placeholder.com/400x300" class="w-full h-48 object-cover">
            <div class="p-4">
                <p class="text-orange-500 font-bold">$250 per seat</p>
                <h3 class="font-bold mb-2">Business Class Emirates</h3>
                <p class="text-gray-600 text-sm mb-2">Special corporate pricing for B2B partners.</p>
                <a href="#" class="text-purple-600 font-semibold">Read More</a>
            </div>
        </div>
        <div class="bg-white rounded shadow-lg overflow-hidden">
            <img src="https://via.placeholder.com/400x300" class="w-full h-48 object-cover">
            <div class="p-4">
                <p class="text-orange-500 font-bold">$200 per seat</p>
                <h3 class="font-bold mb-2">Qatar Airways Economy</h3>
                <p class="text-gray-600 text-sm mb-2">Best B2B deals for travel agencies.</p>
                <a href="#" class="text-purple-600 font-semibold">Read More</a>
            </div>
        </div>
        <div class="bg-white rounded shadow-lg overflow-hidden">
            <img src="https://via.placeholder.com/400x300" class="w-full h-48 object-cover">
            <div class="p-4">
                <p class="text-orange-500 font-bold">$300 per seat</p>
                <h3 class="font-bold mb-2">Singapore Airlines Premium</h3>
                <p class="text-gray-600 text-sm mb-2">Exclusive B2B partner rates available.</p>
                <a href="#" class="text-purple-600 font-semibold">Read More</a>
            </div>
        </div>
        <div class="bg-white rounded shadow-lg overflow-hidden">
            <img src="https://via.placeholder.com/400x300" class="w-full h-48 object-cover">
            <div class="p-4">
                <p class="text-orange-500 font-bold">$150 per seat</p>
                <h3 class="font-bold mb-2">Regional Connect Flights</h3>
                <p class="text-gray-600 text-sm mb-2">Affordable B2B flight solutions for small agencies.</p>
                <a href="#" class="text-purple-600 font-semibold">Read More</a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="container mx-auto py-16 px-6 text-center">
    <h2 class="text-3xl font-bold mb-8">What Our B2B Clients Say</h2>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-purple-900 text-white p-6 rounded shadow-lg relative">
            <p class="mb-4">"Divine Travel helped us streamline our bookings with multiple airlines."</p>
            <h4 class="font-bold">Global Travel Co.</h4>
            <span class="text-gray-300 text-sm">March 12, 2023</span>
        </div>
        <div class="bg-purple-900 text-white p-6 rounded shadow-lg relative">
            <p class="mb-4">"Excellent B2B rates and support for corporate clients."</p>
            <h4 class="font-bold">SkyHigh Agencies</h4>
            <span class="text-gray-300 text-sm">April 5, 2023</span>
        </div>
        <div class="bg-purple-900 text-white p-6 rounded shadow-lg relative">
            <p class="mb-4">"Partnering with Divine Travel has grown our airline sales significantly."</p>
            <h4 class="font-bold">Elite Travels Ltd.</h4>
            <span class="text-gray-300 text-sm">May 20, 2023</span>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="container mx-auto py-16 px-6 grid md:grid-cols-2 gap-8 items-center">
    <img src="https://via.placeholder.com/400x500?text=Travel+Manager" class="w-full rounded shadow-lg">
    <div class="bg-gradient-to-br from-purple-600 to-orange-400 p-8 rounded-lg shadow-lg text-white">
        <h2 class="text-2xl font-bold mb-4">Get In Touch with Us</h2>
        <p class="mb-4">For partnerships, corporate accounts, or B2B inquiries, contact our dedicated team.</p>
        <form class="space-y-4">
            <input type="text" placeholder="Name / Company" class="w-full p-2 rounded text-black">
            <input type="email" placeholder="Email" class="w-full p-2 rounded text-black">
            <input type="text" placeholder="Subject" class="w-full p-2 rounded text-black">
            <textarea placeholder="Message" class="w-full p-2 rounded text-black"></textarea>
            <button class="bg-purple-900 px-6 py-2 rounded hover:bg-yellow-400 transition font-semibold">Send Message</button>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="bg-purple-900 text-white py-12 px-6">
    <div class="container mx-auto grid md:grid-cols-4 gap-8">
        <div>
            <h3 class="font-bold text-xl mb-4">Divine Travel</h3>
            <p>Leading B2B airline ticketing solutions connecting agencies with top international airlines.</p>
        </div>
        <div>
            <h3 class="font-bold text-xl mb-4">Blog Posts</h3>
            <ul class="space-y-2">
                <li>Top B2B Airline Partners in 2026</li>
                <li>How to Boost Corporate Bookings</li>
                <li>Exclusive Airline Deals for Agencies</li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold text-xl mb-4">Tags</h3>
            <div class="flex flex-wrap gap-2">
                <span class="bg-purple-700 px-2 py-1 rounded text-sm">Airline</span>
                <span class="bg-purple-700 px-2 py-1 rounded text-sm">B2B</span>
                <span class="bg-purple-700 px-2 py-1 rounded text-sm">Corporate</span>
                <span class="bg-purple-700 px-2 py-1 rounded text-sm">Travel</span>
            </div>
        </div>
        <div>
            <h3 class="font-bold text-xl mb-4">Contact Info</h3>
            <p>123 Travel Street, NY</p>
            <p>Email: info@divinetravel.com</p>
            <p>Phone: +123 456 7890</p>
        </div>
    </div>
</footer>

</body>
</html>
