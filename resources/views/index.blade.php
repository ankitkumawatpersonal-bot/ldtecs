<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ldtecs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root {
            --bg-1: #C0C4C4;
            --bg-2: #FFFFFF;
            --bg-3: #8D8E8E;
            --bg-4: #696969;
            --accent: #24A19C;
            --text: #191B19;
            --text-soft: #4B4F4B;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        html {
            scroll-behavior: smooth;
        }

        html, body {
            touch-action: auto;
        }

        body {
            text-align: center;
            color: var(--text);
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            width: 100%;
            display: flex;
            flex-direction: column;
        }
        .header {
            position: relative;
            margin-top:0px;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 50px;
            /* background: var(--bg-2); */
            /* border-bottom: 1px solid black; */
            box-shadow: 0 2px 12px rgba(25, 27, 25, 0.08);
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .img {
            width: 70px;
            height: 70px;
            background-color: var(--text);
            border: 2px solid var(--accent);
            border-radius: 10px;
            cursor: pointer;
            object-fit: cover;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .img:hover {
            transform: scale(1.06);
            box-shadow: 0 4px 12px rgba(36, 161, 156, 0.35);
        }

        .brand {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            margin-left: 12px;
            letter-spacing: 0.5px;
        }

        .navbar {
            display: flex;
            align-items: center;
            gap: 34px;  
        }

        .navbar a {
            position: relative;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            color: #ffffff;
            padding: 8px 2px;
            transition: color 0.25s ease;
        }

        .navbar a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0%;
            height: 2px;
            background: #e9aa6b;
            border-radius: 2px;
            transition: width 0.25s ease;
        }

        .navbar a:hover {
            color: #e9aa6b;
        }

        .navbar a:hover::after,
        .navbar a.active::after {
            width: 100%;
        }

        .navbar a.active {
            color: #e9aa6b;
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 6px;
        }

        .menu-toggle span {
            width: 26px;
            height: 3px;
            background: #e9aa6b;
            border-radius: 2px;
        }

        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 18px;
            padding: 80px 80px;
            text-align: center;
            box-sizing: border-box;
            
        }

        .hero h1 {
            font-size: 100px;
            color: #ffffff;
            max-width: 1000px;
            line-height: 1.3;
            text-align: center;
            margin: 0;
        }

        .hero span {
            color: #42b9e4;

        }

        .hero p {
            font-size: 30px;
            color:#ffffff;
            max-width: 1000px;
            text-align: center;
            margin: 0;
        }

        .para{
            padding-top:50px;
            margin-bottom:10px;
            line-height: 1.5;
        }

         .hero-img{
            width: 100%;
            height: 100%;
            max-width: 100%;
            position: absolute;
            inset: 0;
            z-index: -1;
            object-fit: cover;

        }

        @media (max-width: 820px) {
            .header {
                padding: 12px 20px;
            }

            .navbar {
                position: fixed;
                top: 70px;
                right: 20px;
                left: 20px;
                background: #e9aa6b;
                border: 1px solid var(--bg-1);
                border-radius: 10px;
                box-shadow: 0 8px 24px rgba(25, 27, 25, 0.15);
                flex-direction: column;
                gap: 6px;
                padding: 14px;
                display: none;
            }

            .navbar.open {
                display: flex;
            }

            .navbar a {
                width: 100%;
                padding: 10px 6px;
            }

            .product-menu {
                width: 100%;
            }

            .product-popup {
                position: static;
                width: 100%;
                margin-top: 4px;
                transform: none;
                box-shadow: none;
                border: 1px solid var(--bg-1);
            }

            .product-menu:hover .product-popup {
                transform: none;
            }

            .menu-toggle {
                display: flex;
            }

            .menu-toggle span {
                transition: transform 0.25s ease, opacity 0.25s ease;
            }

            .hero h1 {
                font-size: 30px;
            }
        }

        .product-menu {
            position: relative;
        }

        .product-link {
            text-decoration: none;
            color: #222;
            padding: 8px 2px;
            display: block;
        }

        /*popup initially hidden*/
        .product-popup {
            position: absolute;
            top: calc(100% + 8px);
            width: 700px;
            height:100px;
            background: #fff;
            border-radius: 8px;
            padding: 12px 0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translate(-50%, 10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
            z-index: 1000;
            display:flex;
            justify-content:space-between;
            
        }

        /*cursor pointer*/
        .product-menu:hover .product-popup {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, 0);
        }

        .product-popup a{
            margin: 12px 18px;
            display:flex;
            padding: 12px 18px;
            color:#222;
            text-decoration:none;
            transition: 0.3s;
        }

        .product-popup a:hover{
            background:#f1f7f7;
            color:#e9aa6b;
        }

        .nano1, .lite1 {
            padding: 0 20px;
            border-left: 2px solid #6f6a67;
        }

        .page1{
            position:relative;
            width:100%;
            min-height:100vh;
            display:flex;
            flex-direction:column;
            isolation:isolate;
        }
        /* =========================================
        OUR PRODUCTS SECTION
        ========================================= */

        .page2 {
            width: 100%;
            min-height: 100vh;
            padding: 70px 35px 80px;

            background-color: #fff;

            text-align: center;
            overflow: hidden;
        }


        /* =========================================
        PRODUCTS TITLE
        ========================================= */

        .products-title {
            margin: 0 0 55px;

            font-family: "Segoe UI", Arial, sans-serif;
            font-size: clamp(35px, 4vw, 55px);
            font-weight: 700;


            color: #191b19;

            opacity: 1;
        }


        /* =========================================
        PRODUCTS CONTAINER
        ========================================= */

        .products-container {

            width: 100%;
            max-width: 1800px;

            margin: 0 auto;

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 20px;

            align-items: stretch;
        }


        /* =========================================
        PRODUCT CARD
        ========================================= */

        .product-card {

            width: 100%;
            min-height: 620px;

            background: #ffffff;

            border: 2px solid #111;

            border-radius: 20px;

            padding: 20px 10px 15px;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: space-between;

            overflow: hidden;

            position: relative;

            transition:
                transform 0.4s ease,
                box-shadow 0.4s ease,
                border-color 0.4s ease;
        }


        /* =========================================
        CARD HOVER
        ========================================= */

        .product-card:hover {

            transform: translateY(-10px);

            box-shadow:
                0 20px 45px rgba(0, 0, 0, 0.15);

            border-color: #24a19c;
        }


        /* =========================================
        IMAGE LINK
        ========================================= */

        .product-image-link {

            width: 100%;
            height: 390px;

            display: flex;

            align-items: center;
            justify-content: center;

            text-decoration: none;

            overflow: hidden;

            border-radius: 12px;
        }


        /* =========================================
        PRODUCT IMAGE
        ========================================= */

        .product-image {

            width: 90%;
            height: 100%;

            object-fit: contain;

            display: block;

            cursor: pointer;

            transform: scale(1);

            transition:
                transform 0.5s ease,
                filter 0.5s ease;
        }


        /* =========================================
        IMAGE HOVER ZOOM
        ========================================= */

        .product-card:hover .product-image {

            transform: scale(1.08);

            filter: brightness(1.03);
        }


        /* =========================================
        INDIVIDUAL IMAGE SIZE
        ========================================= */

        .product-image.elite {

            width: 90%;
            height: 90%;

            object-fit: contain;
        }


        .product-image.lite {

            width: 82%;
            height: 90%;

            object-fit: contain;
        }


        .product-image.nano {

            width: 62%;
            height: 90%;

            object-fit: contain;
        }


        /* =========================================
        PRODUCT DETAILS
        ========================================= */

        .diem {

            width: 100%;

            margin-top: 20px;

            text-align: center;

            color: #000;

            font-family:
                "Bahnschrift SemiBold Condensed",
                "Segoe UI",
                Arial,
                sans-serif;
        }


        /* =========================================
        PRODUCT NAME
        ========================================= */

        .diem h2 {

            margin: 0;

            font-family:
                "Times New Roman",
                serif;

            font-size: clamp(30px, 2.5vw, 42px);

            font-weight: 500;

            letter-spacing: 8px;

            line-height: 1.1;

            color: #000;
        }


        /* =========================================
        ELITE / LITE / NANO
        ========================================= */

        .diem h3 {

            margin: 5px 0 15px;

            font-family:
                "Times New Roman",
                serif;

            font-size: clamp(18px, 1.5vw, 25px);

            font-weight: 500;

            letter-spacing: 6px;

            color: #000;

            text-align: right;

            padding-right: 10%;
        }


        /* =========================================
        DIMENSION
        ========================================= */

        .diem p {

            margin: 5px 0;

            font-size: 18px;

            line-height: 1.4;

            color: #000;
        }


        /* =========================================
        FIRST DIMENSION TEXT
        ========================================= */

        .diem p:first-of-type {

            margin-top: 5px;

            font-size: 18px;
        }


        /* =========================================
        CLICK EFFECT
        ========================================= */

        .product-image-link:active {

            transform: scale(0.97);
        }


        /* =========================================
        TABLET
        ========================================= */

        @media (max-width: 1100px) {

            .page2 {

                padding: 60px 25px;
            }

            .products-container {

                grid-template-columns: repeat(2, 1fr);

                gap: 20px;
            }

            .product-card {

            min-height: 600px;
        }

        .product-image-link {

            height: 350px;
        }

        }


        /* =========================================
        MOBILE
        ========================================= */

        @media (max-width: 700px) {

            .page2 {

                padding: 45px 15px 60px;
            }

            .products-title {

                margin-bottom: 35px;

                font-size: 38px;
            }

            .products-container {

                grid-template-columns: 1fr;

                gap: 25px;

                max-width: 500px;
            }

            .product-card {

                min-height: 580px;

                padding: 25px 15px;
            }

            .product-image-link {

                height: 350px;
            }

            .product-image {

                width: 90%;
            }

            .diem h2 {

                font-size: 20px;

                letter-spacing: 6px;
            }

            .diem h3 {

                font-size: 16px;

                letter-spacing: 5px;

                padding-right: 12%;
            }

        }


        /* =========================================
        SMALL MOBILE
        ========================================= */

        @media (max-width: 450px) {

            .page2 {

                padding: 35px 10px 50px;
            }

            .products-title {

                font-size: 32px;
            }

            .product-card {

                min-height: 520px;

                border-radius: 15px;
            }

            .product-image-link {

                height: 300px;
            }

            .diem h2 {

                font-size: 20px;

                letter-spacing: 4px;
            }

            .diem h3 {

                font-size: 16px;

                letter-spacing: 4px;
            }

            .diem p {

                font-size: 16px;
            }

        }

        .page3{
            width:100%;
            height:100vh;
            font-size:50px;
            background-color:rgb(109, 107, 111);

        }

        .products-title1 {
            margin: 0 0 55px;

            font-family: "Segoe UI", Arial, sans-serif;
            font-size: clamp(35px, 4vw, 55px);
            font-weight: 700;
            padding-top:20px;
            color: #191b19;

            opacity: 1;
        }
        
    </style>
