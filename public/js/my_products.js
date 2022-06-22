document.querySelector("#show-add-product-form").addEventListener("click", function () {
    document.querySelector("#addProductForm").classList.add("active");
});

document.querySelectorAll(".update-product").forEach(btn => btn.addEventListener("click", function () {
    document.querySelector("#updateProductForm").classList.add("active");
}));

document.querySelector(".popup .close-btn").addEventListener("click", function () {
    document.querySelector(".popup").classList.remove("active");
});