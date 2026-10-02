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

        html, body {
            touch-action: auto;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            text-align: center;
            background: #F1F5FD;
            color: var(--text);
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            width: auto;
            height:auto;
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
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            margin-left: 12px;
        }

        .navbar {
            display: flex;
            align-items: center;
            gap: 34px;
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
            background: #e9aa6b;
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
                right: 0px;
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

            .menu-toggle {
                display: flex;
            }

            .hero h1 {
                font-size: 30px;
            }
        }

        .product-menu{
            position:none;
            diaplay:none;
        }

        .product-link{
            text-decoration:none;
            color:#222;
            padding:20px;
            display:block;
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
            display:block;
            padding: 12px 18px;
            color:#222;
            text-decoration:none;
            transition: 0.3s;

        }

        .nano, .lite {
            padding: 0 20px;
            border-left: 2px solid #6f6a67;
        }

        .product-popup a:hover{
            background:#f1f7f7;
            color:#e9aa6b;
        }

        .product-card {
            width:100%;
            max-width:400px;
            min-height:360px;
            height:auto;

            background: #ffffff;

            border: 2px solid #111;

            border-radius: 20px;

            padding: 30px 20px 25px;
            margin:0 auto 50px;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;

            transition:
                transform 0.4s ease,
                box-shadow 0.4s ease,
                border-color 0.4s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow:0 20px 45px rgba(0, 0, 0, 0.15);
            border-color: #24a19c;
        }

        .product-card:hover .product-image {
            transform: scale(1.08);
            filter: brightness(1.03);
        }
        .product-image.elite {
            width: 70%;
            height: 60%;
            object-fit: contain;
            margin-top:50px;
        }


        .page1{
            width:100%;
            min-height:100vh;
            display:flex;
            flex-direction:column;
            align-items:center;
        }
        .hero1,
        .hero-image {
            width:100%;
        }
        .hero-image {
            display:flex;
            justify-content:center;
            padding:0 24px;
            margin-top:50px;
        }
        .page2{
            width:100%;
            min-height:100vh;
            background:#ffffff;
        }

        .description {
            font-size:25px;
            font-weight:540;
            padding-top:50px;
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
        }

        .product-card1 {
            width:100%;
            min-height:360px;

            background: #ffffff;

            border: 2px solid #111;

            border-radius: 20px;

            padding: 30px 20px 25px;
            margin:50px 0;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;

            transition:
                transform 0.4s ease,
                box-shadow 0.4s ease,
                border-color 0.4s ease;
        }

        .product-card1:hover {
            transform: translateY(-10px);
            box-shadow:0 20px 45px rgba(0, 0, 0, 0.15);
            border-color: #24a19c;
        }

        .product-card1:hover .product-image {
            transform: scale(1.08);
            filter: brightness(1.03);
        }

        .product-image.elite1 {
            width:130%;
            max-width:900px;
            max-height:350px;
            object-fit: contain;
            margin:20px 0;
        }

        .product-image.elite0 {
            width:90%;
            max-width:120%;
            max-height:300px;
            object-fit: contain;
            margin:20px 0;
        }

        .product-image.elit0 {
            width:100%;
            max-width:150%;
            max-height:400px;
            object-fit: contain;
            margin:20px 0;
        }

        .paragraph{
            font-size:22px;
            font-weight:450;
            padding:0;
            text-align:left;    
        }
        @media (max-width: 820px) {

            .header {
                padding: 12px 20px;
            }

            .box1 {
                grid-template-columns:1fr;
                gap: 35px;
            }

            .product-card1,
            .paragraph {
                width: 100%;
            }

            .paragraph {
                text-align: center;
            }
        }


        @media (max-width: 600px) {

            .page2 {
                padding: 60px 5%;
            }

            .product-card1 {
                padding: 18px;
            }

            .paragraph p {
                font-size: 16px;
                line-height: 1.65;
            }
        }

        .page3{
            width:100%;
            min-height:100vh;
            background:#F1F5FD;
            padding-bottom:48px;
        }
        
        .page-title{
            padding-top:50px;
            font-weight:400;
            font-size:20px;
        }

        .product-card2 {
            width:auto;
            flex:1 1 220px;
            max-width:320px;
            min-height:100px;

            /* background: #a04949; */

            border: 2px solid #111;

            border-radius: 20px;

            padding:30px 24px;
            margin:0;
            

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;
        }

        .product-image.loose {
            width:60%;
            max-width:100%;
            max-height:300px;
            object-fit: contain;
            margin:10px;
        }

        .product-image.shape {
            width:100%;
            max-width:220px;
            max-height:300px;
            object-fit: contain;
            margin:15px;
        }

        .all{
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
            align-items:stretch;
            gap:24px;
            width:100%;
            max-width:1150px;
            margin:24px auto;
            padding:0 24px;
        }

        @media (max-width: 820px) {

            .header {
                padding: 12px 20px;
            }

            .all {
                gap:20px;
            }

        }


        @media (max-width: 600px) {

            .page3 {
                padding: 60px 5%;
            }

            .product-card2 {
                padding: 18px;
            }

            p {
                font-size: 16px;
                line-height: 1.65;
            }
        }

        .product-card3 {
            width:auto;
            flex:1 1 240px;
            max-width:360px;
            min-height:20px;

            /* background: #a04949; */

            border: 2px solid #111;

            border-radius: 20px;

            padding:10px 24px 30px;
            
            

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;
        }

        .product-image.search {
            width:100%;
            max-width:200px;
            max-height:60px;
            object-fit: contain;
            margin:10px;
        }

        .product-image.size {
            width:100%;
            max-width:200px;
            max-height:60px;
            object-fit: contain;
            margin:10px;
        }

        .product-card4 {
            width:auto;
            flex:1 1 240px;
            max-width:320px;
            min-height:50px;

            /* background: #a04949; */

            border: 2px solid #111;

            border-radius: 20px;

            padding:30px 24px;
            margin:0;
            

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;
        }

        .page4{
            width:auto;
            height:auto;
            background:#ffffff;
        }

        .paragraph1{
            padding-left:50px;
            padding-right:30px;
            padding-top:50px;
            padding-bottom:80px;
            text-align:left;
            line-height:2;
            font-size:20px;
            font-weight:500;
        }

        .page5{
            width:auto;
            height:auto;
            background:#f2f7fd;
        }

        .page-title1{
            padding-top:50px;
            font-weight:400;
            font-size:20px;
        }

        .product-card5 {
            width:auto;
            flex:1 1 240px;
            max-width:250px;
            min-height:150px;

            /* border: 2px solid #111;

            border-radius: 20px; */
            padding:30px 24px;
            margin-top:50px;            

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;
        }
        .product-image.try {
            width:100%;
            max-width:500px;
            max-height:500px;
            object-fit: contain;
            margin-bottom:-10px;   
        }
        .product-image.tray {
            width:88%;
            max-width:450px;
            max-height:190px;
            object-fit: contain;    
        }

        .product-image.tary {
            width:95%;
            max-width:450px;
            max-height:200px;
            object-fit: contain;    
        }

        .product-image.trye {
            width:120%;
            max-width:400px;
            max-height:500px;
            object-fit: contain;    
        }

        .alll{
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
            align-items:stretch;
            gap:20px;
            width:100%;
            max-width:1150px;
            margin:24px auto;
            padding:0 24px;
        }
        .scan, .scan1,.scan2{
            padding-top:10px;
            text-align:center;
            font-size:16px;
            font-weight:400;
            font-family:Arial;
        }

        .product-card6 {
            width:auto;
            flex:1 1 240px;
            max-width:200px;
            min-height:100px;

            /* border: 2px solid #111;

            border-radius: 20px; */
            padding:30px 24px;
            margin-top:50px;            

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;
        }

        .holder, .display{
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
            align-items:stretch;
            gap:20px;
            width:100%;
            max-width:1150px;
            margin:auto;
            padding:0 24px;
            margin-top:-50px;
        }

        .page6{
            width:auto;
            height:auto;
            background:#ffffff;
        }

        .title6{
            padding-left:50px;
            padding-top:50px;
            font-weight:300;
            font-size:20px;
            padding-bottom:50px;
        }

        .technical {
            width:150%;
            max-width:400px;
            max-height:500px;
            object-fit: contain; 
        }
        .product-card7 {
            width:auto;
            flex:1 1 240px;
            max-width:500px;
            min-height:400px;

            /* border: 2px solid #111;

            border-radius: 20px; */
            padding:30px 24px;
            margin-top:-50px;            

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;
        }        
        
        .title7{
            /* padding-left:50px; */
            padding-top:50px;
            font-weight:300;
            font-size:18px;
        }

        .feature{
            /* padding-left:20px; */
            padding-top:50px;
            text-align:left;
            line-height:2;
            font-size:20px;
            font-weight:500;
            display:flex;
        }
        .specifications{
            width:50%;
            display:grid;
        }
        .paragraph2{
            padding-left:20px;
            padding-top:20px;
            text-align:left;
            line-height:2;
            font-size:18px;
            font-weight:500;
        }
        .product-card8   {
            width:auto;
            flex:1 1 240px;
            max-width:600px;
            min-height:300px;
            padding:30px 24px;
            margin-top:-50px;            

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;
        } 
    </style>