</head>
<body>
    <div class="page1">
        <img class="hero-img" src="background.png" alt="">
        <header class="header">
            <div class="logo">
                <img class="img" src="logo.png" alt="logo" onerror="this.style.background='var(--text)'">
                <span class="brand">LDTECS</span>
            </div>

            <nav class="navbar" id="navbar">
                <a href="/" class="active">Home</a>
                <div class="product-menu">
                    <a href="#our-products" class="product-link">Products <i class="fa-solid fa-chevron-down"></i></a>
                    <div class="product-popup">
                        <div class="elite">
                            <a href="/elite"> CLASSIFIER ELITE </a>
                        </div>
                        <div class="lite1">
                            <a href="/lite"> CLASSIFIER LITE </a>
                        </div>
                        <div class="nano1">
                            <a href="/nano"> CLASSIFIER NANO </a>
                        </div>
                    </div>
                </div>
                <a href="/services">Services</a>
                <a href="/career">Career</a>
                <a href="/about">About</a>
            </nav>
        </header>
        <section class="hero">
            <h1 id="title1">Welcome To <br><span>LDTECS</span></h1>
            <div class="para">
                <p id="title2">Leading the science of Diamond Detection </p>
            </div>
        </section>    
    </div>
    <section class="page2" id="our-products">

        <h1 id="productsTitle" class="products-title">Our Products</h1>

        <div class="products-container">

            <!-- CLASSIFIER ELITE -->
            <div class="box1 product-card">

                <a href="/elite" class="product-image-link">
                    <img class="product-image elite" src="machine.png" alt="Classifier Elite" id="zoomImage">
                </a>

                <div class="diem">
                    <h2>CLASSIFIER</h2>
                    <h3>ELITE</h3>

                    <p>Dimension</p>
                    <p>(300 * 280 * 320) mm</p>
                </div>

            </div>


            <!-- CLASSIFIER LITE -->
            <div class="box1 product-card">

                <a href="/lite" class="product-image-link">
                    <img class="product-image lite" src="lite1.png" alt="Classifier Lite" id="zoomLite">
                </a>

                <div class="diem">
                    <h2>CLASSIFIER</h2>
                    <h3>LITE</h3>

                    <p>Dimension</p>
                    <p>(180 * 250 * 190) mm</p>
                </div>

            </div>


            <!-- CLASSIFIER NANO -->
            <div class="box1 product-card">

                <a href="/nano" class="product-image-link">
                    <img class="product-image nano" src="nano1.png" alt="Classifier Nano" id="zoomNano">
                </a>

                <div class="diem">
                    <h2>CLASSIFIER</h2>
                    <h3>NANO</h3>

                    <p>Dimension</p>
                    <p>(160 * 160 * 160) mm</p>
                </div>

            </div>

        </div>
    </section>

    <section class="page3" id="our-technology">
        <h1 id="technologyTitle" class="products-title1">Our Technology</h1>
        <p  style="font-size:22px; color:white;"> Advanced Technology for Diamond Identification & Screening </p>
        <p style="font-size:18px; color:white;">At LDTECS, we develop advanced diamond detection technologies designed 
            to help laboratories, jewellery manufacturers, traders, retailers, and 
            diamond professionals distinguish between natural diamonds, laboratory
            -grown diamonds, and common simulants.  

            Our systems combine **optical imaging, controlled illumination, image
            processing, material-response analysis, and intelligent classification** 
            to examine diamond characteristics and assist users in making fast and
            consistent screening decisions. </p>    

        
    </section>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.15.0/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.15.0/ScrollTrigger.min.js"></script>

    <script>
        gsap.registerPlugin(ScrollTrigger);
    </script>

    <script src="{{ asset('script.js') }}"></script>
    
    <script>
        const toggle = document.getElementById('menuToggle');
        const navbar = document.getElementById('navbar');

        if (toggle && navbar) {
            toggle.addEventListener('click', () => {
                const isOpen = navbar.classList.toggle('open');
                toggle.setAttribute('aria-expanded', String(isOpen));
            });

            document.querySelectorAll('.navbar a').forEach(link => {
                link.addEventListener('click', () => {
                    document.querySelectorAll('.navbar a').forEach(a => a.classList.remove('active'));
                    link.classList.add('active');
                    navbar.classList.remove('open');
                    toggle.setAttribute('aria-expanded', 'false');
                });
            });
        }
    </script>
</body>
</html>