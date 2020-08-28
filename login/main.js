const loginForm = document.getElementById("login-form");
const usernameInput = document.getElementById("username-input");
const passwordInput = document.getElementById("password-input");
const mainSubmitBtn = document.getElementById("main-submit-btn");
const invalidMessage = document.getElementById("invalid-message");


function submitLogin(e) {
    e.preventDefault();

    mainSubmitBtn.disabled = true;
    mainSubmitBtn.innerHTML =  `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span class="sr-only">Loading...</span>`;

    // validation reset
    usernameInput.classList.remove("is-invalid");
    passwordInput.classList.remove("is-invalid");

    let data = {
        username: usernameInput.value,
        password: passwordInput.value
    };
    let x = new xhr();
    x.post("POST", "../assets/server/login/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            loginForm.reset();
            usernameInput.classList.add("is-invalid");
            passwordInput.classList.add("is-invalid");
            invalidMessage.textContent = "Ein unbekannter Fehler ist aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin.";
            return false;
        }
        if (re.status === true) {
            window.location.href = re.url;
        } else {
            passwordInput.value = "";
            invalidMessage.textContent = re.msg;
            mainSubmitBtn.innerHTML = "Anmelden";
            mainSubmitBtn.disabled = false;
            usernameInput.classList.add("is-invalid");
            passwordInput.classList.add("is-invalid");
        }
    }, data);
}

loginForm.addEventListener("submit", submitLogin, false);