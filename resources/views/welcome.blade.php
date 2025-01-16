<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCNP-ISAP</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* Header styles */
        header {
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            width: 120px;
            height: 60px;
        }

        .university-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: #515863;
        }

        .university-campus {
            font-size: 1rem;
        }

        nav {
            position: relative;
        }

        nav ul {
            display: flex;
            list-style-type: none;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: #4a5568;
        }

        nav a:hover {
            color: #2d3748;
        }

        /* Hamburger menu styles */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .hamburger div {
            width: 25px;
            height: 3px;
            background-color: #4a5568;
        }

        .mobile-nav {
            display: none;
            flex-direction: column;
            background-color: white;
            position: absolute;
            top: 100%;
            right: 0;
            width: 200px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
        }

        .mobile-nav ul {
            flex-direction: column;
            padding: 1rem;
        }

        .mobile-nav a {
            padding: 0.5rem 1rem;
            display: block;
            color: #4a5568;
            border-bottom: 1px solid #e2e8f0;
        }

        .mobile-nav a:last-child {
            border-bottom: none;
        }

        .mobile-nav a:hover {
            background-color: #f7fafc;
        }

        /* Hero section styles */
        .hero {
            position: relative;
            width: 100%;
            height: 80vh;
            overflow: hidden;
        }

        .video-frame {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Content grid styles */
        .content-grid {
            max-width: 1200px;
            margin: 3rem auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            padding: 0 1rem;
        }

        .card {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .card-content {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: #718096;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            nav ul {
                display: none;
            }

            .hamburger {
                display: flex;
            }

            .mobile-nav {
                display: flex;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="{{ asset('frontend/images/mcnp-isap.png') }}" alt="University Logo" class="logo">
                <div>
                    <div class="university-name">Medical Colleges of Northern Philippines</div>
                    <div class="university-name">International School of Asia and the Pacific</div>
                    <div class="university-campus">Alimanao Peñablanca Campus</div>
                </div>
            </div>
            <nav>
                <div class="hamburger" id="hamburger">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <ul class="desktop-nav">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="{{ route('student.info') }}">Enroll Now!</a></li>
                </ul>
                <div class="mobile-nav" id="mobileNav">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Enroll Now!</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <section class="hero">
        <video autoplay loop muted class="video-frame">
            <source src="{{ asset('frontend/images/MCNP-ISAP Campus Virtual Tour 2023.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </section>

    <section class="content-grid">
        <div class="card">
            <div class="card-image" style="background-image: url('placeholder-students1.jpg');"></div>
            <div class="card-content">
                <h2 class="card-title">BSIT</h2>
                <p class="card-description">Student life and activities for the course Bachelor of Science and
                    information Technology</p>
            </div>
        </div>
        <div class="card">
            <div class="card-image" style="background-image: url('placeholder-students2.jpg');"></div>
            <div class="card-content">
                <h2 class="card-title">BSCPE</h2>
                <p class="card-description">Student life and activities for the course Bachelor of Science and
                    information Technology</p>
            </div>
        </div>
        <div class="card">
            <div class="card-image" style="background-image: url('placeholder-academe.jpg');"></div>
            <div class="card-content">
                <h2 class="card-title">BCRIMINOLOGY</h2>
                <p class="card-description">Student life and activities for the course Bachelor of Science and
                    information Technology</p>
            </div>
        </div>
    </section>

    <script>
        const hamburger = document.getElementById("hamburger");
        const mobileNav = document.getElementById("mobileNav");

        hamburger.addEventListener("click", () => {
            mobileNav.classList.toggle("active");
        });
    </script>
</body>


</html>
