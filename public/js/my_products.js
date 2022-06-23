document.querySelector("#show-add-product-form").addEventListener("click", function () {
    document.querySelector("#addProductForm").classList.add("active");
});

document.querySelectorAll(".update-product").forEach(btn => btn.addEventListener("click", function () {
    document.querySelector("#updateProductForm").classList.add("active");
}));

document.querySelector(".popup .close-btn").addEventListener("click", function () {
    document.querySelector(".popup").classList.remove("active");
});

// document.querySelector(".top-container input[type='checkbox']").addEventListener("change", function () {
//     if (document.querySelector(".top-container  input[type='checkbox']").checked) {
//         document.querySelector('.stall-visibility-text').innerHTML = "Public Stall";
//     } else {
//         document.querySelector('.stall-visibility-text').innerHTML = "Private Stall";
//     }
//
// });