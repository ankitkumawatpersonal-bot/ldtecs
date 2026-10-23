<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ldtecs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

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
            width: 100px;
            height: 100px;
            /* background-color: var(--text);
            border: 2px solid var(--accent);
            border-radius: 10px; */
            cursor: pointer;
            object-fit: cover;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .img:hover {
            transform: scale(1.06);
            /* box-shadow: 0 4px 12px rgba(36, 161, 156, 0.35); */
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
            gap:60px;
            margin-right:50px; 
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
            

            .product-popup,.product-popup1{
                position: absolute;
                width:200%;
                margin-top: 4px;
                transform: none;
                box-shadow: none;
                border: 1px solid var(--bg-1);
            }

            .product-menu:hover .product-popup,.product-popup1 {
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
            display: block;
        }

        /*popup initially hidden*/
        .product-popup {
            position: absolute;
            top: calc(100% + 8px);
            width: 600px;
            height:100px;
            background: #fff;
            border-radius: 8px;
            padding: 12px 0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            opacity: 0;
            font-family: 'Poppins', sans-serif;
            visibility: hidden;
            transform: translate(-50%, 10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
            z-index: 1000;
            display:flex;
            justify-content:space-between;    
        }

        .product-popup1 {
            position: absolute;
            top: calc(100% + 8px);
            width: 530px;
            height:200px;
            background: #fff;
            border-radius: 8px;
            padding: 12px 0;
            padding-right:20px;
            padding-left:20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            opacity: 0;
            font-family: 'Poppins', sans-serif;
            visibility: hidden;
            transform: translate(-50%, 10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
            z-index: 1000;
            display:flex;
            justify-content:space-between;    
        }

        .feature{
            padding-top:20px;
            font-size:16px;
            font-weight:400px;
            text-align:left;
            line-height:1.7;
        }

        .services{
            text-align:left;
            padding-left:60px;
            border-left:2px solid gray;
        }

        /*cursor pointer*/
        .product-menu:hover .product-popup {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, 0);
        }
        .product-menu:hover .product-popup1{
            opacity:1;
            visibility:visible;
            transform:translate(-50%,0)
        }

        .product-popup a{
            margin: 12px 18px;
            display:flex;
            padding: 12px 18px;
            color:#222;
            text-decoration:none;
            transition: 0.3s;
        }

        .product-popup1 a{
            display:flex;
            color:#222;
            text-decoration:none;
            transition: 0.3s;
        }

        .product-popup a:hover{
            background:#f1f7f7;
            color:#e9aa6b;
        }

        .nano1, .lite1 {
            padding: 0 10px;
            border-left: 2px solid gray;
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


            color: #103b60;

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

            color: #103b60;

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

            color: #103b60;
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

            color: #324c65;

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

            color: #506b82;
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

                padding: d 25px;
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

        /* =================================
            page3 & section services
        ====================================*/

        .services-title {
            text-align: center;
            padding: 45px 20px 25px;
            background: #f1fdf5;
        }

        .services-title h1 {
            font-size: 38px;
            color: #103b60;
            margin-bottom: 12px;
        }

        .services-section {
            padding-top: 20px;
        }

        @media (max-width: 600px) {
            .services-title {
                padding: 30px 15px 20px;
            }

            .services-title h1 {
                font-size: 30px;
            }
        }

        .services-section {
            width: 100%;
            max-width: 1450px;
            margin: auto;
            padding: 35px 5%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }

        /* Two columns */

        .service-column {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .design-column {
            border-left: 2px solid rgba(28, 77, 115, 0.35);
            padding-left: 28px;
        }

        /* Section headings */

        .section-heading {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            min-height: 86px;
            margin-bottom: 5px;
        }

        .heading-icon {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            border: 3px solid #174c75;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 19px;
            font-weight: bold;
        }

        .cube-icon {
            border-color: #168eaa;
            font-size: 32px;
        }

        .section-heading h2 {
            font-size: clamp(19px, 2vw, 26px);
            margin: 3px 0 9px;
            color: #103b60;
        }

        .section-heading p {
            font-size: 13px;
            line-height: 1.6;
            color: #47647d;
            max-width: 440px;
        }

        /* Service cards */

        .service-card {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 16px;
            background: #f7fbfe;
            border: 1px solid #dcebf5;
            border-radius: 9px;
            transition: transform 0.3s ease,
                        box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(28, 77, 115, 0.10);
        }

        .service-card img {
            display: block;
            flex-shrink: 0;
            width: 38%;
            object-fit: cover;
            border-radius: 6px;
        }

        .software-card img {
            height: 215px;
        }

        .design-card img {
            height: 145px;
        }

        .card-content {
            flex: 1;
            min-width: 0;
        }

        .card-content h3 {
            font-size: 17px;
            line-height: 1.4;
            color: #103b60;
            margin-bottom: 6px;
        }

        .card-content p {
            color: #506b82;
            font-size: 12px;
            text-align:left;
            line-height: 1.55;
            margin-bottom: 8px;
        }

        .card-content ul {
            list-style: none;
            margin-bottom: 12px;
            text-align:left;
        }

        .card-content li {
            position: relative;
            padding-left: 17px;
            margin-bottom: 5px;
            color: #4a687f;
            font-size: 12px;
            line-height: 1.35;
        }

        .card-content li::before {
            content: "✔";
            position: absolute;
            left: 0;
            top: 0;
            color: #159db4;
            font-weight: bold;
        }

        /* Learn More button */

        .learn-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 9px 17px;
            border: 1.5px solid #0da5bd;
            border-radius: 25px;
            color: #078ba5;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .learn-btn:hover {
            color: #ffffff;
            background: #0da5bd;
        }

        .learn-btn span {
            font-size: 15px;
        }

        /* Tablet */

        @media (max-width: 1000px) {
            .services-section {
                padding: 28px 3%;
                gap: 20px;
            }

            .design-column {
                padding-left: 20px;
            }

            .service-card {
                gap: 12px;
                padding: 12px;
            }

            .service-card img {
                width: 35%;
            }

            .software-card img {
                height: 175px;
            }

            .design-card img {
                height: 125px;
            }

            .card-content h3 {
                font-size: 15px;
            }
        }

        /* Mobile */

        @media (max-width: 700px) {
            .services-section {
                grid-template-columns: 1fr;
                padding: 25px 16px;
                gap: 30px;
            }

            .design-column {
                border-left: none;
                border-top: 2px solid rgba(28, 77, 115, 0.25);
                padding-left: 0;
                padding-top: 25px;
            }

            .section-heading {
                min-height: auto;
                margin-bottom: 5px;
            }

            .section-heading h2 {
                font-size: 21px;
            }

            .service-card img {
                width: 38%;
                height: 155px;
            }

            .card-content h3 {
                font-size: 15px;
            }

            .card-content p,
            .card-content li {
                font-size: 11px;
            }

            .learn-btn {
                padding: 8px 12px;
                font-size: 11px;
            }
        }

        /* Small mobile screens */

        @media (max-width: 420px) {
            .service-card {
                align-items: flex-start;
                flex-direction: column;
            }

            .service-card img {
                width: 100%;
                height: 190px;
            }

            .card-content {
                width: 100%;
            }

            .section-heading p {
                font-size: 12px;
            }
        }

        .page4{
            width:100%;
            height:100vh;
            font-size:50px;
            background-color:#ffffff;
        }

        .products-title2 {
            margin: 0 0 55px;
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: clamp(35px, 4vw, 55px);
            font-weight: 500;
            padding-top:20px;
            color: #191b19;
            opacity: 1;
        }
        

        /* ========================================== 
        page5 - marquee
        =============================================*/

        .page5{
            width:100%;
            max-height:80vh;
        }

        .page5 h2{
            font-size:40px;
            font-weight:500;
            margin-top:30px;
        }
        
        .clients-section {
            width: 100%;
            padding: 30px 0;
            background: white;
            color: #103b60;
            overflow: hidden;
        }

        .clients-section h2 {
            text-align: center;
            font-size: 48px;
            margin-bottom: 40px;
        }

        .marquee {
            width: 100%;
            overflow: hidden;
            background: #173237;
        }

        .marquee-track {
            display: flex;
            width: max-content;
            animation: marqueeMove 25s linear infinite;
        }

        .marquee-group {
            display: flex;
            align-items: center;
            justify-content: space-around;
            gap: 60px;
            padding-right: 60px;
            padding-top:20px;
            padding-bottom:20px;
            flex-shrink: 0;
        }

        .marquee-group img {
            width: 180px;
            height: 70px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .marquee:hover .marquee-track {
            animation-play-state: paused;
        }

        @keyframes marqueeMove {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }


        /* =================================
            Footer
        ====================================*/
        .footer {
            position: relative;
            width: 100%;
            /* background-image: url("background.png"); */
            background: #173237;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #ffffff;
            padding: 60px 5% 25px;
            overflow: hidden;
            z-index: 1;
        }

        /* Dark overlay for readable text */
        .footer::before {
            content: "";
            position: absolute;
            inset: 0;
            /* background: rgba(59, 60, 60, 0.78); */
            z-index: -1;
        }
        
        /* Heading and Button */
        .footer-cta {
            text-align: center;
            margin-bottom: 45px;
        }

        .footer-cta h1 {
            font-size: 36px;
            line-height: 1.65;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .contact-btn {
            display: inline-block;
            color: #fff;
            text-decoration: none;
            border: 1px solid #fff;
            border-radius: 30px;
            padding: 10px 18px;
            font-size: 16px;
            letter-spacing: 2px;
            transition: 0.3s;
        }

        .contact-btn:hover {
            background: #fff;
            color: #160039;
        }

        /* Main Footer Columns */
        .footer-container {
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr 1fr;
            gap: 60px;
            padding: 0 10px 55px;
        }

        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 22px;
            font-weight: 700;
            text-align: left;
        }

        .footer-column h4 {
            text-align:left;
            font-size: 16px;
            margin: 25px 0 20px;
        }

        .footer-column p {
            text-align:left;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 14px;
        }

        .quick-links a {
            display: block;
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            margin-bottom: 11px;
            transition: 0.3s;
            text-align:left;
        }

        .quick-links a:hover,
        .footer-policy a:hover {
            color: #b9a8e8;
        }

        /* Contact Alignment */
        .contact {
            text-align: center;
        }

        /* Social Media */
        .social-icons {
            display: flex;
            justify-content: left;
            gap: 10px;
            margin-top: 18px;
        }

        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: #fff;
            color: #160039;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .social-icons a:hover {
            background: #b9a8e8;
            transform: translateY(-3px);
        }

        /* Bottom Footer */
        .footer-bottom {
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
            font-size: 14px;
        }

        .footer-policy {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .footer-policy a {
            color: #fff;
            text-decoration: none;
        }

        .copyright {
            font-weight: 600;
            line-height: 1.6;
        }

        .certificates {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .certificate {
            width: 80px;
            height: 75px;
            background: #fff;
            color: #160039;
            border: 2px solid #ccc;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        .certificate small {
            font-size: 9px;
        }

        /* Tablet */
        @media (max-width: 900px) {
            .footer-container {
                grid-template-columns: 1fr 1fr;
                gap: 35px;
            }

            .contact {
                text-align: left;
            }

            .social-icons {
                justify-content: flex-start;
            }

            .footer-bottom {
                justify-content: flex-start;
            }
        }

        /* Mobile */
        @media (max-width: 600px) {
            .footer {
                padding: 40px 22px 25px;
            }

            .footer-cta h1 {
                font-size: 24px;
                line-height: 1.5;
            }

            .footer-container {
                grid-template-columns: 1fr;
                gap: 30px;
                padding-bottom: 35px;
            }

            .footer-column h3 {
                font-size: 16px;
            }

            .footer-column p,
            .quick-links a {
                font-size: 14px;
                overflow-wrap: anywhere;
            }

            .contact {
                text-align: left;
            }

            .social-icons {
                justify-content: flex-start;
            }

            .footer-bottom {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .footer-policy {
                gap: 10px;
                font-size: 12px;
            }

            .copyright {
                font-size: 12px;
            }
        }
    

        /* ================================
           MOBILE NAVIGATION IMPROVEMENTS
           ================================ */
        .menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 6px;
            width: 44px;
            height: 44px;
            padding: 8px;
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 8px;
            background: rgba(0, 35, 38, .45);
            cursor: pointer;
            flex-shrink: 0;
        }

        .menu-toggle span {
            display: block;
            width: 25px;
            height: 3px;
            background: #e9aa6b;
            border-radius: 3px;
            transition: transform .25s ease, opacity .25s ease;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: translateY(9px) rotate(45deg);
        }
        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }
        .menu-toggle.active span:nth-child(3) {
            transform: translateY(-9px) rotate(-45deg);
        }

        @media (max-width: 820px) {
            .header {
                position: relative;
                width: 100%;
                padding: 10px 18px;
                min-height: 74px;
                gap: 12px;
                background: rgba(0, 45, 48, .2);
            }

            .logo { flex: 0 0 auto; }
            .img {
                width: 62px;
                height: 62px;
                object-fit: contain;
            }

            .menu-toggle { display: flex; }

            .navbar {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                width: 100%;
                max-height: calc(100dvh - 80px);
                overflow-y: auto;
                margin: 0;
                padding: 12px 20px 20px;
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                background: rgba(0, 43, 46, .98);
                border: 0;
                border-top: 1px solid rgba(255,255,255,.15);
                border-radius: 0 0 12px 12px;
                box-shadow: 0 12px 25px rgba(0,0,0,.25);
                z-index: 1100;
            }

            .navbar.open { display: flex; }

            .navbar > a,
            .navbar .product-menu > .product-link {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 14px 4px;
                color: #fff;
                border-bottom: 1px solid rgba(255,255,255,.14);
                font-size: 16px;
            }

            .navbar a::after { display: none; }
            .navbar a:hover,
            .navbar a.active { color: #e9aa6b; }
            .product-menu { width: 100%; }

            .product-popup,
            .product-popup1 {
                display: none;
                position: static;
                width: 100%;
                height: auto;
                margin: 0 0 8px;
                padding: 8px 12px;
                flex-direction: column;
                gap: 0;
                background: rgba(255,255,255,.08);
                border: 0;
                border-radius: 8px;
                box-shadow: none;
                opacity: 1;
                visibility: visible;
                transform: none;
            }

            .product-menu.mobile-open .product-popup,
            .product-menu.mobile-open .product-popup1 {
                display: flex;
            }

            .product-menu:hover .product-popup,
            .product-menu:hover .product-popup1 {
                opacity: 1;
                visibility: visible;
                transform: none;
            }

            .product-popup a,
            .product-popup1 a,
            .product-popup .feature a,
            .product-popup1 .feature a {
                width: 100%;
                margin: 0;
                padding: 11px 6px;
                color: #fff;
                font-size: 14px;
                border-bottom: 1px solid rgba(255,255,255,.1);
            }

            .product-popup .nano1,
            .product-popup .lite1,
            .product-popup1 .services {
                border-left: 0;
                padding-left: 0;
            }

            .product-popup1 .service > p,
            .product-popup1 .services > p {
                color: #e9aa6b;
                text-align: left;
                padding: 8px 6px 0;
            }

            .product-popup1 .feature { padding: 0; }
            .hero { padding: 55px 22px; }
            .hero h1 { font-size: clamp(32px, 8vw, 52px); }
            .hero p { font-size: clamp(17px, 4vw, 23px); }
        }

        @media (max-width: 480px) {
            .header { padding: 8px 14px; min-height: 68px; }
            .img { width: 54px; height: 54px; }
            .hero { padding: 42px 16px; gap: 12px; }
            .hero h1 { font-size: clamp(28px, 9vw, 40px); }
            .hero p { font-size: 16px; }
        }

    </style>
</head>
<body>
    <div class="page1">
        <img class="hero-img" src="background.png" alt="">
        <header class="header">
            <div class="logo">
                <img class="img" src="logo.png" alt="logo" onerror="this.style.background='var(--text)'">
            </div>

            <button class="menu-toggle" id="menuToggle" type="button" aria-label="Open navigation menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

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
                <div class="product-menu">
                    <a href="#services" class="product-link">Services <i class="fa-solid fa-chevron-down"></i></a>
                    <div class="product-popup1">
                        <div class="service">
                            <p> Technology Solutions </p>
                            <div class="feature">
                                <a href="software-development"> Software Development </a>
                                <a href="machine-learning"> AI & Machine Learning </a>
                            </div>
                        </div>
                        <div class="services">
                            <p> Design & Prototyping </p>
                            <div class="feature">
                                <a href="3d-printing"> 3D Printing </a>
                                <a href="cad-design"> 3D CAD Design </a>
                                <a href="r&d-services"> R&D Services </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <a href="/career">Career</a> -->
                <a href="/about">About</a>
            </nav>
            
        </header>
        <section class="hero">
            <h1 id="title1">Welcome To <br><span>LDTECS</span></h1>
            <div class="para">
                <p id="title2"> Technology. Engineering Tomorrow </p>
            </div>
        </section>    
    </div>

    <section class="page5">
        <div class="clients-section">
            <h2>Our Clients</h2>

            <div class="marquee">
                <div class="marquee-track">

                    <div class="marquee-group">
                        <img src="sevenstar.webp" alt="Seven Star">
                        <img src="tenx.png" alt="Tenx">
                        <img src="uni-design.png" alt="Uni Design">
                        <img src="shivaye.webp" alt="Shivaye">
                        <img src="mahavir.png" alt="Mahavir">
                        <img src="hare-krishana.svg" alt="Hari Krishna">
                    </div>

                    <div class="marquee-group" aria-hidden="true">
                        <img src="sevenstar.webp" alt="">
                        <img src="tenx.png" alt="">
                        <img src="uni-design.png" alt="">
                        <img src="shivaye.webp" alt="">
                        <img src="mahavir.png" alt="">
                        <img src="hare-krishana.svg" alt="">
                    </div>

                </div>
            </div>
        </div>
    </section>
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

    <!-- <section class="page3" id="services">
            
    </section> -->
    <div class="services-title" id="services">
        <h1>Our Services</h1>
    </div>
    <section class="services-section">
        <!-- LEFT COLUMN -->
        <div class="service-column">
            
            <div class="section-heading">
                <div class="heading-icon">&lt;/&gt;</div>
                <div>
                    <h2>Technology Solutions</h2>
                    <p>We build intelligent software and AI-driven systems to solve real-world problems and help businesses grow.</p>
                </div>
            </div>

            <!-- Software Development -->
            <div class="service-card software-card">
                <img
                    src="software2.avif"
                    alt="Software Development">

                <div class="card-content">
                    <h3>Software Development</h3>
                    <p>Custom software, modern web applications, APIs, and scalable digital solutions.</p>

                    <ul>
                        <li>Custom Software Development</li>
                        <li>Web Application Development</li>
                        <li>Frontend & Backend Development</li>
                        <li>Database & API Integration</li>
                        <li>Maintenance & Support</li>
                    </ul>

                    <a href="software-development" class="learn-btn">
                        Learn More <span>→</span>
                    </a>
                </div>
            </div>

            <!-- AI & Machine Learning -->
            <div class="service-card software-card">
                <img
                    src="ai3.avif"
                    alt="Artificial Intelligence">

                <div class="card-content">
                    <h3>AI & Machine Learning</h3>
                    <p>Intelligent systems, data analysis, image recognition and automation solutions.</p>

                    <ul>
                        <li>Machine Learning Models</li>
                        <li>Predictive Analytics</li>
                        <li>Computer Vision</li>
                        <li>AI-Powered Automation</li>
                        <li>Data Analysis & Integration</li>
                    </ul>

                    <a href="machine-learning" class="learn-btn">
                        Learn More <span>→</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="service-column design-column">

            <div class="section-heading">
                <div class="heading-icon cube-icon">◇</div>
                <div>
                    <h2>Design & Prototyping</h2>
                    <p>We turn your ideas into accurate designs and physical prototypes using modern tools and technologies.</p>
                </div>
            </div>

            <!-- 3D Printing -->
            <div class="service-card design-card">
                <img
                    src="3d image.png"
                    alt="3D Printing">

                <div class="card-content">
                    <h3>3D Printing</h3>
                    <p>Rapid prototyping and physical models developed from digital 3D designs.</p>

                    <ul>
                        <li>Rapid Prototyping</li>
                        <li>Custom Components</li>
                        <li>Design Verification</li>
                        <li>Product Model Printing</li>
                    </ul>

                    <a href="3d-printing" class="learn-btn">
                        Learn More <span>→</span>
                    </a>
                </div>
            </div>

            <!-- 3D CAD Design -->
            <div class="service-card design-card">
                <img
                    src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=500&q=80"
                    alt="3D CAD Design">

                <div class="card-content">
                    <h3>3D CAD Design</h3>
                    <p>Accurate 3D models, mechanical designs and technical drawings.</p>

                    <ul>
                        <li>3D Product Modeling</li>
                        <li>Mechanical Part Design</li>
                        <li>Assembly Design</li>
                        <li>Technical Drawings</li>
                    </ul>

                    <a href="cad-design" class="learn-btn">
                        Learn More <span>→</span>
                    </a>
                </div>
            </div>

            <!-- R&D Services -->
            <div class="service-card design-card">
                <img
                    src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=500&q=80"
                    alt="Research and Development">

                <div class="card-content">
                    <h3>R&D Services</h3>
                    <p>Feasibility studies, proof of concept, prototyping and technical validation.</p>

                    <ul>
                        <li>Concept Development</li>
                        <li>Proof of Concept (PoC)</li>
                        <li>Prototype Development</li>
                        <li>Testing & Validation</li>
                    </ul>

                    <a href="r&d-services" class="learn-btn">
                        Learn More <span>→</span>
                    </a>
                </div>
            </div>

        </div> 
    </section>
    
    <footer class="footer">

        <div class="footer-cta">
            <h1>Let's put our minds into motion,<br>
                Let's grow together</h1>
            <!-- <a href="#contact" class="contact-btn">GET IN TOUCH</a> -->
        </div>

        <div class="footer-container">

            <!-- Company Details -->
            <div class="footer-column company" id="footer-column">
                <h3>CORPORATE HEADQUARTERS:</h3>

                <p>
                    LDTECS<br>
                    
                </p>

                <p>
                    Surat<br>
                    395004, Gujarat, India
                </p>

                <p>
                    <!-- Phone : +91 261 2309900<br>
                    Email : contact@drcindia.in -->
                </p>
            </div>

            <!-- Quick Links -->
            <div class="footer-column quick-links" id="quick-links">
                <h3>QUICK LINK</h3>

                <a href="/">Home</a>
                <a href="#our-products">Our Product</a>
                <a href="/software-development"> Software Development Services </a>
                <a href="/machine-learning"> AI & Machine Learning Services </a>
                <a href="/3d-printing"> 3D Printing Services </a>
                <a href="/cad-design"> 3D CAD Design Services </a>
                <a href="/r&d-services">R&D Services</a>
                <!-- <a href="/career">Career</a> -->
                <a href="/about">About</a>
            </div>

            <!-- Contact -->
            <div class="footer-column contact" id="contect">
                <h3>CONTACT US</h3>

                <h4>SALES INQUIRY</h4>
                <p>
                    <!-- Phone : +91 9909990884<br> -->
                    Email : info@ldtecs.com
                </p>

                <!-- <h4>24 * 7 SUPPORT</h4>
                <p>Email : support@drcindia.in</p> -->

                <h4>FOLLOW US</h4>

                <div class="social-icons">
                    <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

        </div>

        <!-- Bottom Footer -->
        <div class="footer-bottom">

            <div class="footer-policy">
                <a href="#privacy">Privacy Policy</a>
                <span>-</span>
                <a href="#terms">Terms and Conditions</a>
                <a href="/contact">Contact Us</a>
            </div>

            <p class="copyright">
                © 2026 ldtecs INDIA. All rights reserved.
            </p>

            <!-- <div class="certificates">
                <div class="certificate">ISO 9001<br><small>ISOQAR</small></div>
                <div class="certificate">✓<br><small>MANAGEMENT<br>SYSTEMS</small></div>
            </div> -->

        </div>

    </footer>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/ScrollTrigger.min.js"></script>

    <script>
        gsap.registerPlugin(ScrollTrigger);
    </script>

    <script src="{{ asset('script.js') }}"></script>
    
    <script>
        const toggle = document.getElementById('menuToggle');
        const navbar = document.getElementById('navbar');
        const productMenus = document.querySelectorAll('.product-menu');

        if (toggle && navbar) {
            toggle.addEventListener('click', () => {
                const isOpen = navbar.classList.toggle('open');
                toggle.classList.toggle('active', isOpen);
                toggle.setAttribute('aria-expanded', String(isOpen));
                toggle.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
            });

            productMenus.forEach(menu => {
                const link = menu.querySelector(':scope > .product-link');
                if (!link) return;
                link.addEventListener('click', event => {
                    if (window.innerWidth <= 820) {
                        event.preventDefault();
                        const wasOpen = menu.classList.contains('mobile-open');
                        productMenus.forEach(other => other.classList.remove('mobile-open'));
                        if (!wasOpen) menu.classList.add('mobile-open');
                    }
                });
            });

            navbar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    const parentMenu = link.closest('.product-menu');
                    const isDropdownHeading = parentMenu && link.classList.contains('product-link');
                    if (window.innerWidth <= 820 && !isDropdownHeading) {
                        navbar.classList.remove('open');
                        toggle.classList.remove('active');
                        toggle.setAttribute('aria-expanded', 'false');
                        toggle.setAttribute('aria-label', 'Open navigation menu');
                        productMenus.forEach(menu => menu.classList.remove('mobile-open'));
                    }
                });
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth > 820) {
                    navbar.classList.remove('open');
                    toggle.classList.remove('active');
                    toggle.setAttribute('aria-expanded', 'false');
                    productMenus.forEach(menu => menu.classList.remove('mobile-open'));
                }
            });
        }
    </script>
</body>
</html>