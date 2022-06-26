function addProduct() {
    const toSend = new FormData();
    toSend.append('name', document.querySelector("#addProductForm > form > input[name = 'name']").value);
    toSend.append('image', document.querySelector("#addProductForm > form > input[name = 'image']").files[0]);
    toSend.append('description', document.querySelector("#addProductForm > form > textarea[name = 'description']").value);
    toSend.append('price', parseFloat(document.querySelector("#addProductForm > form > input[name = 'price']").value));


    fetch(`/addProduct`, {
        method: "POST",
        body: toSend
    }).then(function (response) {
        return response.json();
    }).then(createProductAfterFetch)
}

function updateProduct() {

    const toSend = new FormData();
    toSend.append('name', document.querySelector("#updateProductForm > form > input[name = 'name']").value);
    toSend.append('image', document.querySelector("#updateProductForm > form > input[name = 'image']").files[0]);
    toSend.append('description', document.querySelector("#updateProductForm > form > textarea[name = 'description']").value);
    toSend.append('price', parseFloat(document.querySelector("#updateProductForm > form > input[name = 'price']").value));
    toSend.append('id', parseInt(document.querySelector("#updateProductForm > form > input[name = 'id']").value));


    fetch(`/updateProduct`, {
        method: "POST",
        body: toSend
    }).then(function (response) {
        return response.json();
    }).then(updateProductAfterFetch)
}

document.querySelector("#show-add-product-form").addEventListener("click", function () {
    document.querySelector("#addProductForm").classList.add("active");
    document.querySelector("#addProductForm > form > button").addEventListener('click', addProduct);
});

document.querySelectorAll(".update-product").forEach(onUpdateButtonClick);

function onUpdateButtonClick(btn) {
    return btn.addEventListener("click", function () {
        document.querySelector("#updateProductForm").classList.add("active");
        console.log(this.parentElement.getAttribute('id'));
        document.querySelector("#updateProductForm > form > input[name = 'name']").value = this.parentElement.querySelector("h3").innerHTML;
        document.querySelector("#updateProductForm > form > img").setAttribute('src', this.parentElement.querySelector("img").getAttribute('src'));
        document.querySelector("#updateProductForm > form > input[name = 'price']").value = parseFloat(this.parentElement.querySelector(".price").innerHTML.split('\$')[1]);
        document.querySelector("#updateProductForm > form > textarea[name = 'description']").value = this.parentElement.querySelector("p").innerHTML;
        document.querySelector("#updateProductForm > form > input[name = 'id']").value = this.parentElement.getAttribute('id');
        document.querySelector("#updateProductForm > form > button").addEventListener('click', updateProduct);
    });
}

document.querySelectorAll(".delete-product").forEach(onDeleteButtonClick);

function onDeleteButtonClick(btn) {
    return btn.addEventListener("click", function () {
        document.querySelector("#deleteConfirmForm").classList.add("active");
        console.log(this.parentElement.getAttribute('id'));
        document.querySelector("#deleteConfirmForm > form > input[name = 'id']").value = this.parentElement.getAttribute('id');
    });
}

document.querySelector(".popup #btn-cancel").addEventListener("click", function () {
    document.querySelector("#deleteConfirmForm").classList.remove("active");
});

document.querySelectorAll(".popup .close-btn").forEach(btn => btn.addEventListener("click", function () {
    document.querySelectorAll(".popup").forEach(form => form.classList.remove("active"));
}));

function createProductAfterFetch(product) {
    let template = document.querySelector("#product-template");

    let clonedTemplate = template.content.cloneNode(true);

    let productTile = clonedTemplate.querySelector("#product");
    let productImage = clonedTemplate.querySelector("#product img")
    let productName = clonedTemplate.querySelector('.product-content h3');
    let productDescription = clonedTemplate.querySelector(".product-content .desc");
    let productPrice = clonedTemplate.querySelector(".product-content .price");

    productTile.setAttribute('id', product.id)
    productImage.setAttribute("src", "/public/uploads/products/" + product.stallId + '/' + product.image);
    productName.innerHTML = product.name;
    productDescription.innerHTML = product.description;
    productPrice.innerHTML = "Price: $" + product.price;

    if (document.querySelector("#btn-change-image")) {
        let btnTemplate = document.querySelector("#product-buttons-template");
        let clonedBtnTemplate = btnTemplate.content.cloneNode(true);

        onUpdateButtonClick(clonedBtnTemplate.querySelector('.update-product'));
        onDeleteButtonClick(clonedBtnTemplate.querySelector('.delete-product'));

        productTile.appendChild(clonedBtnTemplate);
    }

    document.querySelector(".my-offer-container").appendChild(clonedTemplate);
    document.querySelector("#addProductForm").classList.remove("active");
}

function updateProductAfterFetch(product) {
    let productTile = document.getElementById(product.id);
    let productImage = productTile.querySelector("img")
    let productName = productTile.querySelector('.product-content h3');
    let productDescription = productTile.querySelector(".product-content .desc");
    let productPrice = productTile.querySelector(".product-content .price");

    productImage.setAttribute("src", "/public/uploads/products/" + product.stallId + '/' + product.image);
    productName.innerHTML = product.name;
    productDescription.innerHTML = product.description;
    productPrice.innerHTML = "Price: $" + product.price;

    document.querySelector("#updateProductForm").classList.remove("active");
}