<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TalentBridge – Connect Globally, Hire Brilliantly</title>
  <!-- Poppins & Material Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="flex flex-col min-h-screen text-gray-800">

  <!-- NAVBAR -->
  <nav class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="#" class="text-2xl font-bold text-teal-600">TalentBridge</a>
      <ul class="hidden md:flex space-x-8">
        <li><a href="#" class="hover:text-teal-600 transition">Home</a></li>
        <li><a href="#" class="hover:text-teal-600 transition">Jobs</a></li>
        <li><a href="#" class="hover:text-teal-600 transition">Employers</a></li>
        <li><a href="#" class="hover:text-teal-600 transition">About</a></li>
        <li><a href="#" class="hover:text-teal-600 transition">Contact</a></li>
      </ul>
      <div class="hidden md:flex space-x-4">
        <a href="{{ route('login') }}" class="text-teal-600 font-medium hover:underline transition">Login</a>
        <a href="{{ route('register') }}" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">Sign Up</a>
      </div>
      <button class="md:hidden focus:outline-none">
        <span class="material-icons text-3xl">menu</span>
      </button>
    </div>
  </nav>

  <!-- HERO -->
  <header class="relative h-screen bg-cover bg-center" style="background-image:url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=1350&q=80')">
    <div class="absolute inset-0 bg-gradient-to-r from-teal-600/80 to-blue-600/80"></div>
    <div class="relative z-10 container mx-auto px-6 h-full flex flex-col justify-center items-center text-center text-white space-y-6">
      <h1 class="text-4xl md:text-6xl font-bold leading-tight">
        Your Global Talent Marketplace<br/>
        Hire Smarter, Grow Faster
      </h1>
      <p class="max-w-xl text-lg md:text-xl">
        Discover top candidates from around the world or land your dream role—fast, secure, and hassle-free.
      </p>
      <form action="/jobs" method="GET" class="w-full max-w-2xl grid grid-cols-1 sm:grid-cols-3 gap-4">
        <input type="text" name="keyword" placeholder="Job title or keyword"
               class="px-4 py-3 rounded-lg focus:ring-2 focus:ring-white text-gray-800"/>
        <input type="text" name="location" placeholder="Location"
               class="px-4 py-3 rounded-lg focus:ring-2 focus:ring-white text-gray-800"/>
        <button type="submit"
                class="bg-white text-teal-600 font-semibold rounded-lg hover:bg-gray-100 transition">
          Search Jobs
        </button>
      </form>
    </div>
  </header>

  <!-- FEATURES (PRIMARY BG) -->
  <section class="py-16 bg-teal-600 text-white">
    <div class="container mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-8">Why Choose TalentBridge?</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition text-gray-800">
          <span class="material-icons text-4xl text-teal-600 mb-4">public</span>
          <h3 class="font-semibold text-xl mb-2">Global Reach</h3>
          <p>Access talent and opportunities across 50+ countries seamlessly.</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition text-gray-800">
          <span class="material-icons text-4xl text-teal-600 mb-4">verified</span>
          <h3 class="font-semibold text-xl mb-2">Verified Employers</h3>
          <p>All companies undergo strict identity and compliance checks.</p>
        </div>
        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition text-gray-800">
          <span class="material-icons text-4xl text-teal-600 mb-4">support_agent</span>
          <h3 class="font-semibold text-xl mb-2">24/7 Support</h3>
          <p>Our dedicated team is here to help you at every step.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CATEGORIES (PRIMARY BG) -->
  <section class="py-16 bg-teal-600">
    <div class="container mx-auto px-6 text-center text-white">
      <h2 class="text-3xl font-bold mb-8">Popular Categories</h2>
      <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-6">
        <a href="#" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-gray-800">
          <img src="https://img.icons8.com/color/96/000000/source-code.png" alt="IT & Software" class="mx-auto mb-2 h-12"/>
          <span>IT & Software</span>
        </a>
        <a href="#" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-gray-800">
          <img src="https://img.icons8.com/color/96/000000/finance.png" alt="Finance" class="mx-auto mb-2 h-12"/>
          <span>Finance</span>
        </a>
        <a href="#" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-gray-800">
          <img src="https://img.icons8.com/color/96/000000/healthcare.png" alt="Healthcare" class="mx-auto mb-2 h-12"/>
          <span>Healthcare</span>
        </a>
        <a href="#" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-gray-800">
          <img src="https://img.icons8.com/color/96/000000/engineering.png" alt="Engineering" class="mx-auto mb-2 h-12"/>
          <span>Engineering</span>
        </a>
        <a href="#" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-gray-800">
          <img src="https://img.icons8.com/color/96/000000/marketing.png" alt="Marketing" class="mx-auto mb-2 h-12"/>
          <span>Marketing</span>
        </a>
        <a href="#" class="block bg-white p-4 rounded-lg shadow hover:shadow-lg transition text-gray-800">
          <img src="https://img.icons8.com/color/96/000000/customer-support.png" alt="Support" class="mx-auto mb-2 h-12"/>
          <span>Customer Support</span>
        </a>
      </div>
    </div>
  </section>

  <!-- FEATURED JOBS (PRIMARY BG) -->
  <section class="py-16 bg-teal-600">
    <div class="container mx-auto px-6 text-center text-white">
      <h2 class="text-3xl font-bold mb-8">Featured Jobs</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col text-gray-800">
          <h3 class="font-semibold text-xl mb-2">Senior Software Engineer</h3>
          <p class="text-gray-600 mb-4">TechGlobal • London, UK</p>
          <div class="mt-auto">
            <a href="#" class="inline-block px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">Apply Now</a>
          </div>
        </div>
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col text-gray-800">
          <h3 class="font-semibold text-xl mb-2">Marketing Manager</h3>
          <p class="text-gray-600 mb-4">BrandWorks • New York, USA</p>
          <div class="mt-auto">
            <a href="#" class="inline-block px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">Apply Now</a>
          </div>
        </div>
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col text-gray-800">
          <h3 class="font-semibold text-xl mb-2">Data Analyst</h3>
          <p class="text-gray-600 mb-4">InsightLab • Sydney, Australia</p>
          <div class="mt-auto">
            <a href="#" class="inline-block px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">Apply Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS (PRIMARY BG) -->
  <section class="py-16 bg-teal-600">
    <div class="container mx-auto px-6 text-center text-white">
      <h2 class="text-3xl font-bold mb-8">What Our Users Say</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-xl shadow p-6 text-gray-800">
          <div class="flex items-center mb-4">
            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Anna" class="w-16 h-16 rounded-full mr-4"/>
            <div>
              <p class="font-semibold">Anna Thompson</p>
              <p class="text-sm text-gray-500">Product Manager, London</p>
            </div>
          </div>
          <p>“TalentBridge helped me find my dream role in just two weeks!”</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6 text-gray-800">
          <div class="flex items-center mb-4">
            <img src="https://randomuser.me/api/portraits/men/50.jpg" alt="Carlos" class="w-16 h-16 rounded-full mr-4"/>
            <div>
              <p class="font-semibold">Carlos Mendes</p>
              <p class="text-sm text-gray-500">CTO, TechGlobal</p>
            </div>
          </div>
          <p>“Our team grew by 30% with top-tier talent from around the world.”</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTACT US (PRIMARY BG) -->
  <section class="py-16 bg-teal-600 text-white">
    <div class="container mx-auto px-6">
      <h2 class="text-3xl font-bold text-center mb-8">Contact Us</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Info -->
        <div class="space-y-6">
          <p>Have questions or need help? We'd love to hear from you!</p>
          <div class="flex items-start space-x-4">
            <span class="material-icons text-3xl">location_on</span>
            <div>
              <h5 class="font-semibold">Our Office</h5>
              <p>123 Global Ave, Suite 100<br/>New York, NY 10001</p>
            </div>
          </div>
          <div class="flex items-start space-x-4">
            <span class="material-icons text-3xl">email</span>
            <div>
              <h5 class="font-semibold">Email Us</h5>
              <p>support@talentbridge.com</p>
            </div>
          </div>
          <div class="flex items-start space-x-4">
            <span class="material-icons text-3xl">phone</span>
            <div>
              <h5 class="font-semibold">Call Us</h5>
              <p>+1 (212) 555-0123</p>
            </div>
          </div>
        </div>
        <!-- Form -->
        <form class="space-y-4 bg-white p-6 rounded-xl shadow text-gray-800">
          <div>
            <label for="name" class="block mb-1">Name</label>
            <input id="name" type="text" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500"/>
          </div>
          <div>
            <label for="email" class="block mb-1">Email</label>
            <input id="email" type="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500"/>
          </div>
          <div>
            <label for="subject" class="block mb-1">Subject</label>
            <input id="subject" type="text" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500"/>
          </div>
          <div>
            <label for="message" class="block mb-1">Message</label>
            <textarea id="message" rows="4" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500"></textarea>
          </div>
          <button type="submit" class="w-full py-3 bg-white text-teal-600 font-semibold rounded-lg hover:bg-gray-100 transition">
            Send Message
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- CTA (GRADIENT BG) -->
  <section class="py-16 bg-gradient-to-r from-teal-500 to-blue-500 text-white text-center">
    <div class="container mx-auto px-6">
      <h2 class="text-3xl font-bold mb-4">Ready to Bridge the Talent Gap?</h2>
      <p class="mb-6">Join thousands of employers and candidates on TalentBridge today.</p>
      <a href="#" class="inline-block px-6 py-3 bg-white text-teal-600 font-semibold rounded-lg hover:bg-gray-100 transition">
        Get Started
      </a>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-gray-800 text-gray-400 py-8 mt-auto">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
      <div>
        <h5 class="text-white font-semibold mb-3">TalentBridge</h5>
        <p>Your global recruitment partner.</p>
      </div>
      <div>
        <h6 class="font-semibold mb-3">Company</h6>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-white transition">About Us</a></li>
          <li><a href="#" class="hover:text-white transition">Blog</a></li>
          <li><a href="#" class="hover:text-white transition">Careers</a></li>
        </ul>
      </div>
      <div>
        <h6 class="font-semibold mb-3">Support</h6>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-white transition">Help Center</a></li>
          <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
          <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
        </ul>
      </div>
    </div>
    <div class="text-center text-gray-500 mt-6">&copy; 2025 TalentBridge. All rights reserved.</div>
  </footer>

</body>
</html>
