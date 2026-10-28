<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LDTECS</title>

    <link rel="icon" type="image/png"
        href="{{ asset('logo.png') }}?v=12">
    <link rel="shortcut icon"
        href="{{ asset('logo.png') }}?v=12">
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

        html, body {
            touch-action: auto;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            text-align: center;
            /* background: #F1F5FD; */
            color: var(--text);
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            width: 100%;
            display: flex;
            flex-direction: column;
        }
        .page{
            width:100%;
        }


        .header {
            position: sticky;
            margin-top:0px;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 30px 50px;
            border-bottom: 1px solid var(--bg-1);
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
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            margin-left: 12px;
            letter-spacing: 0.5px;
        }

        .navbar {
            display: flex;
            align-items: center;
            gap: 60px;
            margin-right:50px;
        }

        .navbar a {
            position: relative;
            text-decoration: none;
            font-size: 15px;
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
            background: #a1e1eb;
            border-radius: 2px;
            transition: width 0.25s ease;
        }

        .navbar a:hover {
            color: #a1e1eb;
        }

        .navbar a:hover::after,
        .navbar a.active::after {
            width: 100%;
        }

        .navbar a.active {
            color: #a1e1eb;
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
            flex: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 18px;
            width:100%;
            padding: 20px 24px 24px;
            text-align: center;
        }

        .hero h1 {
            font-size: 50px;
            color: #000000;
            max-width: 700px;
            line-height: 1.3;
            text-align: center;
            margin: 0;
        }

        .hero p {
            font-size: 16px;
            color: #e9aa6b;
            max-width: 520px;
            text-align: center;
            margin: 0;
        }
        .hero-img{
            width: 100%;
            height: 100%;
            max-width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
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
            .product-menu1 {
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

            .product-menu:hover .product-popup {
                transform: none;
            }

            .product-menu1:hover .product-popup1 {
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

        .product-menu .product-menu1{
            position:none;
        }

        .product-link{
            text-decoration:none;
            color: #222;
            padding:20px;
            display:block;
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
            top: calc(60% + 12px);
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
            transform: translate(-60%, 10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
            z-index: 1000;
            display:flex;
            justify-content:space-between;    
        }
        .devlopment{
            display:grid;
            padding-top:20px;
            text-align: center;
            line-height:1.7;
        }
        .devlopment a{
            font-size:16px;
            font-weight: 600;
        }
        .development a.active{
            background: #173237;
            color: #fff;
            border-radius: 8px;
            padding-left:20px;
            padding-right:20px;
        }

        .service a,
        .services a{
            margin-bottom:5px;   
        }

        .service p{
            padding-right:70px;
        }

        .services{
            text-align: left;
            padding-left: 60px;
            border-left: 2px solid gray;
        }

        .services p{
            padding-right:20px;
        }

        /*cursor pointer*/
        .product-menu:hover .product-popup {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, 0);
        }

        .product-menu1:hover .product-popup1 {
            opacity: 1;
            visibility: visible;
            transform: translate(-50%, 0);
        }
        .product-popup1 a{
            /* margin: 12px 18px; */
            display:flex;
            /* padding: 12px 18px; */
            color:#222;
            text-decoration:none;
            transition: 0.3s;
            font-weight:900px;
            font-size:16px;
        }

        .product-popup a{
            margin: 12px 18px;
            display:block;
            padding: 12px 18px;
            color:#222;
            text-decoration:none;
            transition: 0.3s;
        }

        /* .nano1, .lite1 {
            padding: 0 20px;
            border-left: 2px solid gray;
        }

        .product-popup a:hover{
            background:#f1f7f7;
            color:#e9aa6b;
        } */
        .product-popup1 a:hover{
            background: #173237;
            color: #fff;
            padding-left:20px;
            padding-right:20px;
            border-radius:8px;
        }

        /* ====================================
            page
        */
        .page{
            width:100%;
            min-height:80vh;
            position: relative;
        }
        .about{
            text-align:left;
            color:#000;
            padding-top:30px;
            padding-left:70px;
            line-height:1.5;
        }

        .h1{
            font-size:27px;
            font-weight:700;
            color:rgb(24, 112, 228);
        }

        .tech{
            color: #000000;
            font-size:25px;
            font-weight:500;
            text-align:left;
        }
        .hero-img1{
            width: 100%;
            height: 100%;
            max-width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }
        .description{
            font-size:18px;
            font-weight:400;
            padding-top:30px;
        }

        /* ====================================
            page3
        ==================================== */

        .page3 {
            width: 100%;
            min-height:80vh;
            padding-left:70px;
            padding-right:110px;
            padding-top:80px;
            background-color: #f1f4fd;

            text-align: center;
            overflow: none;
        }

        .build{
            text-align:left;
            font-weight:400;
        }
        
        .build h2{
            color: #4495bb;
            line-height:1.5;
            font-size:20px;
            font-weight:500;
        }

        .build p{
            padding-top:20px;
            font-size:18px;
            line-height:1.5;
        }
        .paragraph{
            padding-right:50px;
        }
        .products-container1 {
            width: 100%;
            max-width: 1200px;
            min-height:400px;
            display: flex;
            gap: 20px;
            align-items: stretch;
        }

        .product-titl{
            display:flex;
        }

        /* ====================================
            page1
        ==================================== */


        .page1{
            width:100%;
            min-height:100vh;
        }
        .heading{
            font-size:30px;
            padding-top:30px;
        }

        .box1{
            width:100%;
            max-width:1200px;
            margin:0 auto;
            padding:20px 24px 0;
            line-height:1.5;
            font-size:20px;
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            align-items:center;
            gap:40px;
            text-align:left;
        }
        .product-card1 {
            width:100%;
            min-height:360px;

            background: #ffffff;

            border: 2px solid #111;

            border-radius: 20px;

            /* padding: 30px 20px 25px; */
            margin:50px 0;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;

            /* transition:
                transform 1.0s ease,
                box-shadow 1.0s ease,
                border-color 0.4s ease; */
        }

        /* .product-card1:hover {
            transform: translateY(-10px);
            box-shadow:0 20px 45px rgba(0, 0, 0, 0.15);
            border-color: #24a19c;
        } */

        .product-card1:hover .product-image {
            transform: scale(1.10);
            filter: brightness(1.03);
        }

        .product-image.soft {
            width:120%;
            max-width:120%;
            max-height:500px;
            object-fit: contain;
            /* margin:20px 0; */

        }

        /* =========================================
        PRODUCTS CONTAINER
        ========================================= */

        .page2 {
            width: 100%;
            min-height: 100vh;
            padding: 50px 35px 50px;
            background-color: #fff;

            text-align: center;
            overflow: hidden;
        }

        .products-container {

            width: 100%;
            max-width: 1400px;
            min-height:200px;
            margin: 50px auto;
            display: grid;
            
            grid-template-columns: repeat(5, 1fr);

            gap: 0px;

            align-items: stretch;
        }


        /* =========================================
        PRODUCT CARD
        ========================================= */

        .product-card {

            width: 100%;
            min-height: 200px;

            background: #f1f5fd;

            /* border-left: 2px solid #9c9797; */

            /* border-radius: 20px; */

            /* padding: 20px 10px 15px; */

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: space-between;

            overflow: hidden;
            position: relative;
            
            /* transition:
                transform 0.4s ease,
                box-shadow 0.4s ease,
                border-color 0.4s ease; */
        }

        .heading1{
            padding-left:50px;
            text-align:left;
            padding-top:30px;
        }

        .heading1 h6,h5{
            font-size:18px;
            font-weight:600;
            color: #529fcc;
        }

        .heading1 h1{
            font-size:40px;
            font-weight:700;
        }


        /* =========================================
        CARD HOVER
        ========================================= */

        /* .product-card:hover {

            transform: translateY(-10px);

            box-shadow:
                0 20px 45px rgba(0, 0, 0, 0.15);

            border-color: #24a19c;
        } */


        /* =========================================
        IMAGE LINK
        ========================================= */

        /* .product-image-link {

            width: 100%;
            height: 390px;

            display: flex;

            align-items: center;
            justify-content: center;

            text-decoration: none;

            overflow: hidden;

            border-radius: 12px;
        } */


        /* =========================================
        PRODUCT IMAGE
        ========================================= */

        .product-image {

            width: 100%;
            height: 100%;
            margin-top:-30px;
            margin-bottom:-30px;
            object-fit: contain;

            display: block;

            /* cursor: pointer; */

            transform: scale(1);

            transition:
                transform 1.0s ease,
                filter 0.5s ease;
        }
        


        /* =========================================
        IMAGE HOVER ZOOM
        ========================================= */

        /* .product-card:hover .product-image {

            transform: scale(1.10);

            filter: brightness(1.03);
        } */


        /* =========================================
        INDIVIDUAL IMAGE SIZE
        ========================================= */

        .product-image.custom {
            width: 100%;
            max-width:1000px;
            height: 90%;
            object-fit: contain;
        }
        .product-image.custom1 {
            width: 90%;
            max-width:800px;
            height: 60%;
            object-fit: contain;
        }
        .diem p{
            font-size:17px;
            font-weight:400;
            padding-bottom:30px;
            padding-left:20px;
        }
        .customh4{
            padding-top:-20px;
        }


        /* ============================================
            Page3
        ============================================*/

        /* .page3{
            width:100%;
            min-height:80vh;
        } */

        .product-image.soft1 {
            width:130%;
            max-width:130%;
            max-height:500px;
            object-fit: contain;
            /* margin:20px 0; */

        }

        
        /* ============================================
            Page4
        ============================================*/

        /* .page4{
           width:100%;
           min-height:70vh;
           position: relative;
        }

        .vision-img{
            width: 100%;
            max-height: 40vh;
            max-width: 100%;
            position: relative;
            top: 0;
            left: 0;
            
            z-index: -1;
        }

        .our-content{
            display:flex;
            
        } */

        .vision-mission {
            position: relative;
            width: 100%;
            min-height: 350px;
            background-image: url("our-vision.png");
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            padding: 40px 5%;
            overflow: hidden;
        }

        /* Light overlay */
        .vision-mission::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(235, 247, 255, 0.78);
        }

        /* Content wrapper */
        .content-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* Individual sections */
        .content-box {
            display: flex;
            gap: 20px;
            padding: 50px 40px;
        }

        .content-box:first-child {
            border-right: 2px solid rgba(28, 77, 115, 0.2);
        }

        .icon {
            display:flex;
            font-size: 42px;
            color: #174d78;
            flex-shrink: 0;
            gap:20px;
        }

        .content h2 {
            padding-left:-50px;
            font-size: 27px;
            color: #173e60;
            margin-bottom: 20px;
        }

        .content p {
            text-align:left;
            padding-left:50px;
            font-size: 16px;
            line-height: 1.8;
            color: #253e52;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }

            .content-box {
                padding: 25px 10px;
            }

            .content-box:first-child {
                border-right: none;
                border-bottom: 2px solid rgba(28, 77, 115, 0.2);
            }

            .content h2 {
                font-size: 23px;
            }

            .content p {
                font-size: 14px;
            }

            .icon {
                font-size: 32px;
            }
        }
        
        @media (max-width: 1000px) {

            .page2,
            .page1,
            .page {

                padding: d 25px;
            }


            .products-container,
            .products-container1,
            .box1 {

                grid-template-columns: repeat(2, 1fr);

                gap: 20px;
            }

            .product-card
            .product-card1 {

                min-height: 600px;
            }

            .product-image.soft,
            .product-image.custom {

                height: 250px;
            }

        }


        /* =========================================
        MOBILE
        ========================================= */

        @media (max-width: 700px) {

            .page2,
            .page1,
            .page {

                padding: 45px 15px 60px;
            }

            .products-title,
            .products-titl {

                margin-bottom: 35px;

                font-size: 38px;
            }

            .products-container,
            .products-container1,
            .box1 {

                grid-template-columns: 1fr;

                gap: 25px;

                max-width: 500px;
            }

            .product-card,
            .product-card1 {

                min-height: 580px;

                padding: 25px 15px;
            }

            .product-image.soft,
            .product-image.custom {

                height: 250px;
            }

            .product-image {

                width: 90%;
            }

            .diem p {

                font-size: 20px;
            }

        }


        /* =========================================
        SMALL MOBILE
        ========================================= */

        @media (max-width: 450px) {

            .page2,
            .page1,
            .page{

                padding: 35px 10px 50px;
            }

            .products-title,
            .products-titl {

                font-size: 32px;
            }

            .product-card,
            .product-card1 {

                min-height: 520px;

                border-radius: 15px;
            }

            .product-image.soft,
            .product-image.custom{

                height: 300px;
            }

            .diem p {

                font-size: 20px;

                /* letter-spacing: 4px; */
            }

            .diem p {

                font-size: 16px;

                /* letter-spacing: 4px; */
            }

            .diem,
            .description p {

                font-size: 16px;
            }

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


         /* ========================================== 
        font-awesome
        =============================================*/

        .fa-hexagon-nodes,
        .fa-lightbulb,
        .fa-wrench,
        .fa-shield,
        .fa-handshake{
            padding-top:30px;
            font-size:52px;
            color:#174d78;
        }
        
        .product-card2 {

            width: 100%;
            min-height: 100px;

            background: #f1f5fd;

            /* border-left: 2px solid #9c9797; */

            /* border-radius: 20px; */

            /* padding: 20px 10px 15px; */

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: space-between;

            overflow: hidden;
            position: relative;
            
            /* transition:
                transform 0.4s ease,
                box-shadow 0.4s ease,
                border-color 0.4s ease; */
        }

        .customh5{
            padding-top:20px;
            padding-bottom:20px;
        }


        .product-card2:not(:last-child) {
            border-right: 2px solid rgba(28, 77, 115, 0.2);
        }

        .diem1 p{
            font-size:17px;
            font-weight:400;
            padding-bottom:30px;
            padding-left:20px;
            padding-right:20px;
        }

                
        /* ==========================================
        Footer Mission - Main CSS
        ========================================== */

        .footer-mission {
            position: relative;
            width: 100%;
            min-height: 350px;
            background-image: url("footer.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            padding: 40px 5%;
            overflow: hidden;
        }

        /* Light Overlay */
        .footer-mission::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(235, 247, 255, 0.78);
            z-index: 0;
        }

        /* Content Wrapper */
        .content-footer {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1700px;
            padding-left: 500px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        /* Individual Sections */
        .content-box1 {
            display: flex;
            gap: 20px;
            min-width: 0;
            padding: 50px 40px;
        }

        .content-box1:first-child {
            border-right: 2px solid rgba(28, 77, 115, 0.2);
        }

        /* Content Headings */
        .content1 {
            min-width: 0;
        }

        .content1 h2 {
            padding-left: 50px;
            font-size: 27px;
            color: #173e60;
            margin-bottom: 20px;
        }

        .content1 h4 {
            padding-left: 50px;
            font-size: 20px;
            color: #fff;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .content1 p {
            text-align: left;
            padding-left: 50px;
            font-size: 19px;
            line-height: 1.8;
            color: #000;
            overflow-wrap: anywhere;
        }

        /* Submit Button */
        .submit {
            margin-top: 30px;
        }

        .submit-btn {
            color: #fff;
            background: #3095dd;
            padding: 10px 20px;
            font-size: 20px;
            font-weight: 600;
            border: 2px solid #3095dd;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .submit-btn:hover {
            border-color: rgb(17, 47, 84);
            background: rgb(17, 47, 84);
        }

        /* Page 6 */
        .page6 {
            width: 100%;
            min-height: 80vh;
            background-color: #fff;
            text-align: center;
            overflow: hidden;
        }


        /* ==========================================
        Tablet Responsive - 768px
        ========================================== */

        @media (max-width: 768px) {

            .footer-mission {
                min-height: auto;
                padding: 30px 20px;
                background-position: center;
            }

            .content-footer {
                max-width: 100%;
                padding-left: 0;
                grid-template-columns: 1fr;
            }

            .content-box1 {
                gap: 15px;
                padding: 30px 20px;
            }

            .content-box1:first-child {
                border-right: none;
                border-bottom: 2px solid rgba(28, 77, 115, 0.2);
            }

            .content1 h2 {
                padding-left: 0;
                font-size: 23px;
                margin-bottom: 15px;
            }

            .content1 h4 {
                padding-left: 0;
                font-size: 18px;
                margin-bottom: 15px;
            }

            .content1 p {
                padding-left: 0;
                font-size: 16px;
                line-height: 1.7;
            }

            .submit {
                margin-top: 20px;
            }

            .submit-btn {
                padding: 10px 18px;
                font-size: 17px;
            }

            .page6 {
                min-height: auto;
                padding: 30px 15px;
            }
        }


        /* ==========================================
        Mobile Responsive - 480px
        ========================================== */

        @media (max-width: 480px) {

            .footer-mission {
                width: 100%;
                min-height: auto;
                padding: 20px 12px;
                background-size: cover;
                background-position: center;
            }

            .footer-mission::before {
                background: rgba(235, 247, 255, 0.85);
            }

            .content-footer {
                width: 100%;
                padding-left: 0;
                margin: 0 auto;
                grid-template-columns: minmax(0, 1fr);
            }

            .content-box1 {
                width: 100%;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                gap: 10px;
                padding: 22px 12px;
            }

            .content-box1:first-child {
                border-right: none;
                border-bottom: 1px solid rgba(28, 77, 115, 0.25);
            }

            .content1 {
                width: 100%;
            }

            .content1 h2 {
                padding-left: 0;
                font-size: 21px;
                line-height: 1.4;
                margin-top: 0;
                margin-bottom: 12px;
            }

            .content1 h4 {
                padding-left: 0;
                font-size: 16px;
                line-height: 1.5;
                margin-bottom: 12px;
            }

            .content1 p {
                padding-left: 0;
                font-size: 14px;
                line-height: 1.7;
                text-align: left;
                margin-bottom: 12px;
            }

            .submit {
                margin-top: 18px;
            }

            .submit-btn {
                max-width: 100%;
                padding: 10px 16px;
                font-size: 15px;
                border-radius: 8px;
            }

            .page6 {
                width: 100%;
                min-height: auto;
                padding: 25px 12px;
                box-sizing: border-box;
            }
        }


        /* ==========================================
        Extra Small Mobile - 360px
        ========================================== */

        @media (max-width: 360px) {

            .footer-mission {
                padding: 15px 8px;
            }

            .content-box1 {
                padding: 18px 8px;
            }

            .content1 h2 {
                font-size: 19px;
            }

            .content1 h4 {
                font-size: 15px;
            }

            .content1 p {
                font-size: 13px;
                line-height: 1.6;
            }

            .submit-btn {
                padding: 9px 13px;
                font-size: 14px;
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

        @media (max-width: 820px) {
            .header {
                position: fixed;
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
            .product-popup .elite,
            .product-popup .lite1,
            .product-popup1 .services {
                border-left: 0;
                padding-left: 0;
                text-align:left;
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



        /* Mobile navbar and hamburger menu */
        .header {
            position: sticky;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
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
            .header { z-index: 1200; }

            .menu-toggle { display: flex; flex-shrink: 0; }
            
            .navbar {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                width: 100%;
                max-height: calc(100vh - 75px);
                overflow-y: auto;
                margin: 0;
                padding: 12px 20px 20px;
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                background: #063b3e;
                border: 1px solid rgba(255,255,255,.15);
                border-radius: 0 0 12px 12px;
                box-shadow: 0 12px 25px rgba(0,0,0,.25);
                z-index: 1200;
            }
            .navbar.open { display: flex; }
            .navbar > a,
            .navbar .product-menu > a,
            .navbar .product-menu1 > a {
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
            .product-menu, .product-menu1 { position: static; width: 100%; }
            .product-popup, .product-popup1 {
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
            .product-menu1.mobile-open .product-popup1 { display: flex; }
            .product-menu:hover .product-popup,
            .product-menu1:hover .product-popup1 { opacity: 1; visibility: visible; transform: none; }
            .product-popup a, .product-popup1 a {
                display: block;
                width: 100%;
                margin: 0;
                padding: 11px 6px;
                color: #fff;
                font-size: 14px;
                border-bottom: 1px solid rgba(255,255,255,.1);
                            border-bottom: 1px solid rgba(255,255,255,.1);
            }
        }

        
        /* ================================
        TABLET RESPONSIVE (768px–1024px)
        ================================ */
        @media screen and (min-width: 768px) and (max-width: 1024px) {

            .page3 {
                padding: 50px 35px;
                height: auto;
                min-height: auto;
                box-sizing: border-box;
            }

            .page3 .product-titl {
                display: grid;
                grid-template-columns: 1.1fr 0.9fr;
                align-items: start;
                gap: 30px;
                width: 100%;
            }

            .page3 .build {
                width: 100%;
                min-width: 0;
            }

            .page3 .build h2 {
                font-size: 25px;
                margin-bottom: 10px;
            }

            .page3 .build h1 {
                font-size: 34px;
                line-height: 1.3;
                margin-bottom: 20px;
            }

            .page3 .paragraph p {
                font-size: 17px;
                line-height: 1.7;
                margin-bottom: 18px;
            }

            .page3 .products-container1 {
                width: 100%;
                height: auto;
                min-width: 0;
            }

            .page3 .products-container1 img {
                width: 100%;
                height: auto;
                max-height: 360px;
                object-fit: cover;
                display: block;
            }
        }


        /* ================================
        MOBILE RESPONSIVE (max 767px)
        ================================ */
        @media screen and (max-width: 767px) {

            .page3 {
                width: 100%;
                height: auto;
                min-height: auto;
                padding: 35px 20px;
                box-sizing: border-box;
                overflow: hidden;
            }

            .page3 .product-titl {
                display: flex;
                flex-direction: column;
                align-items: stretch;
                gap: 25px;
                width: 100%;
            }

            .page3 .build {
                width: 100%;
                max-width: 100%;
                box-sizing: border-box;
            }

            .page3 .build h2 {
                font-size: 21px;
                line-height: 1.4;
                margin: 0 0 8px;
            }

            .page3 .build h1 {
                font-size: 29px;
                line-height: 1.3;
                margin: 0 0 18px;
                overflow-wrap: break-word;
            }

            .page3 .paragraph {
                width: 100%;
            }

            .page3 .paragraph p {
                font-size: 16px;
                line-height: 1.7;
                margin: 0 0 16px;
            }

            .page3 .products-container1 {
                width: 100%;
                max-width: 100%;
                height: auto;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .page3 .products-container1 img {
                display: block;
                width: 100%;
                height: auto;
                max-height: 300px;
                object-fit: contain;
                object-position: center;
                margin: 0 auto;
            }
        }


        /* ================================
        SMALL MOBILE (max 380px)
        ================================ */
        @media screen and (max-width: 380px) {

            .page3 {
                padding: 28px 15px;
            }

            .page3 .build h2 {
                font-size: 19px;
            }

            .page3 .build h1 {
                font-size: 25px;
            }

            .page3 .paragraph p {
                font-size: 15px;
                line-height: 1.65;
            }

            .page3 .products-container1 img {
                max-height: 240px;
            }
        }

        /* Parent Products dropdown */
        .product-menu {
            position: relative;
        }

        .product-popup {
            position: absolute;
            top: calc(100% + 15px);
            left: 50%;
            transform: translateX(-60%);
            width: 270px;
            background: #fff;
            border-radius: 9px;
            border: 1px solid #e5e5e5;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            overflow: visible;
            z-index: 9999;
        }

        /* Diamond Detectors row */
        .diamond-menu {
            position: relative;
            width: 100%;
        }

        .diamond-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 22px;
            background: #fff;
            border: none;
            border-radius: 9px;
            color: #191b19;
            font-size: 16px;
            font-weight: 600;
            text-align: left;
            cursor: pointer;
        }

        .diamond-btn:hover {
            background: #173237;
            color: #fff;
        }

        .diamond-btn i {
            font-size: 13px;
            transition: transform 0.2s ease;
        }

        .diamond-btn.active i {
            transform: rotate(90deg);
        }

        /* Separate right-side submenu */
        .diamond-side-popup {
            position: absolute;
            top: 0;
            left: calc(100% + 10px);
            width: 260px;
            padding: 8px;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 9px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            display: none;
            z-index: 10000;
        }

        .diamond-side-popup.show {
            display: block;
        }

        .diamond-side-popup a {
            display: block;
            padding: 15px 14px;
            color: #191b19;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            border-bottom: 1px solid #eee;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .diamond-side-popup a.active{
            background: #173237;
            color: #fff;
            border-radius: 8px;
        }

        .active button.diamond-btn{
            background: #173237;
            color: #fff;
        }

        .diamond-side-popup a:last-child {
            border-bottom: none;
        }

        .diamond-side-popup a:hover {
            background: #173237;
            color: #fff;
            border-radius: 8px;
        }

        /* Tablet */
        @media (min-width: 821px) and (max-width: 1100px) {
            .product-popup {
                width: 310px;
            }

            .diamond-side-popup {
                width: 230px;
            }
        }

        /* Mobile */
        @media (max-width: 820px) {
            .product-menu {
                position: relative;
            }

            .product-popup {
                position: static;
                transform: none;
                width: 100%;
                max-width: 100%;
                margin-top: 8px;
                box-shadow: none;
                border: 1px solid #e5e5e5;
                border-radius: 8px;
                box-sizing: border-box;
            }

            .diamond-btn {
                padding: 15px 16px;
                font-size: 15px;
            }

            /* Mobile: submenu opens below Diamond Detectors */
            .diamond-side-popup {
                position: static;
                width: auto;
                margin: 0 10px 10px;
                padding: 4px;
                box-shadow: none;
                border-radius: 6px;
                background: #f8f9f9;
                box-sizing: border-box;
            }

            .diamond-side-popup a {
                padding: 14px 12px;
                font-size: 13px;
            }

            .diamond-btn.active i {
                transform: rotate(90deg);
            }
        }

        /* Small mobile */
        @media (max-width: 480px) {
            .product-popup {
                margin-top: 6px;
            }

            .diamond-btn {
                padding: 14px 12px;
                font-size: 14px;
            }

            .diamond-side-popup {
                margin-left: 8px;
                margin-right: 8px;
            }

            .diamond-side-popup a {
                padding: 13px 10px;
                font-size: 12px;
            }
        }
    
        /* Contact Button */

        .contact-btn {
            background: transparent;
            color: white;
            border: 1px solid white;
            padding: 9px 18px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .contact-btn:hover {
            background: #a1e1eb;
            color: #111;
            border-color: #a1e1eb;
        }

        /* Popup Background */
        .contact-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(5px);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Popup Box */
        .contact-box {
            position: relative;
            background: #102b2d;
            color: white;
            width: 100%;
            max-width: 450px;
            padding: 35px;
            border-radius: 12px;
            border: 1px solid rgba(102, 211, 213, 0.5);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
            animation: popupOpen 0.3s ease;
        }

        .contact-box h2 {
            color: #a1e1eb;
            margin: 0 0 10px;
            font-size: 28px;
        }

        .contact-box p {
            color: #ccc;
            margin-bottom: 22px;
        }

        .contact-box input,
        .contact-box textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 14px;
            background: #19383a;
            border: 1px solid #496263;
            border-radius: 5px;
            color: white;
            font-size: 15px;
            box-sizing: border-box;
            outline: none;
        }

        .contact-box input:focus,
        .contact-box textarea:focus {
            border-color: #a1e1eb;
        }

        .contact-box input::placeholder,
        .contact-box textarea::placeholder {
            color: #bbb;
        }

        .contact-box textarea {
            resize: vertical;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 16px;
            background: transparent;
            border: none;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #a1e1eb;
        }

        .submit-btn {
            width: 100%;
            padding: 13px;
            background: #61cfe0d2;
            color: #111;
            font-weight: bold;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background: white;
        }

        @keyframes popupOpen {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .contact-box {
                padding: 28px 20px;
            }

            .contact-box h2 {
                font-size: 24px;
            }
        }


</style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img class="hero-img" src="header.png" alt="back">
            <img class="img" src="logo.png" alt="logo" onerror="this.style.background='var(--text)'">
        </div>

        <button class="menu-toggle" id="menuToggle" type="button" aria-label="Open navigation menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="navbar" id="navbar">
            <a href="/">Home</a>
            <div class="product-menu">
                <a href="#our-products">
                    Products <i class="fa-solid fa-chevron-down"></i>
                </a>

                <div class="product-popup">
                    <div class="diamond-menu">
                        <button type="button" class="diamond-btn">
                            Diamond Detectors
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>

                        <div class="diamond-side-popup">
                            <a href="/elite">CLASSIFIER ELITE</a>
                            <a href="/lite">CLASSIFIER LITE</a>
                            <a href="/nano">CLASSIFIER NANO</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-menu1">
                <a href="#services">Services <i class="fa-solid fa-chevron-down"></i></a>
                <div class="product-popup1">
                    <div class="service">
                        <p> Technology Solutions </p>
                        <div class="devlopment">
                            <a href="software-development" > Software Development </a>
                            <a href="#machine-learning" > AI & Machine Learning </a>
                        </div>
                    </div>
                    <div class="services">
                        <p> Design & Prototyping </p>
                        <div class="devlopment">
                            <a href="3d-printing"> 3D Printing </a>
                            <a href="cad-design"> 3D CAD Design </a>
                            <a href="r&d-services"> R&D Services </a>
                        </div>
                    </div>    
                </div>
            </div>
            <!-- <a href="/career">Career</a> -->
            <a href="/about" class="active">About</a>
            <button class="contact-btn" id="openContact">Contact</button>
        </nav>
    </header>

    <section class="page">
        <div class="logo1">
            <img class="hero-img1" src="about3.png" alt="back">
        </div>
        <div class="about" id="desc">
            <div class="heading" id="soft">
                <h1 class="h1"> About Us </h1>
                <h1> LDTECS </h1>
                <p class="tech"> Technology. Engineering Tomorrow <p>
            </div>
            <div class="description">
                <p>We are an India-based technology and engineering company focused on <br>developing innovative, 
                    reliable, and practical solutions for modern industries. <br>From advanced diamond detection 
                    systems to customized software and product <br>engineering, we transform ideas into technology 
                    that delivers real-world value. 
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Popup -->
    
    <div class="contact-overlay" id="contactPopup">
        <div class="contact-box">
            <button type="button" class="close-btn" id="closecontact">&times;</button>

            <h2>Contact Us</h2>
            <p>Let's discuss your project and ideas.</p>

            <form id="contactForm">
                <input type="text" id="name" name="name" placeholder="Your Name" required>

                <input type="email" id="email" name="email" placeholder="Your Email" required>

                <input type="tel" id="phone" name="phone" placeholder="Phone Number" required>

                <textarea id="message" name="message" placeholder="Your Message" rows="4" required></textarea>

                <button type="submit" class="submit-btn">
                    Send Message
                </button>
            </form>
        </div>
    </div>


    <section class="page3" id="product-about">
        <div class="product-titl">
            <div class="build" id="build">
                <h2> Who We Are </h2>
                <h1> Building Solutions <br>Through Technology </h1>
                <div class="paragraph">
                    <p>LDTECS brings together technology, software, and engineering to create products and solutions 
                        designed around real industry needs.
                    </p> 
                    <p>Our expertise spans advanced HPHT and CVD diamond detection 
                        systems, software development, product design, prototyping, and customized manufacturing. We 
                        focus on combining technical knowledge with practical applications to help businesses improve
                        efficiency, reliability, and innovation. 
                    </p>
                </div>
            </div>
            <div class="products-container1" id="product-cont">
                <img class="product-image custom" src="ldtecs.png" alt="LDTECS COMPANY" id="zoomLite">
            </div>
        </div>
    </section>

    <section class="page5">
        <div class="clients-section">
            <h2>Our Clients</h2>

            <div class="marquee">
                <div class="marquee-track">

                    <div class="marquee-group">
                        <img src="seven.png" alt="Seven Star">
                        <img src="tenx.png" alt="Tenx">
                        <img src="uni-design.png" alt="Uni Design">
                        <img src="mahavir.png" alt="Mahavir">
                        <img src="shivaye.png" alt="shivaye Diamonds">
                        <img src="hare-krishana.svg" alt="Hari Krishna">
                        <img src="mahindra.png" alt="Mahindra Diamonds">
                        <img src="manisha gems.webp" alt="Manisha Gems">
                        <img src="nature.png" alt="Nature's Art LTD.">
                    </div>

                    <div class="marquee-group" aria-hidden="true">
                        <img src="seven.png" alt="">
                        <img src="tenx.png" alt="">
                        <img src="uni-design.png" alt="">
                        <img src="mahavir.png" alt="">
                        <img src="shivaye.png" alt="">
                        <img src="hare-krishana.svg" alt="">
                        <img src="mahindra.png" alt="">
                        <img src="manisha gems.webp" alt=""> 
                        <img src="nature.png" alt="">
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="page2">
        <div class="product-title">
            <div class="heading1" id="our">
                <h6> OUR CAPABILITIES </h6>
                <h1> What We Do </h1>
            </div>
            <div class="products-container" id="diamond">

                <div class="box1 product-card">
                    <h4 class="customh4"> Diamond Detection Technology </h4>
                    <img class="product-image custom" src="diamond scan1.png" alt="Diamond Detection">

                    <div class="diem">
                        <p> Advanced HPHT & CVD Diamond detection and classification systems for labs, traders, jewellery
                            manufacturers and industry professionals. </p>
                    </div>

                </div>

                <div class="box1 product-card">
                    <h4 class="customh4"> Software Devlopment </h4>
                    <img class="product-image custom" src="software1.png" alt="Software Devlopment">

                    <div class="diem">
                        <p> customized software applications, automation solutions and technology-driven tools 
                            tailored to business requirements. </p>
                    </div>

                </div>

                <div class="box1 product-card">
                    <h4 class="customh4"> Product Design & Engineering </h4>
                    <img class="product-image custom" src="product-design.png" alt="Product Design">

                    <div class="diem">
                        <p> Turning ideas into functional products through product devlopment, prototyping and engineering design. </p>
                    </div>

                </div>
                <div class="box1 product-card">
                    <h4 class="customh4"> 3D Printing & Prototyping </h4>
                    <img class="product-image custom1" src="3d image.png" alt="Custom Devlopment" id="zoomImage">

                    <div class="diem">
                        <p> Supporting rapid prototyping and product devlopment through customized 3D printing solutions. </p>
                    </div>
                </div>
                <div class="box1 product-card">
                    <h4 class="customh4"> OEM & White-Label Manufacturing </h4>
                    <img class="product-image custom1" src="oem.png" alt="Custom Devlopment" id="zoomImage">

                    <div class="diem">
                        <p> Providing manufacturing and customization opportunities for businesses looking to develop or market 
                            products under their own brand.</p> 
                    </div>
                </div>

            </div>

        </div>
    </section>

    <section class="vision-mission">

        <div class="content-wrapper" id="icon">

            <!-- Our Vision -->
            <div class="content-box">

                

                <div class="content" >
                    <div class="icon"><i class="fa-solid fa-eye"></i><h2>Our Vision</h2></div>

                    <p>
                        To become a trusted technology and engineering
                        partner by delivering innovative, reliable and
                        scalable solutions that create value for
                        businesses across industries.
                    </p>
                </div>

            </div>

            <!-- Our Mission -->
            <div class="content-box">

                

                <div class="content">
                    <div class="icon"><i class="fa-solid fa-bullseye"></i><h2>Our Mission</h2></div>

                    <p>
                        To combine engineering excellence, continuous
                        innovation and customer-focused development
                        to build practical technology solutions that
                        solve real-world challenges and support
                        business growth.
                    </p>
                </div>

            </div>

        </div>

    </section>

    <section class="page6">
        <div class="product-title">
            <div class="heading1">
                <h5> WHY CHOOSE US </h5>
                <h1> The LDTECS Advantage </h1>
            </div>
            <div class="products-container">

                <div class="box2 product-card2">
                    <i class="fa-solid fa-lightbulb"></i>
                    <h4 class="customh5"> Innovation-Driven Apporach </h4>   
                    <div class="diem1">
                        <p> We continuously explore new technologies to devlop better solutions. </p>
                    </div>

                </div>

                <div class="box2 product-card2">
                    <i class="fa-solid fa-hexagon-nodes"></i>
                    <h4 class="customh5"> Integrated Expertise </h4>
                    <div class="diem1">
                        <p> We Combine hardware, software and engineering capabilites under one roof. </p>
                    </div>

                </div>

                <div class="box2 product-card2">
                    <i class="fa-solid fa-wrench"></i>
                    <h4 class="customh5"> Customized Solutions </h4>
                    <div class="diem1">
                        <p> We adapt our approch to meet specific customer and industry requirements. </p>
                    </div>

                </div>
                <div class="box2 product-card2">
                    <i class="fa-solid fa-shield"></i>
                    <h4 class="customh5"> Quality & Reliability </h4>
                    <div class="diem1">
                        <p> We focus on product performance, practical usability and dependable technical support. </p>
                    </div>
                </div>
                <div class="box2 product-card2">
                    <i class="fa-regular fa-handshake"></i>
                    <h4 class="customh5"> Partnership & Collaboration </h4>
                    <div class="diem1">
                        <p> We work with clients, distributors, laboratories and businesses to build long-term relationship. </p> 
                    </div>
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
                    Surat, Gujarat, India
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.15.0/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.15.0/ScrollTrigger.min.js"></script>

    <script>
        gsap.registerPlugin(ScrollTrigger);
    </script>

    <script src="{{ secure_asset('script2.js') }}"></script>
    
    <script>
        const toggle = document.getElementById('menuToggle');
        const navbar = document.getElementById('navbar');

        if (toggle && navbar) {
            toggle.addEventListener('click', () => {
                const isOpen = navbar.classList.toggle('open');
                toggle.classList.toggle('active', isOpen);
                toggle.setAttribute('aria-expanded', String(isOpen));
                toggle.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
            });

            // Expand Products and Services dropdowns on mobile.
            document.querySelectorAll('.product-menu > a, .product-menu1 > a').forEach(link => {
                link.addEventListener('click', event => {
                    if (window.matchMedia('(max-width: 820px)').matches) {
                        event.preventDefault();
                        const parent = link.parentElement;
                        parent.classList.toggle('mobile-open');
                    }
                });
            });

            document.querySelectorAll('.navbar a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.matchMedia('(max-width: 820px)').matches &&
                        !link.parentElement.classList.contains('product-menu') &&
                        !link.parentElement.classList.contains('product-menu1')) {
                        navbar.classList.remove('open');
                        toggle.classList.remove('active');
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                });
            });
        }

                /*====================================
            Product dropdown 
        ======================================*/
        
document.querySelectorAll(".diamond-menu").forEach((menu) => {
    const button = menu.querySelector(".diamond-btn");
    const popup = menu.querySelector(".diamond-side-popup");

    button.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();

        const isOpen = popup.classList.contains("show");

        document.querySelectorAll(".diamond-side-popup").forEach((item) => {
            item.classList.remove("show");
        });

        document.querySelectorAll(".diamond-btn").forEach((item) => {
            item.classList.remove("active");
        });

        if (!isOpen) {
            popup.classList.add("show");
            button.classList.add("active");
        }
    });
});

document.addEventListener("click", (event) => {
    if (!event.target.closest(".diamond-menu")) {
        document.querySelectorAll(".diamond-side-popup").forEach((popup) => {
            popup.classList.remove("show");
        });

        document.querySelectorAll(".diamond-btn").forEach((button) => {
            button.classList.remove("active");
        });
    }
});

 /*====================================
            Contect US 
        ======================================*/
        const contactPopup = document.getElementById("contactPopup");
        const closeContact = document.getElementById("closecontact");
        const openContact = document.getElementById("openContact");

        openContact.addEventListener("click", () => {
            contactPopup.style.display = "flex";
            document.body.style.overflow = "hidden";
        });

        function closeContactPopup() {
            contactPopup.style.display = "none";
            document.body.style.overflow = "";
        }

        closeContact.addEventListener("click", closeContactPopup);

        contactPopup.addEventListener("click", (event) => {
            if (event.target === contactPopup) {
                closeContactPopup();
            }
        });

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                closeContactPopup();
            }
        });

        document.getElementById("contactForm").addEventListener("submit", (event) => {
            event.preventDefault();

            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const phone = document.getElementById("phone").value.trim();
            const message = document.getElementById("message").value.trim();

            const text =
                "New LDTECS Website Inquiry\n\n" +
                "Name: " + name + "\n" +
                "Email: " + email + "\n" +
                "Phone: " + phone + "\n" +
                "Message: " + message;

            const whatsappNumber = "917240713574";

            const url =
                "https://wa.me/" + whatsappNumber +
                "?text=" + encodeURIComponent(text);

            window.open(url, "_blank");
        });



    </script>

    @include('partials.chatbot')
</body>
</html>