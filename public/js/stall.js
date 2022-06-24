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


let descriptionHeight = document.querySelector(".description-container").getBoundingClientRect().height;
document.querySelector(".my-offer-container").style.height = 'calc(100% - ' + descriptionHeight + 'px)';
document.querySelector(".owner-info-container").style.height = 'calc(100% - ' + descriptionHeight + 'px)';


document.querySelector('#btn-change-image').addEventListener('click', function () {
    document.querySelector("#changeImage").classList.add("active");
});

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
