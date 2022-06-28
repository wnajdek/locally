<link rel="stylesheet" type="text/css" href="public/css/search_bar.css">
<header>
    <div class="search-bar">
        <div class="select-box">
            <div class="select-box__current" tabindex="1">
                <img class="select-box__icon" src="public/image/chevron-down-circle-outline.svg" alt="Arrow Icon"
                     aria-hidden="true"/>
                <div class="select-box__value">
                    <input class="select-box__input" type="radio" id="0" value="stall name" name="option" checked="checked" />
                    <p class="select-box__input-text">stall name</p>
                </div>
                <div class="select-box__value">
                    <input class="select-box__input" type="radio" id="1" value="product" name="option" />
                    <p class="select-box__input-text">product</p>
                </div>
                <div class="select-box__value">
                    <input class="select-box__input" type="radio" id="2" value="category" name="option" />
                    <p class="select-box__input-text">category</p>
                </div>
            </div>
            <ul class="select-box__list">
                <li>
                    <label class="select-box__option" for="0" aria-hidden="aria-hidden">stall name</label>
                </li>
                <li>
                    <label class="select-box__option" for="1" aria-hidden="aria-hidden">product</label>
                </li>
                <li>
                    <label class="select-box__option" for="2" aria-hidden="aria-hidden">category</label>
                </li>
            </ul>
        </div>

        <input type="search" name="q" placeholder="Search">
    </div>
</header>
