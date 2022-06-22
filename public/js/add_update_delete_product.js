document.querySelector("#show-add-product-form").addEventListener("click", function () {
    document.querySelector("#addProductForm").classList.add("active");
});

document.querySelectorAll(".update-product").forEach(btn => btn.addEventListener("click", function () {
    document.querySelector("#updateProductForm").classList.add("active");
    console.log(this.parentElement.getAttribute('id'));
    document.querySelector("#updateProductForm > form > input[name = 'name']").value = this.parentElement.querySelector("h3").innerHTML;
    document.querySelector("#updateProductForm > form > img").setAttribute('src', this.parentElement.querySelector("img").getAttribute('src'));
    document.querySelector("#updateProductForm > form > input[name = 'price']").value = parseFloat(this.parentElement.querySelector(".price").innerHTML.split('\$')[1]);
    document.querySelector("#updateProductForm > form > textarea[name = 'description']").value = this.parentElement.querySelector("p").innerHTML;
    document.querySelector("#updateProductForm > form > input[name = 'id']").value = this.parentElement.getAttribute('id');

}));

document.querySelectorAll(".popup .close-btn").forEach(btn => btn.addEventListener("click", function () {
    document.querySelectorAll(".popup").forEach(form => form.classList.remove("active"));
}));