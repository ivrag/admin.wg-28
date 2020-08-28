// PROFILE SETTINGS
const profileForm = document.getElementById("profile-form");

// Profile Inputs
const profileFirstnameIpt = document.getElementById("profile-firstname");
const profileLastnameIpt = document.getElementById("profile-lastname");
const profileUsernameIpt = document.getElementById("profile-username");
const profileEmailIpt = document.getElementById("profile-email");
const profileSubmitButton = document.getElementById("profile-submit-btn");

// Profile outputs
const profileFirstnameOut = document.getElementById("profile-firstname-output");
const profileLastnameOut = document.getElementById("profile-lastname-output");
const profileUsernameOut = document.getElementById("profile-username-output");
const profileEmailOut = document.getElementById("profile-email-output");

// Profile error alert
const profileErrorAlert = document.getElementById("profile-error-alert");
const profileErrorTitle = document.getElementById("profile-error-title");
const profileErrorMessage = document.getElementById("profile-error-message");

function profileFormSubmit(e) {
    e.preventDefault();

    profileSubmitButton.disabled = true;

    // reset errors
    profileFirstnameIpt.classList.remove("is-invalid");
    profileLastnameIpt.classList.remove("is-invalid");
    profileUsernameIpt.classList.remove("is-invalid");
    profileEmailIpt.classList.remove("is-invalid");

    profileErrorAlert.hide(function() {
        profileErrorTitle.textContent = "";
        profileErrorMessage.textContent = "";
    });
    profileErrorAlert.removeAttribute("open");

    let data = {
        firstname: profileFirstnameIpt.value,
        lastname: profileLastnameIpt.value,
        username: profileUsernameIpt.value,
        email: profileEmailIpt.value
    }

    let x = new xhr();
    x.post("POST", "../assets/server/user.update_user/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            profileErrorTitle = "Unbekannter Fehler";
            profileErrorMessage = "Ein unbekannter Fehler ist aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin.";
            profileErrorAlert.show();
            return false;
        }

        if (re.status === true) {
            profileFirstnameOut.textContent = re.firstname;
            profileLastnameOut.textContent = re.lastname;
            profileUsernameOut.textContent = re.username;
            profileEmailOut.textContent = re.email;

            profileFirstnameIpt.blur();
            profileLastnameIpt.blur();
            profileUsernameIpt.blur();
            profileEmailIpt.blur();
            profileSubmitButton.disabled = false;

        } else {
            profileErrorTitle.textContent = re.title;
            profileErrorMessage.textContent = re.msg;
            profileErrorAlert.show();
            profileSubmitButton.disabled = false;

            if (re.type == "empty") {
                if (profileFirstnameIpt.value == "") {
                    profileFirstnameIpt.classList.add("is-invalid");
                }
                if (profileLastnameIpt.value == "") {
                    profileLastnameIpt.classList.add("is-invalid");
                }
                if (profileUsernameIpt.value == "") {
                    profileUsernameIpt.classList.add("is-invalid");
                }
                if (profileEmailIpt.value == "") {
                    profileEmailIpt.classList.add("is-invalid");
                }
            }
            if (re.type == "username") {
                profileUsernameIpt.classList.add("is-invalid");
            }
            if (re.type == "email") {
                profileEmailIpt.classList.add("is-invalid");
            }
        }
    }, data);
}

profileForm.addEventListener("submit", profileFormSubmit, false);


// CHANGE PASSWORD
const passwordForm = document.getElementById("password form");

// password inputs
const passwordCurrentIpt = document.getElementById("password-current");
const passwordNewIpt = document.getElementById("password-new");
const passwordRepeatIpt = document.getElementById("password-repeat");
const passwordSubmitBtn = document.getElementById("password-submit-btn");

// password success alert
const passwordSuccessAlert = document.getElementById("success-message-alert");

// password error alert
const passwordErrorAlert = document.getElementById("password-error-alert");
const passwordErrorTitle = document.getElementById("password-error-title");
const passwordErrorMessage = document.getElementById("password-error-message");

function passwordFormSubmit(e) {
    e.preventDefault();

    passwordSubmitBtn.disabled = true;

    // reset errors
    passwordCurrentIpt.classList.remove("is-invalid");
    passwordNewIpt.classList.remove("is-invalid");
    passwordRepeatIpt.classList.remove("is-invalid");

    passwordErrorAlert.hide(function() {
        passwordErrorTitle.textContent = "";
        passwordErrorMessage.textContent = "";
    });
    passwordErrorAlert.removeAttribute("open");

    let data = {
        current_password: passwordCurrentIpt.value,
        new_password: passwordNewIpt.value,
        repeat_password: passwordRepeatIpt.value
    }

    let x = new xhr();
    x.post("POST", "../assets/server/user.update_password/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            passwordErrorTitle = "Unbekannter Fehler";
            passwordErrorMessage = "Ein unbekannter Fehler ist aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin.";
            passwordErrorAlert.show();
            return false;
        }

        if (re.status === true) {
            passwordForm.reset();
            passwordSuccessAlert.innerHTML = `<sl-alert id="sl-pwd-alert" type="success" open closable class="alert-closable mb-3">
                                                <sl-icon slot="icon" name="check2-circle"></sl-icon>
                                                <strong>Passwortänderung erfolgreich</strong><br>
                                                Ihr neues Passwort ist nun <strong>` + re.upd_pwd + `</strong>.
                                            </sl-alert>`;
                                            
            passwordCurrentIpt.blur();
            passwordNewIpt.blur();
            passwordRepeatIpt.blur();
            passwordSubmitBtn.disabled = false;
        } else {
            passwordForm.reset();
            passwordErrorTitle.textContent = re.title;
            passwordErrorMessage.textContent = re.msg;
            passwordErrorAlert.show();

            if (re.type === "empty") {
                if (passwordCurrentIpt.value == "") {
                    passwordCurrentIpt.classList.add("is-invalid");
                }
                if (passwordNewIpt.value == "") {
                    passwordNewIpt.classList.add("is-invalid");
                }
                if (passwordRepeatIpt.value == "") {
                    passwordRepeatIpt.classList.add("is-invalid");
                }
            }
            if (re.type === "comparison") {
                passwordNewIpt.classList.add("is-invalid");
                passwordRepeatIpt.classList.add("is-invalid");
            }
            if (re.type === "length") {
                passwordNewIpt.classList.add("is-invalid");
                passwordRepeatIpt.classList.add("is-invalid");
            }
            if (re.type === "wrong") {
                passwordCurrentIpt.classList.add("is-invalid");
            }

            passwordSubmitBtn.disabled = false;
        }
    }, data);
}

passwordForm.addEventListener("submit", passwordFormSubmit, false);