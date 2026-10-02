<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ldtecs</title>
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
            touch-action: none;
        }

        body {
            text-align: center;
            background: #d0ded0;
            color: var(--text);
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            min-height: 100dvh;
            width: 100vw;
            display: flex;
            flex-direction: column;
        }
        .header {
            position: sticky;
            margin-top:0px;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 50px;
            background: var(--bg-2);
            border-bottom: 1px solid var(--bg-1);
            box-shadow: 0 2px 12px rgba(25, 27, 25, 0.08);
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .img {
            width: 46px;
            height: 46px;
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
            color: var(--text);
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
            font-size: 15px;
            font-weight: 600;
            color: var(--text-soft);
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
            background: var(--accent);
            border-radius: 2px;
            transition: width 0.25s ease;
        }

        .navbar a:hover {
            color: var(--accent);
        }

        .navbar a:hover::after,
        .navbar a.active::after {
            width: 100%;
        }

        .navbar a.active {
            color: var(--accent);
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
            background: var(--text);
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
        }

        .hero h1 {
            font-size: 70px;
            color: var(--text);
            max-width: 700px;
            line-height: 1.3;
            text-align: center;
            margin: 0;
        }

        .hero span {
            color: #51c2eb;

        }

        .hero p {
            font-size: 16px;
            color: var(--text-soft);
            max-width: 520px;
            text-align: center;
            margin: 0;
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
                background: var(--bg-2);
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
        .product-popup{
            position: absolute;
            top:100%;
            left:1000px;
            width:220px;
            background:white;
            border-radius:8px;
            padding: 12px 0;
            box-shadow:0 8px 25px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: 0.3s ease;
            z-index: 1000;
        }

        /*cursor pointer*/
        .product-menu:hover .product-popup{
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .product-popup a{
            display:block;
            padding: 12px 18px;
            color:#222;
            text-decoration:none;
            transition: 0.3s;
        }

        .product-popup a:hover{
            background:#f1f7f7;
            color:#24A19C;
        }

        .hero-img {
            width: 100%;
            max-width: 1200px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 24px;
            margin-top: 120px;
            margin-left: 0;
            padding-left: 0;
            border-radius: 8px;
            font-size: 16px;
            color: var(--text-soft);
        }

        .hero-img img {
            width: 430px;
            max-width: 48%;
            height: auto;
            border-radius: 12px;
            object-fit: cover;
            display: block;
            box-shadow: 0px 5px 80px rgba(9, 9, 9, 0.20);
            flex-shrink: 0;
        }


    </style>
</head>
<body>
    <div class="page">
        <header class="header">
            <div class="logo">
                <img class="img" src="logo.png" alt="logo" onerror="this.style.background='var(--text)'">
                <span class="brand">LDTECS</span>
            </div>

            <nav class="navbar" id="navbar">
                <a href="/">Home</a>
                <div class="product-menu">
                    <a href="/product">Products</a>
                    <div class="product-popup">
                        <a href="/elite"> CLASSIFIRE ELITE </a>
                        <a href="/lite"> CLASSIFIRE LITE </a>
                        <a href="/namo"> CLASSIFIRE NAMO </a>
                    </div>
                </div>
                <a href="/technology" class="active">Technology</a>
                <a href="/services">Services</a>
                <a href="/contact">Contact</a>
                <a href="/about">About</a>
            </nav>
        </header>

        <section class="hero">
            <h1>Welcome To <br><span>Products</span></h1>
            <p>Leading the science of Diamond Detection </p>
            <div class="box">
                <div class="box-1"></div>
            </div>
        </section>
    </div>

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