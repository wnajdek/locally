function addStallCategories(data, categoriesContainer) {
    data.forEach(category => {
        let categoryDiv = document.createElement("div");
        categoryDiv.classList.add("category" + category.id);
        let categoryNameDiv = document.createElement("div");
        categoryNameDiv.classList.add("category-name");
        categoryNameDiv.innerHTML = category.type;

        let categoryIdHiddenDiv = document.createElement("div");
        categoryIdHiddenDiv.classList.add("hidden");
        categoryIdHiddenDiv.innerHTML = category.id;

        categoryDiv.appendChild(categoryNameDiv);
        categoryDiv.appendChild(categoryIdHiddenDiv);

        categoriesContainer.appendChild(categoryDiv);
    });
}