const searchBox = document.querySelector('input[type="search"]')
const offersContainer = document.querySelector(".offers");

searchBox.addEventListener("keyup", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();

        console.log(this.value)
        console.log(document.querySelector('.select-box__input:checked').value)
        const data = {
            searchValue: this.value,
            searchBy: document.querySelector('.select-box__input:checked').value
        }

        fetch("/search", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (stalls) {
            offersContainer.innerHTML = "";
            loadStalls(stalls);
        })
    }
})

function loadStalls(stalls) {
    stalls.forEach(stall => {
        createStallTile(stall);
    })
}

function createStallTile(stall) {
    // console.log(stall.isLiked)
    if (window.location.href.includes("favourites") && !stall.isLiked) {
        return;
    }

    let template = document.querySelector("#stall-template");

    let clonedTemplate = template.content.cloneNode(true);

    let tile = clonedTemplate.querySelector("#market1");
    let categories = clonedTemplate.querySelector(".categories")
    let heart = clonedTemplate.querySelector('.mif-heart');
    let name = clonedTemplate.querySelector("h3");
    let description = clonedTemplate.querySelector("p");
    let likes = clonedTemplate.querySelector(".likes-number");
    let image = clonedTemplate.querySelector("img");

    tile.setAttribute("id", stall.id);
    heart.classList.add(stall.isLiked ? "liked" : "not-liked");
    name.innerHTML = stall.name;
    description.innerHTML = stall.description;
    likes.innerHTML = stall.likes;
    if (stall.image != 'default.jpg') {
        image.setAttribute("src", "/public/uploads/stalls/" + stall.id + '/' + stall.image);
    } else {
        image.setAttribute("src", "/public/uploads/stalls/" + stall.image);
    }


    addStallCategories(stall.categories, categories);

    offersContainer.appendChild(clonedTemplate);

}