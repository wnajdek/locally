<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/market.css">
    <title>Market</title>

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
            <h1 class="logo">Locally</h1>
            <p class="slogan">Because the good stuff is local</p>
    
            <ul>
                <li><a href="market.html" class="active-page"><span class="mif-shop nav-icon"></span>Market</a></li>
                <li><a href="my_products.php"><span class="mif-home nav-icon"></span>My products</a></li>
                <li><a href="favourites.php"><span class="mif-heart nav-icon"></span>Favourites</a></li>
                <li><a href="info.html"><span class="mif-info nav-icon"></span>Info</a></li>
                <li><a href="contact.php"><span class="mif-mail nav-icon"></span>Contact</a></li>
            </ul>
        </nav>
            
        <main class="main">
            <header>
                <div class="search-bar">
                    <form action="">
                        <!-- <label for="search-by">Search by</label>
                        <select name="search-by" id="search-by">
                            <option value="farm name">farm name</option>
                            <option value="product">product</option>
                        </select> -->
                        <div class="select-box">
                            <div class="select-box__current" tabindex="1">
                                <img class="select-box__icon" src="public/image/chevron-down-circle-outline.svg" alt="Arrow Icon"
                                    aria-hidden="true"/>
                                <div class="select-box__value">
                                    <input class="select-box__input" type="radio" id="0" value="1" name="option" checked="checked" />
                                    <p class="select-box__input-text">farm name</p>
                                </div>
                                <div class="select-box__value">
                                    <input class="select-box__input" type="radio" id="1" value="2" name="option" />
                                    <p class="select-box__input-text">product</p>
                                </div>
                            </div>
                            <ul class="select-box__list">
                                <li>
                                    <label class="select-box__option" for="0" aria-hidden="aria-hidden">farm name</label>
                                </li>
                                <li>
                                    <label class="select-box__option" for="1" aria-hidden="aria-hidden">product</label>
                                </li>
                            </ul>
                        </div>

                        <input type="search" name="q" placeholder="Search">
                    </form>
                </div>
            </header>
            <section class="offers">
                <div id="market1" class="tile">
                    <img src="https://images.unsplash.com/photo-1507844090982-e6e9452ea68d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1732&q=80" alt="Foto of market or local products">

                    <h3>Stoisko Ewy</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse molestie euismod blandit. Vivamus vel ligula tortor. Mauris dictum commodo commodo. Curabitur finibus gravida lorem et ... </p>
                    
                    <button class="tile-button">See offer</button>

                    <div class="likes">
                        <button><span class="mif-heart"></span></button>
                        <span class="likes-number">20</span>
                    </div>
                </div>
                <div id="market2" class="tile">
                    <img src="https://images.unsplash.com/photo-1507844090982-e6e9452ea68d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1732&q=80" alt="Foto of market or local products">

                    <h3>Stoisko Ewy</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse molestie euismod blandit. Vivamus vel ligula tortor. Mauris dictum commodo commodo. Curabitur finibus gravida lorem et ... </p>
                    
                    <button class="tile-button">See offer</button>

                    <div class="likes">
                        <button><span class="mif-heart"></span></button>
                        <span class="likes-number">20</span>
                    </div>
                </div>
                <div id="market3" class="tile">
                    <img src="https://images.unsplash.com/photo-1507844090982-e6e9452ea68d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1732&q=80" alt="Foto of market or local products">

                    <h3>Stoisko Ewy</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse molestie euismod blandit. Vivamus vel ligula tortor. Mauris dictum commodo commodo. Curabitur finibus gravida lorem et ... </p>
                    
                    <button class="tile-button">See offer</button>

                    <div class="likes">
                        <button><span class="mif-heart"></span></button>
                        <span class="likes-number">20</span>
                    </div>
                </div>
                <div id="market4" class="tile">
                    <img src="https://images.unsplash.com/photo-1507844090982-e6e9452ea68d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1732&q=80" alt="Foto of market or local products">

                    <h3>Stoisko Ewy</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse molestie euismod blandit. Vivamus vel ligula tortor. Mauris dictum commodo commodo. Curabitur finibus gravida lorem et ... </p>
                    
                    <button class="tile-button">See offer</button>

                    <div class="likes">
                        <button><span class="mif-heart"></span></button>
                        <span class="likes-number">20</span>
                    </div>
                </div>
                <div id="market5" class="tile">
                    <img src="https://images.unsplash.com/photo-1507844090982-e6e9452ea68d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1732&q=80" alt="Foto of market or local products">

                    <h3>Stoisko Ewy</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse molestie euismod blandit. Vivamus vel ligula tortor. Mauris dictum commodo commodo. Curabitur finibus gravida lorem et ... </p>
                    
                    <button class="tile-button">See offer</button>

                    <div class="likes">
                        <button><span class="mif-heart"></span></button>
                        <span class="likes-number">20</span>
                    </div>
                </div>
            </section>
        </main>
        <div class="search-container">
    
        </div>
    </div>
    





    <script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>