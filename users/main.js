// MAIN USER alerts
const mainSuccessAlert = document.getElementById("main-success-alert");
const mainWarningAlert = document.getElementById("main-warning-alert");
function successAlert(obj = {}) {
    let title = obj.title ?? "Title";
    let message = obj.message ?? "Your message goes here";
    let timeout = obj.timeout ?? 5000;

    let titleOut = document.getElementById("main-success-alert-title");
    let msgOut = document.getElementById("main-success-alert-message");

    titleOut.textContent = title;
    msgOut.textContent = message;

    mainSuccessAlert.show();
    let hideTimeout = setTimeout(function() {
        mainSuccessAlert.hide(function() {
            titleOut.textContent = "";
            msgOut.textContent = "";
        });
        clearTimeout(hideTimeout);
    }, timeout);
}

function warningAlert(obj = {}) {
    let title = obj.title ?? "Title";
    let message = obj.message ?? "Your message goes here";
    let timeout = obj.timeout ?? 5000;

    let titleOut = document.getElementById("main-warning-alert-title");
    let msgOut = document.getElementById("main-warning-alert-message");

    titleOut.textContent = title;
    msgOut.textContent = message;

    mainWarningAlert.show();
    let hideTimeout = setTimeout(function () {
        mainWarningAlert.hide(function() {
            titleOut.textContent = "";
            msgOut.textContent = "";
        });
        clearTimeout(hideTimeout);
    }, timeout);
}


let userTableLoaded = false;
let _page = document.getElementById("main-page-input");
let dataSets = false;

const datasetSelect = document.getElementById("dataset-select");

const mainContentSection = document.getElementById("main-content-section");
const userTableBody = document.getElementById("user-table-body");
const userTableFooter = document.getElementById("user-table-footer");

let userTableLoadTimeout = setTimeout(() => {
    if (userTableLoaded === false) {
        userTableBody.innerHTML =   `<tr role="row">
                                        <td colspan="5" class="text-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">lädt...</span>
                                            </div>
                                        </td>
                                    </tr>`;
        $(mainContentSection).fadeIn();
    }
}, 300);

function setDatatests() {
    _page.value = 1;
    dataSets = parseInt(datasetSelect.value);
    pgFetchUserTable(1);
}
datasetSelect.addEventListener("change", setDatatests, false);

function enableTableClickability() {
    $('tr.table-row-clickable').click(function(e) {
        e.preventDefault();

        // create accordion variables
        var tableClickable = $(this);
        var tableCollapsed = tableClickable.next('tr.table-row-collapsed');

        // toggle accordion link open class
        tableClickable.toggleClass("open");
        // toggle accordion content
        tableCollapsed.toggle(150);
    });
}

