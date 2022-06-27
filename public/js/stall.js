// private/public toggle
function changeStallVisibility() {
    fetch(`/changeVisibility`)
        .then(function() {
            if (document.querySelector(".top-container  input[type='checkbox']").checked) {
                document.querySelector('.stall-visibility-text').innerHTML = "Public Stall";
            } else {
                document.querySelector('.stall-visibility-text').innerHTML = "Private Stall";
            }
        })
}

document.querySelector(".top-container input[type='checkbox']").addEventListener("change", changeStallVisibility);

// change image on form button click
function changeImage() {
    if(document.querySelector("#changeImage > form > input[name = 'image']").value == "") {
        return;
    }

    const toSend = new FormData();
    toSend.append('id', document.querySelector("#changeImage > form > input[name = 'id']").value);
    toSend.append('image', document.querySelector("#changeImage > form > input[name = 'image']").files[0]);


    fetch(`/changeImage`, {
        method: "POST",
        body: toSend
    }).then(function (response) {
        return response.json();
    }).then(function (stall) {
        document.querySelector('.top-container').style.backgroundImage = 'url(/public/uploads/stalls/'
            + stall.id.toString() + "/" + stall.image;
        document.querySelector("#changeImage").classList.remove('active');
    })
}

document.querySelector('#btn-change-image').addEventListener('click', function () {
    document.querySelector("#changeImage").classList.add("active");
    document.querySelector("#changeImage form button").addEventListener('click', changeImage);
});


// setting height for name and description container
let descriptionHeight = document.querySelector(".description-container").getBoundingClientRect().height;
document.querySelector(".my-offer-container").style.height = 'calc(100% - ' + descriptionHeight + 'px)';
document.querySelector(".owner-info-container").style.height = 'calc(100% - ' + descriptionHeight + 'px)';


// change stall name and description
function changeStallText() {
    const toSend = {
        name: document.querySelector("#changeText > form > input[name = 'name']").value,
        description: document.querySelector("#changeText > form > textarea[name = 'description']").value
    }
    fetch(`/changeText`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(toSend)
    }).then(function (response) {
        return response.json();
    }).then(function(data) {
        document.querySelector('.description-container h2').innerHTML = data.name;
        document.querySelector('.description').innerHTML = data.description;
        document.querySelector("#changeText").classList.remove("active");
    })
}

document.querySelector('#btn-change-text').addEventListener('click', function () {
    document.querySelector("#changeText").classList.add("active");
    document.querySelector("#changeText > form > input[name = 'name']").value = this.parentElement.querySelector("h2").innerHTML;
    document.querySelector("#changeText > form > textarea[name = 'description']").value = this.parentElement.querySelector("p").innerHTML;
    document.querySelector("#changeText > form > button").addEventListener('click', changeStallText);
});



function updateStallCategories() {
    let categoriesArray = [];
    document.querySelectorAll("#changeCategories > form input[name = 'categories[]']")
        .forEach(checkbox => {
            if (checkbox.checked) {
                categoriesArray.push(parseInt(checkbox.value));
            }
        })

    const toSend = {
        categories: categoriesArray
    }
    fetch(`/updateStallCategories`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(toSend)
    }).then(function (response) {
        return response.json();
    }).then(function (data) {
        let categories = document.querySelector('.categories');
        document.querySelector('.categories').innerHTML = '';

        addStallCategories(data, categories);
    }).then(function () {
        document.querySelector("#changeCategories").classList.remove("active");
    });
}

document.querySelector('#btn-change-categories').addEventListener('click', function () {
    document.querySelector("#changeCategories").classList.add("active");
    document.querySelector("#changeCategories > form > button").addEventListener('click', updateStallCategories);
});





