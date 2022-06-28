const likeButtons = document.querySelectorAll('.mif-heart');

function giveLike() {
    const likes = this.parentElement.nextSibling.nextSibling;
    const container = likes.parentElement.parentElement;
    const id = container.getAttribute('id');
    const heart = this;
    console.log(likes, container, id)

    fetch(`/like/${id}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(function (response) {
            console.log(response)
            return response.json();
        }).then(function(data) {
            console.log(data);
            if (data['isLike']) {
                likes.innerHTML = parseInt(likes.innerHTML) + 1;
                heart.classList.remove('not-liked');
                heart.classList.add('liked');
            } else {
                likes.innerHTML = parseInt(likes.innerHTML) - 1;
                heart.classList.remove('liked');
                heart.classList.add('not-liked');
            }
        })
}

likeButtons.forEach(btn => btn.addEventListener('click', giveLike));