</head>
<body>
    
    <header class="header">
        <div class="logo">
            <img class="hero-img" src="header.png" alt="back">
            <img class="img" src="ldtecs logo.png" alt="logo" onerror="this.style.background='var(--text)'">
            <span class="brand">LDTECS</span>
        </div>

        <nav class="navbar" id="navbar">
            <a href="/">Home</a>
            <div class="product-menu">
                <a href="#our-products"  class="active">Products <i class="fa-solid fa-chevron-down"></i></a>
                <div class="product-popup">
                    <div class="elite">
                        <a href="/elite"> CLASSIFIRE ELITE </a>
                    </div>
                    <div class="lite">
                        <a href="/lite"> CLASSIFIRE LITE </a>
                    </div>
                    <div class="nano">
                        <a href="/nano" class="active"> CLASSIFIRE NANO </a>
                    </div>
                </div>
            </div>
            <a href="/services">Services</a>
            <a href="/career">Career</a>
            <a href="/about">About</a>
        </nav>
    </header>
    <div class="page1">
        <section class="hero">
            <div class="hero-copy">
                <h1 id="title1">CLASSIFIER NANO</h1>
                <p></p>
            </div>    
        </section>
        <section class="hero1">
            <div class="hero-image"> 
                <div class="product-card">
                    <img class="product-image elite0" src="nano1.png" alt="Classifier nano">     
                </div>
                <div class="product-card">
                    <img class="product-image elit0" src="Classifier Nano1.png" alt="Classifier nano">
                </div>
                <div class="product-card">
                    <img class="product-image elit0" src="litetop.png" alt="Classifier lite">
                </div>
            </div>     
        </section>
    </div>

    <section class="page2">
        <div class="page-title">
            <h1 id="des"> Description </h1>
        </div>
        <div class="box1">
            <div class="product-card1">
                <img class="product-image elite1" src="transparent.png" alt="Classifier elite" id="elite1">
            </div>
            <div class="paragraph2">
                <p id="p">Classifier is a next-generation lab- grown diamond screening solution designed to 
                    accurately detect synthetic diamonds (CVD, HPHT) and simulants (Cubic Zirconia, 
                    Moissanite).
                </p>

                <p id="p">Powered by Artificial Intelligence, it delivers fast, reliable 
                    results in 25-40 seconds, making it an essential tool for gem labs, jewelers, 
                    and diamond traders.
                </p>
            </div>
        </div>
    </section>

    <section class="page3">
        <div class="title2">
            <div class="page-title">
                <h1> Overview </h1>
            </div>
            <div class="all">
                <div class="product-card2">
                    <img class="product-image loose" src="loose.svg" alt="Loose" id="loose">
                    <h4>Loose & Mounted </h3>
                </div>
                <div class="product-card2">
                    <img class="product-image shape" src="all-shapes.svg" alt="All-Shapes" id="all-shapes">
                    <h4> All Shapes </h4>
                </div>
                <div class="product-card2">
                    <img class="product-image rough" src="rough.svg" alt="Rough" id="rough">
                    <h4>Rough & Polished </h4>
                </div>
            </div>
            <div class="all">
                <div class="product-card3">
                    <img class="product-image search" src="search.png" alt="search" id="search">
                    <p>Detects </p>
                    <h4> CVD/HPHT & Treated </h4>
                </div>
                <div class="product-card3">
                    <img class="product-image search" src="accuracy.png" alt="search" id="search">
                    <p>Accuracy </p>
                    <h3> +98% </h3>
                </div>
            </div>
            <div class="all">
                <div class="product-card4">
                    <img class="product-image size" src="size.png" alt="Loose" id="loose">
                    <p>Size </p>
                    <h4> 0.001 Cts and larger </h4>
                </div>
                <div class="product-card4">
                    <img class="product-image size" src="color.png" alt="All-Shapes" id="all-shapes">
                    <p> Colors </p>
                    <h4> D to K </h4>
                </div>
                <div class="product-card4">
                    <img class="product-image size" src="time.png" alt="Rough" id="rough">
                    <p> Sccannig Time </p>
                    <h4> 25 - 40 Seconds </h4>
                </div>
            </div>
        </div>
    </section>

    <section class="page4">
        <div class="title4">
            <div class="page-title">
                <h1> Key Features </h1>
            </div>
            <div class="paragraph1">
                <p id="source"><i class="fa-solid fa-circle-arrow-right"></i> <b>comprehensive Diamond Detection - </b> The machine is designed to <b>detect natural diamonds, lab-grown diamonds(CVD, HPHT), and non-doamond simulants like CZ,</b> While also identifiyng RFT. It can <b>scan loose diamonds</b> as well as various types to <b>jewellery, including neckless, earings, bangles andd more.</b> </p>
                <p id="sourc"><i class="fa-solid fa-circle-arrow-right"></i> <b>Smart Auto-Marking - </b>The machine features <b>advanced automatic diamond detection,</b> simplifying the identification process and enhancing accuracy. </p>
                <p id="sour"><i class="fa-solid fa-circle-arrow-right"></i> <b> Internal Fluorescent Light - </b>This system uses <b> UV light with a unique wavelight</b> to reduce false positive and simulant light to detect non-diamonds, making it the first machine to incorporate this advanced technology. </p>
                <p id="sou"><i class="fa-solid fa-circle-arrow-right"></i> <b>Advanced Data Management - </b>Offers auto-save and manual save options with customizable details like name, lot number, and other details. Comes with <b>256 GB Storage</b> and an In-app gallery for easy access.</p>
                <p id="so"><i class="fa-solid fa-circle-arrow-right"></i> <b>Certificate Generations - </b> Allow users to create professional certificates with customizable featuers, enabling branding for their company. </p>
                <p id="s"><i class="fa-solid fa-circle-arrow-right"></i> <b>Seamless Record Sharing - </b> Effortiessly share records via Email, or any mobile sharing feature for quick and secure data tranfer. </p>
                <p id="same"><i class="fa-solid fa-circle-arrow-right"></i> <b> 15X Zoom for Precision - </b> Equipped with 15X zooming capabilities allowing for clear and detailed viewing of individual diamonds. </p>
                <p id="sam"><i class="fa-solid fa-circle-arrow-right"></i> <b> Flexible Display Modes - </b>Supports three screeing options: Single Screeing, Double Screening, and Quad Screening. Users can freely select and switch between modes fir easy and accurate screeing. </p>
            </div>    
        </div>
    </section>

    <section class="page5">
        <div class="title5">
            <div class="page-title1">
                <h1> Included Accessories </h1>
            </div>
            <div class="alll">
                <div class="product-card5">
                    <img class="product-image try" src="lite tray.png" alt="Diamond Try" id="tray">
                    <div class="scan">
                        <h3> Ring Tray </h3>
                    </div>
                </div>
                <div class="product-card5">
                    <img class="product-image try" src="lite Tray1.png" alt="Diamond Try" id="tray">
                    <div class="scan">
                        <h3> Diamond Tray </h3>
                    </div>
                </div> 
            </div>
            <div class="holder">
                <div class="product-card6">
                    <img class="product-image try" src="big holder.png" alt="Diamond Try" id="holder">
                    <div class="scan1">
                        <h4> Big Bangles holder </h4>
                    </div>
                </div>
                <div class="product-card6">
                    <img class="product-image try" src="holder1.png" alt="Diamond Try" id="holder">
                    <div class="scan1">
                        <h4> Bracelet Holder </h4>
                    </div>
                </div>
                <div class="product-card6">
                    <img class="product-image try" src="ring holder.png" alt="Diamond Try" id="holder">
                    <div class="scan1">
                        <h4> Ring Holder </h4>
                    </div>
                </div>
            </div>
            <div class="display">
                <div class="product-card6">
                    <img class="product-image try" src="mobile1.png" alt="Diamond Try" id="display">
                    <div class="scan2">
                        <h4> Smart Phone </h4>
                    </div>
                </div>
                <div class="product-card6">
                    <img class="product-image try" src="charger.png" alt="Diamond Try" id="display">
                    <div class="scan2">
                        <h4> Charger </h4>
                    </div>
                </div>
                <div class="product-card6">
                    <img class="product-image try" src="bag.png" alt="Diamond Try" id="display">
                    <div class="scan2">
                        <h4> Packaging bag </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page6">
        <div class="feature">
            <div class="specifications">
                <div class="title6">
                    <h1> Technical Specifications </h1>
                </div>
                <div class="product-card7">
                    <img class="technical" src="specifications nano.png" alt="Diamond Try" id="technical">
                </div>
            </div>
            <div class="software">
                <div class="title7">
                    <h1> Software Features </h1>
                </div>
                <div class="product-card8">
                <div class="paragraph2">
                    <p id="software"><i class="fa-solid fa-circle-arrow-right"></i> <b>16 MP Auto-Focus Camera</b> for High-Resolution diamond imaging</p>
                    <p id="softwar"><i class="fa-solid fa-circle-arrow-right"></i> <b>20X+ Zoom capability</b> for microscopic clarity </p>
                    <p id="softwa"><i class="fa-solid fa-circle-arrow-right"></i> <b>256GB Local Storage</b> for offline record keeping </p>
                    <p id="softw"><i class="fa-solid fa-circle-arrow-right"></i> <b>15GB Cloud Storage (Free)</b> with upgradable options </p>
                    <p id="soft"><i class="fa-solid fa-circle-arrow-right"></i> <b>Email Sharing</b> of records and reports </p>
                    <p id="sof"><i class="fa-solid fa-circle-arrow-right"></i> <b>Custom Theme Report Generation</b> of result </p>
                    <p id="fe"><i class="fa-solid fa-circle-arrow-right"></i> <b>QR Code Generation</b> for linking to uploaded report URL </p>
                    <p id="feat"><i class="fa-solid fa-circle-arrow-right"></i> <b>Auto-Save Records</b> with minimal manual steps</p>
                    <p id="featu"><i class="fa-solid fa-circle-arrow-right"></i> <b>Auto-Delete Old Records</b> to manage storage efficiently</p>
                    <p id="featur"><i class="fa-solid fa-circle-arrow-right"></i> <b>WI-FI Connectivity</b> for real-time sync and updates </p>
                </div>
                </div>
            </div>
        </div>
    </section>
    

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.15.0/gsap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.15.0/ScrollTrigger.min.js"></script>

    <script>
        gsap.registerPlugin(ScrollTrigger);
    </script>

    <script src="{{ asset('script1.js') }}"></script>

    <script>
        const toggle = document.getElementById('menuToggle');
        const navbar = document.getElementById('navbar');
        toggle.addEventListener('click', () => navbar.classList.toggle('open'));

        document.querySelectorAll('.navbar a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelectorAll('.navbar a').forEach(a => a.classList.remove('active'));
                link.classList.add('active');
                navbar.classList.remove('open');
            });
        });
    </script>
</body>
</html>