let form;

if (window.location.href.includes("register")) {
    form = document.querySelector("form");
} else if (window.location.href.includes("user")){
    form = document.querySelector("form[action='/changePassword']");
}

const email = form.querySelector("input[name='email']");
const repeatedPassword = form.querySelector("input[name='passwordRepeat']")

function arePasswordsSame(password, repeatedPassword) {
    return password === repeatedPassword;
}

function validateInput(input, condition) {
    condition ? input.classList.remove('invalid-input') : input.classList.add('invalid-input');
}

repeatedPassword.addEventListener('keyup', validatePassword);

function validatePassword() {
    setTimeout(() => {
            validateInput(
                repeatedPassword,
                arePasswordsSame(repeatedPassword.previousElementSibling.value, repeatedPassword.value)
            )
        },
        500
    );
}