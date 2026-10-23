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

        /* .product-menu, .product-menu1{
            position:relative;
        } */

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
            width: 600px;
            height: 100px;
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

        .devlopment{
            display:grid;
            padding-top:20px;
            text-align:left;
            line-height:1.7;
        }
        .devlopment a{
            font-size:16px;
            font-weight:700;
        }
        .services{
            text-align:left;
            padding-left:80px;
            border-left:2px solid gray;
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
            font-weight:700;
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

        .nano1, .lite1 {
            padding: 0 20px;
            border-left: 2px solid gray;
        }

        .product-popup a:hover{
            background:#f1f7f7;
            color:#e9aa6b;
        }
        .product-popup1 a:hover{
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
            text-align:left;
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
            width:70%;
            max-width:100%;
            max-height:300px;
            object-fit: contain;
            margin:20px 0;
        }

        .product-image.elite0 {
            width:70%;
            max-width:100%;
            max-height:300px;
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

        .product-card4, h4{
            letter-spacing:2px;
        }

        .page4{
            width:auto;
            height:auto;
            background:#ffffff;
        }

        .paragraph1{
            padding-left:50px;
            padding-top:50px;
            padding-bottom:50px;
            text-align:left;
            line-height:2;
            font-size:20px;
            font-family: Microsoft Sans Serif;
            font-weight:500;
        }

        .page5{
            width:auto;
            height:auto;
            background:#f2f7fd;
            font-family: Microsoft Sans Serif;
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
            margin-top:30px;            

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            position: relative;
        }
        .product-car {
            width:auto;
            flex:1 1 240px;
            max-width:250px;
            min-height:150px;

            /* border: 2px solid #111;

            border-radius: 20px; */
            padding:30px 24px;
            margin-top:70px;            

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
            line-height:1.5;
            font-weight:500;
        }

        /* .scan p{
            font-size:16px;
            letter-spacing:1px;
            font-weight:400;
        } */

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
            width:100%;
            min-height:100vh;
            height:auto;
            background:#ffffff;
            padding:clamp(24px, 5vw, 64px);
        }

        .title6{
            padding:0 0 24px;
            font-weight:300;
            font-size:clamp(16px, 2vw, 20px);
        }

        .technical {
            width:150%;
            max-width:400px;
            max-height:500px;
            object-fit: contain; 
        }

        table,tr,td{
            position:sticky;
            margin-top:20px;
            padding-left:20px;
            margin-left:20px;
            border:2px solid black;
            border-collapse:collapse;
        }
        
        .title7{
            padding-left:50px;
            padding-top:50px;
            font-weight:400;
            font-size:20px;
        }

        .feature{
            gap:clamp(24px, 4vw, 48px);
            text-align:left;
            line-height:2;
            /* letter-spacing:2px; */
            font-weight:500;
            display:flex;
            flex-wrap:wrap;
            align-items:flex-start;
        }
        .specifications{
            flex:1 1 400px;
            min-width:0;
        }
        .software{
            flex:1 1 400px;
            min-width:0;
        }
        .paragraph2{
            padding-left:20px;
            padding-top:20px;
            text-align:left;
            font-size:18px;
            font-weight:400;
            font-family: Microsoft Sans Serif;
        }
        .paragraph2{
            padding-left:20px;
            padding-top:20px;
            text-align:left;
            font-size:18px;
            font-weight:400;
            font-family: Microsoft Sans Serif;
        }
        .page6 .paragraph2{
            padding:0;
            font-size:clamp(15px, 1.4vw, 18px);
            overflow-wrap:anywhere;
        }
        .product-card8   {
            width:100%;
            max-width:none;
            min-height:0;
            padding:0;
            margin:0;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            position: relative;
        } 
        .page6 table{
            width:90%;
            table-layout:fixed;
            border-collapse:collapse;
        }
        .page6 tr,
        .page6 td{
            position:static;
            margin:0;
            padding:8px;
            overflow-wrap:anywhere;
        }
        .page6 .table{
            width:80%;
            overflow-x:auto;
        }
        .title7{
            padding:0 0 24px;
            font-size:clamp(16px, 2vw, 20px);
        }
        .product-card8 .paragraph2 p{
            margin-bottom:12px;
        }
         /* =========================================
        TABLET
        ========================================= */

        @media (max-width: 1100px) {

            .page2 {

                padding: 25px;
            }

            .products-container {

                grid-template-columns: repeat(2, 1fr);

                gap: 20px;
            }

                .product-card {

                min-height: 300px;
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


        /* PAGE 1 - Mobile responsive layout */
        @media (max-width: 1020px) {
            .page1 {
                width: 100%;
                min-height: auto;
                padding-bottom: 25px;
                overflow: hidden;
            }

            .page1 .hero {
                width: 100%;
                padding: 28px 16px 10px;
                gap: 10px;
            }

            .page1 .hero-copy {
                width: 100%;
            }

            .page1 .hero h1,
            #title1 {
                width: 100%;
                max-width: 100%;
                font-size: clamp(27px, 6vw, 40px);
                line-height: 1.2;
                overflow-wrap: anywhere;
                margin: 0 auto;
            }

            .page1 .hero p {
                width: 100%;
                max-width: 100%;
                font-size: 14px;
                line-height: 1.5;
            }

            .page1 .hero1 {
                width: 100%;
                padding: 0 14px;
            }

            .page1 .hero-image {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
                padding: 0;
                margin-top: 20px;
                align-items: stretch;
            }

            .page1 .product-card {
                width: 100%;
                min-width: 0;
                max-width: none;
                min-height: 260px;
                height: auto;
                margin: 0;
                padding: 18px 10px;
                border-radius: 14px;
            }

            .page1 .product-image,
            .page1 .product-image.elite0 {
                display: block;
                width: 100%;
                max-width: 100%;
                height: 220px;
                max-height: 220px;
                object-fit: contain;
                margin: 0 auto;
            }
        }

        @media (max-width: 480px) {
            .page1 .hero {
                padding: 24px 12px 8px;
            }

            .page1 .hero h1,
            .page1 #title1 {
                font-size: clamp(24px, 7.5vw, 32px);
                letter-spacing: 0;
            }

            .page1 .hero1 {
                padding: 0 12px;
            }

            .page1 .hero-image {
                grid-template-columns: 1fr;
                gap: 16px;
                margin-top: 16px;
            }

            .page1 .product-card {
                min-height: 240px;
                padding: 16px 12px;
            }

            .page1 .product-image,
            .page1 .product-image.elite0 {
                height: 220px;
                max-height: 220px;
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
    
        

    </style>
</head>
<body>
    
    <header class="header">
        <div class="logo">
            <img class="hero-img" src="header.png" alt="back">
            <img class="img" src="logo.png" alt="logo" onerror="this.style.background='var(--text)'">
        </div>

        <button class="menu-toggle" id="menuToggle" type="button" aria-label="Open navigation menu" aria-controls="navbar" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="navbar" id="navbar">
            <a href="/">Home</a>
            <div class="product-menu">
                <a href="#our-products"  class="active">Products <i class="fa-solid fa-chevron-down"></i></a>
                <div class="product-popup">
                    <div class="elite">
                        <a href="/elite" class="active"> CLASSIFIRE ELITE </a>
                    </div>
                    <div class="lite1">
                        <a href="/lite"> CLASSIFIRE LITE </a>
                    </div>
                    <div class="nano1">
                        <a href="/nano"> CLASSIFIRE NANO </a>
                    </div>
                </div>
            </div>
            <div class="product-menu1">
                <a href="#services" class="product-link">Services <i class="fa-solid fa-chevron-down"></i></a>
                <div class="product-popup1">
                    <div class="service">
                        <p> Technology Solutions </p>
                        <div class="devlopment">
                            <a href="software-development"> Software Development </a>
                            <a href="machine-learning "> AI & Machine Learning </a>
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
            <a href="/about">About</a>
        </nav>
    </header>
    <div class="page1">
        <section class="hero">
            <div class="hero-copy">
                <h1 id="title1">CLASSIFIER ELITE</h1>
                <p></p>
            </div>    
        </section>
        <section class="hero1">
            <div class="hero-image"> 
                <div class="product-card">
                    <img class="product-image elite0" src="machine.png" alt="Classifier elite">     
                </div>
                <div class="product-card">
                    <img class="product-image elite0" src="elite3.png" alt="Classifier elite">
                </div>
                <div class="product-card">
                    <img class="product-image elite0" src="elite2.png" alt="Classifier elite">
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
                <img class="product-image elite1" src="elite.jpeg" alt="Classifier elite" id="elite1">
            </div>
            <div class="CLassifier">
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
                <p id="source"><i class="fa-solid fa-circle-arrow-right"></i> Identifies Synthetic and Simulant Diamonds like CVD, HPHT, CZ, Treated </p>
                <p id="sourc"><i class="fa-solid fa-circle-arrow-right"></i> 98% Accuracy in Synthetic Diamond Detection </p>
                <p id="sour"><i class="fa-solid fa-circle-arrow-right"></i> 70% Accuracy in Simulant Detction </p>
                <p id="sou"><i class="fa-solid fa-circle-arrow-right"></i> Advanced AI algorithms for high-confidence detection </p>
                <p id="so"><i class="fa-solid fa-circle-arrow-right"></i> Detects loose diamonds and mounted in jewellery </p>
                <p id="s"><i class="fa-solid fa-circle-arrow-right"></i> Detects rough and polished diamonds </p>
                <p id="same"><i class="fa-solid fa-circle-arrow-right"></i> Detects diamonds primarily through D to K colour </p>
                <p id="sam"><i class="fa-solid fa-circle-arrow-right"></i> Detects all shapes and size from 0.001 Cts and larger </p>
                <p id="sa"><i class="fa-solid fa-circle-arrow-right"></i> Simple and user-frendly software interface </p>
                <p id="sm"><i class="fa-solid fa-circle-arrow-right"></i> Temper-proof and consistently reliable operation </p>
            </div>    
        </div>
    </section>

    <section class="page5">
        <div class="title5">
            <div class="page-title1">
                <h1> Included Accessories </h1>
            </div>
            <div class="alll">
                <div class="product-car">
                    <img class="product-image trye" src="Diamond Tray1.png" alt="Diamond Try" id="tray">
                    <div class="scan">
                        <h3> Diamond Tray </h3>
                        <p>220 X 200 mm </p>
                    </div>
                </div>
                <div class="product-card5">
                    <img class="product-image try" src="Bangle Tray.png" alt="Diamond Try" id="tray">
                    <div class="scan">
                        <h3> Bangle Tray </h3>
                        <!-- <p> Scanning Area <br>200 X 180 mm </p> -->
                    </div>
                </div>
                <div class="product-card5">
                    <img class="product-image tray" src="Ring Tray1.png" alt="Diamond Try" id="tray">
                    <div class="scan">
                        <h3> Ring Tray </h3>
                        <!-- <p> Scanning Area <br>200 X 180 mm </p> -->
                    </div>
                </div>
                <div class="product-card5">
                    <img class="product-image tary" src="Necklace Tray2.png" alt="Diamond Try" id="tray">
                    <div class="scan">
                        <h3> Necklace Tray </h3>
                        <!-- <p> Scanning Area <br>200 X 220 mm </p> -->
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
                    <img class="product-image try" src="display1.png" alt="Diamond Try" id="display">
                    <div class="scan2">
                        <h4> Display </h4>
                    </div>
                </div>
                <div class="product-card6">
                    <img class="product-image try" src="keyboard&mouse.png" alt="Diamond Try" id="display">
                    <div class="scan2">
                        <h4> Wireless Keyboard & Mouse </h4>
                    </div>
                </div>
                <div class="product-card6">
                    <img class="product-image try" src="adapter.png" alt="Diamond Try" id="display">
                    <div class="scan2">
                        <h4> Adapter & Power Supply </h4>
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
                <div class="table">
                    <table id="tr">
                        <tr>
                            <td>Scanning Area</td>
                            <td> (190 X 140)mm </td>
                        </tr>
                        <tr>
                            <td> Dimension (W*L*H)</td>
                            <td> (300X280X320)mm </td>
                        </tr>
                        <tr>
                            <td> Weight</td>
                            <td> 10 KG </td>
                        </tr>
                        <tr>
                            <td> Power Supply</td>
                            <td> 100-240V,5A </td>
                        </tr>
                        <tr>
                            <td> Software Interface </td>
                            <td> Standalone Linux OS </td>
                        </tr>
                        <tr>
                            <td> Accuracy </td>
                            <td> 98% </td>
                        </tr>
                        <tr>
                            <td> Local Storage </td>
                            <td> 256 GB </td>
                        </tr>
                        <tr>
                            <td> Cloude Storage </td>
                            <td> 15 GB </td>
                        </tr>
                        <tr>
                            <td> Connectivity </td>
                            <td> USB/WI-FI </td>
                        </tr>
                        <tr>
                            <td> Display </td>
                            <td> Full HD IPS Display </td>
                        </tr>
                    </table>
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

    <footer class="footer">

        <div class="footer-cta">
            <h1>Let's put our minds into motion,<br>
                Let's grow together</h1>
            <!-- <a href="#contact" class="contact-btn">GET IN TOUCH</a> -->
        </div>

        <div class="footer-container">

            <!-- Company Details -->
            <div class="footer-column company">
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
            <div class="footer-column quick-links">
                <h3>QUICK LINK</h3>

                <a href="/">Home</a>
                <a href="#our-products">Our Product</a>
                <a href="/software-development"> Software Development Services </a>
                <a href="/machine-learning"> AI & Machine Learning Services </a>
                <a href="/3d-printing"> 3D Printing Services </a>
                <a href="/cad-design"> 3D CAD Design Services </a>
                <a href="/r&d-services">R&D Services</a>
                <a href="/career">Career</a>
                <a href="/about">About</a>
            </div>

            <!-- Contact -->
            <div class="footer-column contact">
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

    <script src="{{ asset('script1.js') }}"></script>

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
    </script>
</body>
</html>