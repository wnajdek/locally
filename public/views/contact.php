<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/contact.css">
    <title>Contact Us</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Metro UI -->
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">

</head>
<body>
    <div class="main-container">
        <nav class="navigation">
            <a id='link-logo' href="/market">
                <h1 class="logo">Locally</h1>
                <p class="slogan">Because the good stuff is local</p>
            </a>
    
            <ul>
                <li><a href="/market"><span class="mif-shop nav-icon"></span>Market</a></li>
                <li><a href="/my_products"><span class="mif-home nav-icon"></span>My products</a></li>
                <li><a href="/favourites"><span class="mif-heart nav-icon"></span>Favourites</a></li>
                <li><a href="/logout"><span class="mif-keyboard-return nav-icon"></span>Log out</a></li>
                <li><a href="/contact" class="active-page"><span class="mif-mail nav-icon"></span>Contact</a></li>
            </ul>
        </nav>
            
        <main class="main">
            <div class="contact-container">
                <h1>Contact Us</h1>
                <form action="">
                    <input type="email" placeholder="Email">
                    <input type="text" placeholder="Topic">
                    <textarea name="message" cols="30" rows="15" placeholder="Type your message here"></textarea>
                    
                    <button>Send</button>
                </form>
            </div>
        </main>
    </div>
    





    <script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>