const mainSuccessAlert = document.getElementById("main-success-alert");
const mainWarningAlert = document.getElementById("main-warning-alert");
const confirmAlertSection = document.getElementById("confirm-alert-section");
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

const mainContentSection = document.getElementById("main-content-section");
const delUsersTableBody = document.getElementById("del-users-table-body");

$(document).ready(function() {
    initDelUsers();
});

let delTableLoaded = false;

let delTableLoadTimeout = setTimeout(() => {
    if (delTableLoaded === false) {
        delUsersTableBody.innerHTML = `<tr role="row">
                                        <td colspan="6" class="text-center">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="sr-only">lädt...</span>
                                            </div>
                                        </td>
                                    </tr>`;
        $(mainContentSection).fadeIn();
    }
}, 300);

function initDelUsers() {
    let x = new xhr();
    x.get("POST", "../assets/server/trash/users/fetch/", rsp => {
        delTableLoaded = true;
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            delUsersTableBody.innerHTML = `<tr><td colspan="6">Ein unbekannter Fehler ist beim holen der Tabellendaten aufgetreten. Versuchen Sie die Daten erneut zu laden, indem Sie die Seite neu laden oder melden Sie sich beim Admin.</td></tr>`;
        }

        delUsersTableBody.innerHTML = "";
        if (re.status === undefined) {
            for (i in re) {
                let tr = document.createElement("tr");
    
                tr.innerHTML = `<td>` + re[i].uid + `</td>
                                <td>` + re[i].firstname + `</td>
                                <td>` + re[i].lastname + `</td>
                                <td>` + re[i].username + `</td>
                                <td>` + re[i].email + `</td>
                                <td class="text-center user-table-action-column">
                                    <button class="btn btn-primary mr-2" onclick="regenerateUser('` + re[i].id + `');"><i class="fas fa-sync-alt fa-sm"></i></button>
                                    <button class="btn btn-danger" onclick="fetchBanModalValues('` + re[i].id + `');"><i class="fas fa-ban fa-sm"></i></button>
                                </td>`;
                
                delUsersTableBody.appendChild(tr);
            }
        } else {
            delUsersTableBody.innerHTML = `<tr><td colspan="6">Es sind keine gelöschten Benutzer vorhanden...</td></tr>`;
        }

        $(mainContentSection).fadeIn();
    });
}

function regenerateUser(n) {
    let id = parseInt(n);

    let data = {
        id: id
    };

    let x = new xhr();
    x.post("POST", "../assets/server/trash/users/regenerate/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            warningAlert({
                title: "Fehler",
                message: "Es ist ein unbekannter Fehler beim holen der Daten aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin."
            });
            return false;
        }

        if (re.status === true) {
            let div = document.createElement("div");
            div.innerHTML = `<sl-alert open type="primary" closable class="alert-closable mb-4">
                        <sl-icon slot="icon" name="info-circle"></sl-icon>
                        <strong>Benutzer wiederhergestellt</strong><br>
                        <span>Der Benutzer <strong>` + re.firstname + ` ` + re.lastname + `</strong> wurde wiederhergestellt.</span><br><br>
                        <span>Bitte beachten Sie, dass dem Benutzer ein neues Passwort zugewiesen wurde, sowie alle Benutzerrechte gesperrt wurden.</span><br>
                        <span>Um die Rechte zu ändern, begeben Sie sich in die <a href="../users/">Benutzerrubrik</a> und suchen Sie nach dem Benutzer. Klicken Sie auf Benutzer Bearbeiten.</span><br><br>
                        <span>Benutzername: <strong>` + re.username + `</strong></span><br>
                        <span>Passwort : <strong>` + re.pwd + `</strong></span>
                    </sl-alert>`;
            confirmAlertSection.appendChild(div);
            initDelUsers();
        } else {
            warningAlert({
                title: re.title,
                message: re.msg
            });
        }
    }, data);
}

const banUserModal = document.getElementById("ban-user-modal");
const banUserModalMessage = document.getElementById("ban-user-message");
const banUserModalSubmitBtn = document.getElementById("ban-user-submit-btn");
function fetchBanModalValues(n) {
    let id = parseInt(n);

    let data = {
        id: id
    };

    let x = new xhr();
    x.post("POST", "../assets/server/trash/users/fetch_single/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            warningAlert({
                title: "Fehler",
                message: "Es ist ein unbekannter Fehler beim holen der Daten aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin."
            });
            return false;
        }

        if (re.status === true) {
            banUserModalMessage.innerHTML = `Soll <strong>` + re.firstname + ` ` + re.lastname + `</strong> wirklich für immer gelöscht werden?<br><br>
                                            Diese Aktion kann <strong><span class="text-danger">NICHT RÜCKGÄNGIG</span></strong> gemacht werden !`;
            banUserModalSubmitBtn.dataset.id = id;
            $(banUserModal).modal("show");
        }
    }, data);
}

function resetBanModal() {
    banUserModalMessage.innerHTML = "";
    banUserModalSubmitBtn.dataset.id = "";
}

function banUser() {
    let id = parseInt(banUserModalSubmitBtn.dataset.id);
    let data = {
        id: id
    };

    let x = new xhr();
    x.post("POST", "../assets/server/trash/users/ban/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            warningAlert({
                title: "Fehler",
                message: "Beim Versuch einen Benutzer zu löschen ist ein unbekannter Fehler aufgetreten. Versuchen Sie es erneut oder melden Sie sich beim Admin."
            });
            return false;
        }

        if (re.status === true) {
            successAlert({
                title: "Benutzer gelöscht",
                message: "Der Benutzer wurde erfolgreich gelöscht."
            });
            resetBanModal();
            initDelUsers();
        } else {
            warningAlert({
                title: "Nicht gelöscht",
                message: "Der Benutzer konnte aus unbekannten Gründen nicht gelöscht werden."
            });
        }
    }, data);
}
banUserModalSubmitBtn.addEventListener("click", banUser, false);