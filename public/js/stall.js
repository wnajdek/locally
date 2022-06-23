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


