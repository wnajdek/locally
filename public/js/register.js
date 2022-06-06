const registerForm = document.querySelector("form");
const email = registerForm.querySelector("input[name='email']");
const repeatedPassword = registerForm.querySelector("input[name='passwordRepeat']")

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