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
        <?php include('common/navigation.php') ?>
            
        <main class="main">
            <div class="contact-container">
                <h1>Contact Us</h1>
                <form action="/mail" method="post">
                    <input name="email" type="email" value="<?= $email?>" readonly="readonly">
                    <input name="topic" type="text" placeholder="Topic">
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