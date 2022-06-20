const likeButtons = document.querySelectorAll('.mif-heart');

function giveLike() {
    const likes = this.parentElement.nextSibling.nextSibling;
    const container = likes.parentElement.parentElement;
    const id = container.getAttribute('id');
    console.log(likes, container, id)

    fetch(`/like/${id}`)
        .then(function() {
            likes.innerHTML = parseInt(likes.innerHTML) + 1;
        })
}

likeButtons.forEach(btn => btn.addEventListener('click', giveLike));
