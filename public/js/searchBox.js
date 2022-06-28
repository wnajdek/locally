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
        }).then(function (data) {
            offersContainer.innerHTML = "";
            loadStalls(data);
        })
    }
})

function createStallTileUserInfo(users) {
    let template = document.querySelector("#user-info-template");

    for (let [stallId, user] of Object.entries(users)) {
        // console.log(`${stallId}: ${user}`);
        let clonedTemplate = template.content.cloneNode(true);

        clonedTemplate.querySelector('h2').innerHTML = user.firstName + ' ' + user.lastName;
        clonedTemplate.querySelector('.email').innerHTML = '<strong>Email: </strong> ' + user.email;
        clonedTemplate.querySelector('.phone').innerHTML = '<strong>Phone: </strong> ' + user.phoneNumber.replace(/(?!^)(?=(?:\d{3})+(?:\.|$))/gm, ' ');
        clonedTemplate.querySelector('.address').innerHTML = '<strong>Address: </strong> ' + user.mainAddress + ', '
            + user.postalCode + ' ' + user.city;

        clonedTemplate.querySelector('.owner-photo img').setAttribute("src", "/public/uploads/users/" + user.email + '/' + user.image);

        document.getElementById(stallId).appendChild(clonedTemplate)
    }
}

function loadStalls(data) {
    data.stalls.forEach(stall => {
        createStallTile(stall);
    })

    createStallTileUserInfo(data.users);

}

function createStallTile(stall) {
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

    clonedTemplate.querySelector('.tile-button').addEventListener('click', function() {
        window.location.href = 'market/' + stall.id;
    });

    offersContainer.appendChild(clonedTemplate);

}