// initialize user table
$(document).ready(function() {
    pgFetchUserTable();
});
function pgFetchUserTable(pg, active = undefined) {
    let page;
    if (pg !== undefined) {
        page = pg;
        _page.value = page;
    } else {
        page = _page.value;
    }

    // disable link buttons
    let buttons = userTableFooter.getElementsByTagName("button");
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].disabled = true;
    }

    let data;

    if (dataSets !== false) {
        data = {
            "page": parseInt(page),
            "dataset": parseInt(dataSets)
        }
    } else {
        data = {
            "page": parseInt(page)
        };
    }

    let x = new xhr();
    x.post("POST", "../assets/server/fetch_user_table/", rsp => {
        userTableLoaded = true;
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            userTableBody.innerHTML = '<tr><td colspan="5">Ein unbekannter Fehler ist beim holen der Tabellendaten aufgetreten. Versuchen Sie die Daten erneut zu laden, indem Sie die Seite neu laden oder melden Sie sich beim Admin.</td></tr>';
            return false;
        }

        if (re.status === true) {
            userTableBody.innerHTML = "";
            userTableFooter.innerHTML = "";
            for (x in re.data) {
                let trClickable = document.createElement("tr");
                trClickable.setAttribute("role", "row");
                (active === parseInt(re.data[x].id)) ? trClickable.setAttribute("class", "table-row-clickable open") : trClickable.setAttribute("class", "table-row-clickable");
                // NOTICE: Changing the last <td> element in this section will cause fatal errors !
                trClickable.innerHTML = `<td>` + re.data[x].firstname + `</td>
                                        <td>` + re.data[x].lastname + `</td>
                                        <td>` + re.data[x].username + `</td>
                                        <td>` + re.data[x].email + `</td>
                                        <td class="text-center user-table-action-column">
                                            <button title="Rechte bearbeiten" class="btn btn-primary btn-sm mr-3" onclick="userFetchUpdateValues(event, this)"><i class="fas fa-user-cog"></i></button>
                                            <button title="Benutzer blockieren" class="btn btn-warning btn-sm mr-3" onclick="fetchUserBlockValues(event, this)"><i class="fas fa-user-slash"></i></button>
                                            <button title="Benutzer löschen" class="btn btn-danger btn-sm" onclick="fetchUserDeleteValues(event, this)"><i class="fas fa-trash-alt"></i></button>
                                            <input type="hidden" value="` + re.data[x].id + `" class="ipt-user-forbid-action" disabled>
                                        </td>`;
                
                // assign right icons
                let userRights, adRights, addressRights, policyRights, ipRights, newsletterRights;
                let successIcon = '<span class="text-success"><i class="far fa-check-circle"></i></span>';
                let blockedIcon = '<span class="text-danger"><i class="far fa-times-circle"></i></span>';
                userRights = (re.data[x].user_rights) ? successIcon : blockedIcon;
                adRights = (re.data[x].ad_rights) ? successIcon : blockedIcon;
                addressRights = (re.data[x].address_rights) ? successIcon : blockedIcon;
                policyRights = (re.data[x].policy_rights) ? successIcon : blockedIcon;
                ipRights = (re.data[x].ip_rights) ? successIcon : blockedIcon;
                newsletterRights = (re.data[x].newsletter_rights) ? successIcon : blockedIcon;

                let trCollapsed = document.createElement("tr");
                trCollapsed.setAttribute("class", "table-row-collapsed");
                if (active === parseInt(re.data[x].id)) { trCollapsed.setAttribute("style", "display: table-row;") };
                trCollapsed.innerHTML = `<td colspan="3">
                                            <h5 class="mt-2">` + re.data[x].firstname + ` ` + re.data[x].lastname + `</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div>Vorname</div>
                                                    <div class="text-dark">` + re.data[x].firstname + `</div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div>Nachname</div>
                                                    <div class="text-dark">` + re.data[x].lastname + `</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div>Benutzername</div>
                                                    <div class="text-dark">` + re.data[x].username + `</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div>E-Mail</div>
                                                    <div class="text-dark">` + re.data[x].email + `</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            <h5 class="mt-2">Rechte</h5>
                                            <hr>
                                            <table class="table table-borderless">
                                                <tr class="users-subtable">
                                                    <td>Benutzer</td>
                                                    <td>` + userRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>Inserate</td>
                                                    <td>` + adRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>Adressen</td>
                                                    <td>` + addressRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>Richtlinien</td>
                                                    <td>` + policyRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>IP-Adresse</td>
                                                    <td>` + ipRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>Newsletter</td>
                                                    <td>` + newsletterRights + `</td>
                                                </tr>
                                            </table>
                                        </td>`;


                userTableBody.appendChild(trClickable);
                userTableBody.appendChild(trCollapsed);
            }

            let trFoot = document.createElement("tr");

            if (re.links.previous === false) {
                trFoot.innerHTML = `<td colspan="5">
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center mt-1 mb-1">
                    <li class="page-item disabled">
                      <button class="page-link">&laquo;</button>
                    </li>
                    <li class="page-item disabled"><button class="page-link">` + re.page + ` / ` + re.links.last + `</button></li>
                    <li class="page-item">
                      <button class="page-link" onclick="pgFetchUserTable(` + re.links.next + `)">&raquo;</button>
                    </li>
                    <li class="page-item disabled">
                      <button class="page-link">...</button>
                    </li>
                    <li class="page-item">
                      <button class="page-link" onclick="pgFetchUserTable(` + re.links.last + `)">` + re.links.last + `</button>
                    </li>
                  </ul>
                </nav>
              </td>`;
              } else if (re.links.next === false) {
                trFoot.innerHTML = `<td colspan="5">
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center mt-1 mb-1">
                    <li class="page-item">
                      <button class="page-link" onclick="pgFetchUserTable(` + re.links.start + `)">` + re.links.start + `</button>
                    </li>
                    <li class="page-item disabled">
                      <button class="page-link">...</button>
                    </li>
                    <li class="page-item">
                      <button class="page-link" onclick="pgFetchUserTable(` + re.links.previous + `)">&laquo;</button>
                    </li>
                    <li class="page-item disabled"><button class="page-link">` + re.page + ` / ` + re.links.last + `</button></li>
                    <li class="page-item disabled">
                      <button class="page-link">&raquo;</button>
                    </li>
                  </ul>
                </nav>
              </td>`;
              } else {
                trFoot.innerHTML = `<td colspan="5">
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center mt-1 mb-1">
                    <li class="page-item">
                      <button class="page-link" onclick="pgFetchUserTable(` + re.links.start + `)">` + re.links.start + `</button>
                    </li>
                    <li class="page-item disabled">
                      <button class="page-link">...</button>
                    </li>
                    <li class="page-item">
                      <button class="page-link" onclick="pgFetchUserTable(` + re.links.previous + `)">&laquo;</button>
                    </li>
                    <li class="page-item disabled"><button class="page-link">` + re.page + ` / ` + re.links.last + `</button></li>
                    <li class="page-item">
                      <button class="page-link" onclick="pgFetchUserTable(` + re.links.next + `)">&raquo;</button>
                    </li>
                    <li class="page-item disabled">
                      <button class="page-link">...</button>
                    </li>
                    <li class="page-item">
                      <button class="page-link" onclick="pgFetchUserTable(` + re.links.last + `)">` + re.links.last + `</button>
                    </li>
                  </ul>
                </nav>
              </td>`;
              }

              if (!re.links.previous && !re.links.next) {
                trFoot.innerHTML = `<td colspan="5">
                <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center mt-1 mb-1">
                    <li class="page-item disabled"><button class="page-link">` + re.page + ` / ` + re.page + `</button></li>
                  </ul>
                </nav>
              </td>`;
              }

              userTableFooter.appendChild(trFoot);

            // enable link buttons once content is loaded
            let buttons = userTableFooter.getElementsByTagName("button");
            for (let i = 0; i < buttons.length; i++) {
                buttons[i].disabled = false;
            }

            enableTableClickability();
            userForbidAction();
        } else {
            userTableBody.innerHTML = '<tr><td colspan="5">Es sind keine Benutzer vorhanden...</td></tr>';
        }

        $(mainContentSection).fadeIn();
        
    }, data);
}




// CREATE USER
const newUserForm = document.getElementById("new-user-form");

// new user inputs
const newFirstnameInput = document.getElementById("new-user-firstname-input");
const newLastnameInput = document.getElementById("new-user-lastname-input");
const newUsernameInput = document.getElementById("new-user-username-input");
const newEmailInput = document.getElementById("new-user-email-input");
const newPasswordInput = document.getElementById("new-user-password-input");
const newPasswordRepeatInput = document.getElementById("new-user-password-repeat-input");

// new user rights
const newUserRights = document.getElementById("user-rights-switch");
const newAdRights = document.getElementById("user-ads-switch");
const newAddressRights = document.getElementById("user-address-switch");
const newTermsRights = document.getElementById("user-terms-switch");
const newIpRights = document.getElementById("user-ip-switch");
const newNewsletterRights = document.getElementById("user-newsletter-switch");

// new user error alert
const newUserErrorAlert = document.getElementById("new-user-error-alert");
const newUserErrorTitle = document.getElementById("new-user-error-title");
const newUserErrorMessage = document.getElementById("new-user-error-message");

$('#new-user-modal').on('hidden.bs.modal', () => {
    resetNewUserForm();
});

function resetNewUserForm() {
    newFirstnameInput.classList.remove("is-invalid");
    newLastnameInput.classList.remove("is-invalid");
    newUsernameInput.classList.remove("is-invalid");
    newEmailInput.classList.remove("is-invalid");
    newPasswordInput.classList.remove("is-invalid");
    newPasswordRepeatInput.classList.remove("is-invalid");
    newUserErrorAlert.hide(function() {
        newUserErrorTitle.textContent = "";
        newUserErrorMessage.textContent = "";
    });
    newUserErrorAlert.setAttribute("hidden", true);
    newUserForm.reset();
}

function newUserFormSubmit(e) {
    e.preventDefault();
    let userRights, adRights, addressRights, termsRights, ipRights, newsletterRights;

    // reset error indications
    newFirstnameInput.classList.remove("is-invalid");
    newLastnameInput.classList.remove("is-invalid");
    newUsernameInput.classList.remove("is-invalid");
    newEmailInput.classList.remove("is-invalid");
    newPasswordInput.classList.remove("is-invalid");
    newPasswordRepeatInput.classList.remove("is-invalid");

    newUserErrorAlert.hide(function() {
    newUserErrorTitle.textContent = "";
    newUserErrorMessage.textContent = "";
    });

    // convert switches to boolean values
    userRights = (newUserRights.checked) ? true : false;
    adRights = (newAdRights.checked) ? true : false;
    addressRights = (newAddressRights.checked) ? true : false;
    termsRights = (newTermsRights.checked) ? true : false;
    ipRights = (newIpRights.checked) ? true : false;
    newsletterRights = (newNewsletterRights.checked) ? true : false;

    let rawData = {
        firstname: newFirstnameInput.value,
        lastname: newLastnameInput.value,
        username: newUsernameInput.value,
        email: newEmailInput.value,
        password: newPasswordInput.value,
        password_repeat: newPasswordRepeatInput.value,
        rights: {
            user_rights: userRights,
            ad_rights: adRights,
            address_rights: addressRights,
            terms_rights: termsRights,
            ip_rights: ipRights,
            newsletter_rights: newsletterRights
        }
    };

    let data = {
        values: JSON.stringify(rawData)
    };

    let x = new xhr();
    x.post("POST", "../assets/server/create_user/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            newUserErrorTitle.textContent = "Unbekannter Fehler";
            newUserErrorMessage.textContent = "Ein unbekannter Fehler ist aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin.";
            newUserErrorAlert.show();
            return false;
        }

        if (re.status === true) {
            pgFetchUserTable(parseInt(_page.value));
            $("#new-user-modal").modal("hide");
            resetNewUserForm();
        } else {
            newUserErrorTitle.textContent = re.title;
            newUserErrorMessage.textContent = re.msg;
            newUserErrorAlert.show();

            if (re.type == "empty") {
                if (newFirstnameInput.value == "") {
                    newFirstnameInput.classList.add("is-invalid");
                }
                if (newLastnameInput.value == "") {
                    newLastnameInput.classList.add("is-invalid");
                }
                if (newUsernameInput.value == "") {
                    newUsernameInput.classList.add("is-invalid");
                }
                if (newEmailInput.value == "") {
                    newEmailInput.classList.add("is-invalid");
                }
                if (newPasswordInput.value == "") {
                    newPasswordInput.classList.add("is-invalid");
                }
                if (newPasswordRepeatInput.value == "") {
                    newPasswordRepeatInput.classList.add("is-invalid");
                }
            }

            if (re.type == "email") {
                newEmailInput.classList.add("is-invalid");
            }

            if (re.type == "password") {
                newPasswordInput.classList.add("is-invalid");
                newPasswordRepeatInput.classList.add("is-invalid");
            }

            if (re.type == "username") {
                newUsernameInput.classList.add("is-invalid");
            }
        }
    }, data);
}

newUserForm.addEventListener("submit", newUserFormSubmit, false);




// UPDATE USER RIGHTS
const updateUserRightsForm = document.getElementById("update-user-rights-form");

const updateUserFirstnameOut = document.getElementById("update-user-firstname-output");
const updateUserLastnameOut = document.getElementById("update-user-lastname-output");
const updateUserUsernameOut = document.getElementById("update-user-username-output");
const updateUserEmailOut = document.getElementById("update-user-email-output");

const updateUsersUserSwitch = document.getElementById("update-users-user-switch");
const updateAdsUserSwitch = document.getElementById("update-ads-user-switch");
const updateAddressUserSwitch = document.getElementById("update-address-user-switch");
const updateTermsUserSwitch = document.getElementById("update-terms-user-switch");
const updateIpUsersSwitch = document.getElementById("update-ip-user-switch");
const updateNewsletterUsersSwitch = document.getElementById("update-newsletter-user-switch");

// function to fully reset modal
function updateUserModalReset() {
    updateUserFirstnameOut.textContent = "";
    updateUserLastnameOut.textContent = "";
    updateUserUsernameOut.textContent = "";
    updateUserEmailOut.textContent = "";

    updateUsersUserSwitch.checked = false;
    updateUsersUserSwitch.blur();
    updateAdsUserSwitch.checked = false;
    updateAdsUserSwitch.blur();
    updateAddressUserSwitch.checked = false;
    updateAddressUserSwitch.blur();
    updateTermsUserSwitch.checked = false;
    updateTermsUserSwitch.blur();
    updateIpUsersSwitch.checked = false;
    updateIpUsersSwitch.blur();
    updateNewsletterUsersSwitch.checked = false;
    updateNewsletterUsersSwitch.blur();

    let forbid = updateUserRightsForm.getElementsByClassName("ipt-user-forbid-action")[0];
    forbid.value = "";

    updateUserRightsSubmitBtn.removeAttribute("data-action");
    updateUserRightsSubmitBtn.removeAttribute("data-string");
    updateUserRightsSubmitBtn.disabled = true;
}

// reset update user form once modal was closed
$("#update-user-modal").on("hidden.bs.modal", function() {
    updateUserModalReset();
});

function userFetchUpdateValues(e, el, search = undefined) {
    e.stopImmediatePropagation();
    let parent = el.parentElement;
    let id = parseInt(parent.getElementsByTagName("input")[0].value);

    if (search !== undefined) {
        updateUserRightsSubmitBtn.dataset.action = "search";
        updateUserRightsSubmitBtn.dataset.string = search;
    }

    let data = {
        id: id
    }

    let x = new xhr();
    x.post("POST", "../assets/server/fetch_single_user/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            warningAlert({
                title: "Unbekannter Fehler",
                message: "Ein unbekannter Fehler ist aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin."
            });
            return false;
        }

        let forbid = updateUserRightsForm.getElementsByClassName("ipt-user-forbid-action")[0];
        forbid.value = re.id;

        updateUserFirstnameOut.textContent = re.firstname;
        updateUserLastnameOut.textContent = re.lastname;
        updateUserUsernameOut.textContent = re.username;
        updateUserEmailOut.textContent = re.email;

        // assign rights
        let userRights, adRights, addressRights, policyRights, ipRights, newsletterRights;
        userRights = (re["user_rights"]) ? true : false;
        adRights = (re["ad_rights"]) ? true : false;
        addressRights = (re["address_rights"]) ? true : false;
        policyRights = (re["policy_rights"]) ? true : false;
        ipRights = (re["ip_rights"]) ? true : false;
        newsletterRights = (re["newsletter_rights"]) ? true : false;

        updateUsersUserSwitch.checked = userRights;
        updateAdsUserSwitch.checked = adRights;
        updateAddressUserSwitch.checked = addressRights;
        updateTermsUserSwitch.checked = policyRights;
        updateIpUsersSwitch.checked = ipRights;
        updateNewsletterUsersSwitch.checked = newsletterRights;

        $("#update-user-modal").modal("show");

    }, data);
}



const updateUserRightsSubmitBtn = document.getElementById("update-user-rights-submit-btn");

const updateErrorAlert = document.getElementById("update-error-alert");
const updateErrorAlertTitle = document.getElementById("update-error-alert-title");
const updateErrorAlertMessage = document.getElementById("update-error-alert-message");

function userUpdateRights(e) {
    e.preventDefault();

    updateUserRightsSubmitBtn.disabled = true;

    // check if user searched for something
    let search = undefined;
    if (updateUserRightsSubmitBtn.dataset.action && updateUserRightsSubmitBtn.dataset.string) {
        search = updateUserRightsSubmitBtn.dataset.string;
    }

    // reset modal errors
    updateErrorAlert.hide(function() {
        updateErrorAlertTitle.textContent = "";
        updateErrorAlertMessage.textContent = "";
    });

    // convert switches to boolean values
    let userRights, adRights, addressRights, policyRights, ipRights, newsletterRights;
    userRights = (updateUsersUserSwitch.checked) ? true : false;
    adRights = (updateAdsUserSwitch.checked) ? true : false;
    addressRights = (updateAddressUserSwitch.checked) ? true : false;
    policyRights = (updateTermsUserSwitch.checked) ? true : false;
    ipRights = (updateIpUsersSwitch.checked) ? true : false;
    newsletterRights = (updateNewsletterUsersSwitch.checked) ? true : false;

    let forbid = updateUserRightsForm.getElementsByClassName("ipt-user-forbid-action")[0].value;
    let id = parseInt(forbid);
    
    let rawData = {
            user_rights: userRights,
            ad_rights: adRights,
            address_rights: addressRights,
            policy_rights: policyRights,
            ip_rights: ipRights,
            newsletter_rights: newsletterRights
    };

    let data = {
        id: parseInt(id),
        firstname: updateUserFirstnameOut.textContent,
        lastname: updateUserLastnameOut.textContent,
        rights: JSON.stringify(rawData)
    };

    let x = new xhr();
    x.post("POST", "../assets/server/admin.update_user/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            updateErrorAlertTitle.textContent = "Unbekannter Fehler";
            updateErrorAlertMessage.textContent = "Ein unbekannter Fehler ist aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin.";
            updateErrorAlert.show();
            return false;
        }

        if (re.status === true) {
            $("#update-user-modal").modal("hide");
            successAlert({
                title: re.title,
                message: re.msg
            });
            if (search === undefined) {
                pgFetchUserTable(_page.value, id);
            } else {
                searchUser(e, search);
            }
        } else {
            updateErrorAlertTitle.textContent = re.title;
            updateErrorAlertMessage.textContent = re.msg;
            updateErrorAlert.show();
        }

        updateUserRightsSubmitBtn.disabled = false;
    }, data);
}
updateUserRightsForm.addEventListener("submit", userUpdateRights, false);

// determine if update changes were made
// and enable update button, if so
function enableUpdateButton() {
    updateUserRightsSubmitBtn.disabled = false;
}
updateUsersUserSwitch.addEventListener("change", enableUpdateButton, false);
updateAdsUserSwitch.addEventListener("change", enableUpdateButton, false);
updateAddressUserSwitch.addEventListener("change", enableUpdateButton, false);
updateTermsUserSwitch.addEventListener("change", enableUpdateButton, false);
updateIpUsersSwitch.addEventListener("change", enableUpdateButton, false);
updateNewsletterUsersSwitch.addEventListener("change", enableUpdateButton, false);



// BLOCK USER RIGHTS
const blockUserModal = document.getElementById("block-user-modal");
const blockUserMessage = document.getElementById("block-user-message");
const blockUserSubmitBtn = document.getElementById("block-user-submit-btn");

function clearUserBlockModal() {
    blockUserMessage.textContent = "";
    let forbid = blockUserModal.getElementsByClassName("ipt-user-forbid-action")[0];
    forbid.value = "";
}
$(blockUserModal).on("hidden.bs.modal", function() {
    clearUserBlockModal();
});

function fetchUserBlockValues(e, el, search = undefined) {
    e.stopImmediatePropagation();
    let parent = el.parentElement;
    let id = parseInt(parent.getElementsByTagName("input")[0].value);

    if (search !== undefined) {
        blockUserSubmitBtn.dataset.action = "search";
        blockUserSubmitBtn.dataset.string = search;
    }

    let data = {
        id: id
    };

    let x = new xhr();
    x.post("POST", "../assets/server/fetch_single_user/", (rsp) => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            warningAlert({
                title: "Unbekannter Fehler",
                message: "Beim holen der Daten ist ein unbekannter Fehler aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin."
            });
            return false;
        }

        let forbid = blockUserModal.getElementsByClassName("ipt-user-forbid-action")[0];
        forbid.value = re.id;

        blockUserMessage.textContent = "Sollen wirklich alle Rechten von " + re.firstname + " " + re.lastname + " blockiert werden?";

        $(blockUserModal).modal("show");
    }, data);
}

function userBlockRights() {
    let forbid = blockUserModal.getElementsByClassName("ipt-user-forbid-action")[0];
    let id = parseInt(forbid.value);

    // check if user searched for something
    let search = undefined;
    if (blockUserSubmitBtn.dataset.action && blockUserSubmitBtn.dataset.string) {
        search = blockUserSubmitBtn.dataset.string;
    }
    
    let data = {
        id: id
    }

    let x = new xhr();
    x.post("POST", "../assets/server/admin.block_user/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            warningAlert({
                title: "Unbekannter Fehler",
                message: "Beim versuch die Rechte eines Benutzers zu ändern ist ein unbekannter Fehler aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin."
            });
            return false;
        }

        if (re.status === true) {
            successAlert({
                title: re.title,
                message: re.msg
            });
            if (search === undefined) {
                pgFetchUserTable(_page.value);
            } else {
                searchUser(undefined, search);
            }
        } else {
            warningAlert({
                title: re.title,
                message: re.msg
            });
        }
    }, data);
}
blockUserSubmitBtn.addEventListener("click", userBlockRights, false);



// DELETE USER
const deleteUserModal = document.getElementById("delete-user-modal");
const deleteUserMessage = document.getElementById("delete-user-message");
const deleteUserSubmitBtn = document.getElementById("delete-user-submit-btn");

function clearUserDeleteModal() {
    deleteUserMessage.textContent = "";
    let forbid = deleteUserModal.getElementsByClassName("ipt-user-forbid-action")[0];
    forbid.value = "";
}
$(deleteUserModal).on("hidden.bs.modal", function() {
    clearUserDeleteModal();
});

function fetchUserDeleteValues(e, el, search = undefined) {
    e.stopImmediatePropagation();
    let parent = el.parentElement;
    let id = parseInt(parent.getElementsByTagName("input")[0].value);

    if (search !== undefined) {
        deleteUserSubmitBtn.dataset.action = "search";
        deleteUserSubmitBtn.dataset.string = search;
    }

    let data = {
        id: id
    };

    let x = new xhr();
    x.post("POST", "../assets/server/fetch_single_user/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch {
            warningAlert({
                title: "Unbekannter Fehler",
                message: "Beim holen der Daten ist ein unbekannter Fehler aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin."
            });
            return false;
        }

        let forbid = deleteUserModal.getElementsByClassName("ipt-user-forbid-action")[0];
        forbid.value = re.id;

        deleteUserMessage.textContent = "Soll " + re.firstname + " " + re.lastname + " wirklich in den Papierkorb verschoben werden?";

        $(deleteUserModal).modal("show");
    }, data);
}

function userDelete() {
    let forbid = deleteUserModal.getElementsByClassName("ipt-user-forbid-action")[0];
    let id = parseInt(forbid.value);

    let search = undefined;
    if (deleteUserSubmitBtn.dataset.action && deleteUserSubmitBtn.dataset.string) {
        search = deleteUserSubmitBtn.dataset.string;
    }

    let data = {
        id: id
    }

    let x = new xhr();
    x.post("POST", "../assets/server/admin.delete_user/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            warningAlert({
                title: "Unbekannter Fehler",
                message: "Beim versuch einen Benutzer zu löschen ist ein unbekannter Fehler aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin."
            });
            return false;
        }

        if (re.status === true) {
            successAlert({
                title: re.title,
                message: re.msg
            });
            if (search === undefined) {
                pgFetchUserTable(_page.value);
            } else {
                searchUser(undefined, search);
            }
        } else {
            warningAlert({
                title: re.title,
                message: re.msg
            });
        }
    }, data);
}
deleteUserSubmitBtn.addEventListener("click", userDelete, false);



// SEARCH USERS
const userSearchForm = document.getElementById("user-search-form");
const userSearchIpt = document.getElementById("user-search-input");
const userSearchSubmit = document.getElementById("user-search-submit");

function resetSearch() {
    if (userSearchIpt.value.length < 1) {
        updateUserRightsSubmitBtn.removeAttribute("data-action");
        updateUserRightsSubmitBtn.removeAttribute("data-string");
        pgFetchUserTable(1);
        datasetSelect.disabled = false;
    }
}
userSearchIpt.addEventListener("keyup", resetSearch, false);

function searchUser(e, search = undefined) {
    if (e !== undefined) {
        e.preventDefault();
    }

    if (userSearchIpt.value.length <= 1)  {
        return false;
    }

    datasetSelect.disabled = true;

    let data;
    if (search === undefined) {
        data = {
            search: userSearchIpt.value
        };
    } else {
        data = {
            search: search
        }
    }
    let searchLoaded = false;

    userTableFooter.innerHTML = "";
    let searchTimeout = setTimeout(() => {
        if (searchLoaded === false) {
            userTableBody.innerHTML = "";
            userTableBody.innerHTML = `<tr role="row">
                                        <td colspan="5" class="text-center">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="sr-only">lädt...</span>
                                            </div>
                                        </td>
                                    </tr>`;
        } else {
            return false;
        }
        clearTimeout(searchTimeout);
    }, 300);

    let x = new xhr();
    x.post("POST", "../assets/server/admin.user_search/", rsp => {
        searchLoaded = true;
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            warningAlert({
                title: "Suche fehlgeschlagen",
                message: "Ein unbekannter Fehler ist beim suchen der Daten aufgetreten. Versuchen Sie die Daten erneut zu laden, indem Sie die Seite neu laden oder melden Sie sich beim Admin."
            });
            return false;
        }

        userTableBody.innerHTML = "";
        userTableFooter.innerHTML = "";
        if (re.status === true) {
            for (x in re.data) {
                let trClickable = document.createElement("tr");
                trClickable.setAttribute("role", "row");
                trClickable.setAttribute("class", "table-row-clickable");
                // NOTICE: Changing the last <td> element in this section will cause fatal errors !
                trClickable.innerHTML = `<td>` + re.data[x].firstname + `</td>
                                        <td>` + re.data[x].lastname + `</td>
                                        <td>` + re.data[x].username + `</td>
                                        <td>` + re.data[x].email + `</td>
                                        <td class="text-center user-table-action-column">
                                            <button title="Rechte bearbeiten" class="btn btn-primary btn-sm mr-3" onclick="userFetchUpdateValues(event, this, '` + userSearchIpt.value + `')"><i class="fas fa-user-cog"></i></button>
                                            <button title="Benutzer sofort blockieren" class="btn btn-warning btn-sm mr-3" onclick="fetchUserBlockValues(event, this, '` + userSearchIpt.value + `')"><i class="fas fa-user-slash"></i></button>
                                            <button title="Benutzer löschen" class="btn btn-danger btn-sm" onclick="fetchUserDeleteValues(event, this, '` + userSearchIpt.value + `')"><i class="fas fa-trash-alt"></i></button>
                                            <input type="hidden" value="` + re.data[x].id + `" class="ipt-user-forbid-action" disabled>
                                        </td>`;
                
                // assign right icons
                let userRights, adRights, addressRights, policyRights, ipRights, newsletterRights;
                let successIcon = '<span class="text-success"><i class="far fa-check-circle"></i></span>';
                let blockedIcon = '<span class="text-danger"><i class="far fa-times-circle"></i></span>';
                userRights = (re.data[x].user_rights) ? successIcon : blockedIcon;
                adRights = (re.data[x].ad_rights) ? successIcon : blockedIcon;
                addressRights = (re.data[x].address_rights) ? successIcon : blockedIcon;
                policyRights = (re.data[x].policy_rights) ? successIcon : blockedIcon;
                ipRights = (re.data[x].ip_rights) ? successIcon : blockedIcon;
                newsletterRights = (re.data[x].newsletter_rights) ? successIcon : blockedIcon;

                let trCollapsed = document.createElement("tr");
                trCollapsed.setAttribute("class", "table-row-collapsed");
                trCollapsed.innerHTML = `<td colspan="3">
                                            <h5 class="mt-2">` + re.data[x].firstname + ` ` + re.data[x].lastname + `</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div>Vorname</div>
                                                    <div class="text-dark">` + re.data[x].firstname + `</div>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div>Nachname</div>
                                                    <div class="text-dark">` + re.data[x].lastname + `</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <div>Benutzername</div>
                                                    <div class="text-dark">` + re.data[x].username + `</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div>E-Mail</div>
                                                    <div class="text-dark">` + re.data[x].email + `</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td colspan="2">
                                            <h5 class="mt-2">Rechte</h5>
                                            <hr>
                                            <table class="table table-borderless">
                                                <tr class="users-subtable">
                                                    <td>Benutzer</td>
                                                    <td>` + userRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>Inserate</td>
                                                    <td>` + adRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>Adressen</td>
                                                    <td>` + addressRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>Richtlinien</td>
                                                    <td>` + policyRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>IP-Adresse</td>
                                                    <td>` + ipRights + `</td>
                                                </tr>
                                                <tr class="users-subtable">
                                                    <td>Newsletter</td>
                                                    <td>` + newsletterRights + `</td>
                                                </tr>
                                            </table>
                                        </td>`;


                userTableBody.appendChild(trClickable);
                userTableBody.appendChild(trCollapsed);
            }
        } else {
            if (re.type === "nof") {
                userTableBody.innerHTML = `<tr><td colspan="5">Keine Einträge gefunden.</td></tr>`;
            }
        }
        enableTableClickability();
        userForbidAction();
        userSearchIpt.focus();
        userSearchIpt.select();
    }, data);
}
userSearchForm.addEventListener("submit", searchUser, false);




// FORBIDDEN
function userForbidAction() {
    $(".ipt-user-forbid-action").each(function() {
        $(this).focus(function() {
            window.location.replace("../logoff/");
        });
    });
}
userForbidAction();