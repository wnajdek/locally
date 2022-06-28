<link rel="stylesheet" type="text/css" href="/public/css/navigation.css">
<script src="public/js/navigation.js" type="text/javascript" defer></script>
<button id="hamburger"><span class="mif-menu nav-icon"></span></button>
<nav class="navigation">
    <button id="hide-navigation"><span class="mif-cross-light nav-icon"></span></button>
    <a id='link-logo' href="/market">
        <h1 class="logo">Locally</h1>
        <p class="slogan">Because the good stuff is local</p>
    </a>

    <ul>
        <li><a href="/market"><span class="mif-shop nav-icon"></span>Market</a></li>
        <li><a href="/my_products"><span class="mif-home nav-icon"></span>My products</a></li>
        <li><a href="/favourites"><span class="mif-heart nav-icon"></span>Favourites</a></li>
        <li><a href="/user"><span class="mif-user nav-icon"></span>User</a></li>
        <?php if($_SESSION['isAdmin']) :?>
            <li><a href="/admin"><span class="mif-cog nav-icon"></span>Admin</a></li>
        <?php endif;?>
        <li><a href="/logout"><span class="mif-keyboard-return nav-icon"></span>Log out</a></li>
        <li><a href="/contact"><span class="mif-mail nav-icon"></span>Contact</a></li>
    </ul>
</nav>