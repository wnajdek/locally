document.querySelectorAll('.pick-this-user').forEach(simulateUser);

function simulateUser(btn) {
    btn.addEventListener("click", function () {
        let id = this.parentElement.querySelector('.user-id').innerHTML;
        location.href = "/simulateUser/" + id;
    });
}

document.querySelectorAll('.delete-this-user').forEach(deleteUser);

function deleteUser(btn) {
    btn.addEventListener("click", function () {
        let id = this.parentElement.querySelector('.user-id').innerHTML;
        location.href = "/deleteUser/" + id;
    });
}