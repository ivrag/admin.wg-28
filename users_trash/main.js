// initialize popovers
function initPopovers() {
    $(function () {
        $('[data-toggle="popover"]').popover()
    });
}

const confirmAlertSection = document.getElementById("confirm-alert-section");

const mainContentSection = document.getElementById("main-content-section");
const delUsersTableBody = document.getElementById("del-users-table-body");

const freeSpaceSection = document.getElementById("free-space-section");

$(initDelUsers());

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

function fetchFreeSpace() {
    let x = new xhr();
    x.get("POST", "../assets/server/trash/users/freespace/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            freeSpaceSection.innerHTML = "#Fehler";
            return false;
        }

        if (re.status === true) {
            let styleElement = document.getElementById("popover-styles");
            styleElement.textContent = `.ppwdt {width: ` + re.taken + `%;}`;
            freeSpaceSection.innerHTML = `<button type="button" data-trigger="focus" class="btn btn-info btn-sm" data-toggle="popover" data-html="true" title="Papierkorbkapazität" data-content="Die Papierkorbkapazität dient dazu die Speicherkapazität zu schützen und Daten, die nicht gebraucht werden aus dem Weg zu räumen.<br><br><div><small>` + re.taken + `% belegt</small></div><div class='progress'><div class='progress-bar progress-bar-striped progress-bar-animated ` + re.class + ` ppwdt' role='progressbar' aria-valuenow=’20’ aria-valuemin='0' aria-valuemax='100'></div></div><div></div>">Papierkorbkapazität</button>`;
            initPopovers();
        } else {
            successAlert({
                title: re.title,
                message: re.msg
            });
        }
    });
}

function initDelUsers() {
    let x = new xhr();
    x.get("POST", "../assets/server/trash/users/fetch/", rsp => {
        delTableLoaded = true;
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            delUsersTableBody.innerHTML = `<tr><td colspan="6">Ein unbekannter Fehler ist beim holen der Tabellendaten aufgetreten. Versuchen Sie die Daten erneut zu laden, indem Sie die Seite neu laden oder melden Sie sich beim Admin.</td></tr>`;
            $(mainContentSection).fadeIn();
            return false;
        }

        delUsersTableBody.innerHTML = "";
        if (re.status === undefined) {
            for (i in re) {
                let tr = document.createElement("tr");

                let tdUid = document.createElement("td");
                tdUid.textContent = re[i].uid;
                tr.appendChild(tdUid);

                let tdFn = document.createElement("td");
                tdFn.textContent = re[i].firstname;
                tr.appendChild(tdFn);

                let tdLn = document.createElement("td");
                tdLn.textContent = re[i].lastname;
                tr.appendChild(tdLn);

                let tdUn = document.createElement("td");
                tdUn.textContent = re[i].username;
                tr.appendChild(tdUn);

                let tdMail = document.createElement("td");
                tdMail.textContent = re[i].email;
                tr.appendChild(tdMail);

                let tdActions = document.createElement("td");
                tdActions.setAttribute("class", "text-center user-table-action-column");

                let regenBtn = document.createElement("button");
                regenBtn.setAttribute("class", "btn btn-primary mr-2");

                let regenIcon = document.createElement("i");
                regenIcon.setAttribute("class", "fas fa-sync-alt fa-sm");
                regenBtn.appendChild(regenIcon);

                let banBtn = document.createElement("button");
                banBtn.setAttribute("class", "btn btn-danger");

                let banIcon = document.createElement("i");
                banIcon.setAttribute("class", "fas fa-ban fa-sm");
                banBtn.appendChild(banIcon);

                tdActions.appendChild(regenBtn);
                tdActions.appendChild(banBtn);
                tr.appendChild(tdActions);

                let id = re[i].id;

                regenBtn.addEventListener("click", function() {
                    regenerateUser(id);
                }, false);

                banBtn.addEventListener("click", function() {
                    fetchBanModalValues(id);
                }, false);
                
                delUsersTableBody.appendChild(tr);
            }
        } else {
            delUsersTableBody.innerHTML = `<tr><td colspan="6">Es sind keine gelöschten Benutzer vorhanden...</td></tr>`;
        }
        fetchFreeSpace();
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

            let slAlert = document.createElement("sl-alert");
            slAlert.setAttributeNode(document.createAttribute("open"));
            slAlert.setAttributeNode(document.createAttribute("closable"));
            slAlert.setAttribute("type", "primary");
            slAlert.setAttribute("class", "alert-closable mb-4");

            slIcon = document.createElement("sl-icon");
            slIcon.setAttribute("slot", "icon");
            slIcon.setAttribute("name", "info-circle");
            slAlert.appendChild(slIcon);

            alertTitle = document.createElement("strong");
            alertTitle.textContent = "Benutzer wiederhergestellt";
            slAlert.appendChild(alertTitle);

            let br = document.createElement("br");

            slAlert.appendChild(br);

            let msgSpan = document.createElement("span");
            let msgSubSpan = document.createElement("span");
            msgSpan.textContent = "Der Benutzer ";
            msgSpan.appendChild(msgSubSpan);

            let msgStrong = document.createElement("strong");
            msgStrong.textContent = re.firstname + " " + re.lastname;
            msgSpan.appendChild(msgStrong);

            let msgSubSpan2 = document.createElement("span");
            msgSubSpan2.textContent = " wurde wiederhergestellt.";
            msgSpan.appendChild(msgSubSpan2);

            slAlert.appendChild(msgSpan);

            let br2 = document.createElement("br");
            slAlert.appendChild(br2);
            let br3 = document.createElement("br");
            slAlert.appendChild(br3);

            let cautionSpan = document.createElement("span");
            cautionSpan.innerHTML = `<span>Bitte beachten Sie, dass dem Benutzer ein neues Passwort zugewiesen wurde, sowie alle Benutzerrechte gesperrt wurden.</span><br>
                                    <span>Um die Rechte zu ändern, begeben Sie sich in die <a href="../users/">Benutzerrubrik</a> und suchen Sie nach dem Benutzer. Klicken Sie auf Benutzer Bearbeiten.</span><br><br>`;
            
            slAlert.appendChild(cautionSpan);

            let usernameDiv = document.createElement("div");
            let unLabelSpan = document.createElement("span");
            unLabelSpan.textContent = "Benutzername: ";
            usernameDiv.appendChild(unLabelSpan);

            let unValue = document.createElement("strong");
            unValue.textContent = re.username;
            usernameDiv.appendChild(unValue);

            let pwdDiv = document.createElement("div");
            let pwdLabelSpan = document.createElement("span");
            pwdLabelSpan.textContent = "Passwort: ";
            pwdDiv.appendChild(pwdLabelSpan);

            let pwdValue = document.createElement("strong");
            pwdValue.textContent = re.pwd;
            pwdDiv.appendChild(pwdValue);

            slAlert.appendChild(usernameDiv);
            slAlert.appendChild(pwdDiv);

            div.appendChild(slAlert);
            confirmAlertSection.appendChild(div);
            if (banUserModalSubmitBtn.dataset.action && banUserModalSubmitBtn.dataset.string) {
                fetchSearchedUsers(banUserModalSubmitBtn.dataset.string);
            } else {
                initDelUsers();
            }
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
            banUserModalMessage.innerHTML = "";
            let msgDiv = document.createElement("div");
            let msgSpan = document.createElement("span");
            msgSpan.textContent = "Soll ";
            msgDiv.appendChild(msgSpan);
            let strong = document.createElement("strong");
            strong.textContent = re.firstname + " " + re.lastname;
            msgDiv.appendChild(strong);
            let msgSpan2 = document.createElement("span");
            msgSpan2.textContent = " wirklich für immer gelöscht werden?";
            msgDiv.appendChild(msgSpan2);

            banUserModalMessage.appendChild(msgDiv);

            let brDiv = document.createElement("div");
            brDiv.innerHTML = "<br>";
            msgDiv.appendChild(brDiv);

            let cautionDiv = document.createElement("div");
            cautionDiv.innerHTML = `Diese Aktion kann <strong><span class="text-danger">NICHT RÜCKGÄNGIG</span></strong> gemacht werden !`;
            msgDiv.appendChild(cautionDiv);

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
            if (banUserModalSubmitBtn.dataset.action && banUserModalSubmitBtn.dataset.string) {
                fetchSearchedUsers(banUserModalSubmitBtn.dataset.string);
            } else {
                initDelUsers();
            }
        } else {
            warningAlert({
                title: "Nicht gelöscht",
                message: "Der Benutzer konnte aus unbekannten Gründen nicht gelöscht werden."
            });
        }
    }, data);
}
banUserModalSubmitBtn.addEventListener("click", banUser, false);


// SEARCH FOR DELETED USERS
const delUserSearchForm = document.getElementById("del-user-search-form");
const delUserSearchIpt = document.getElementById("del-user-search-input");
const delUserSearchSbmtBtn = document.getElementById("del-user-search-submit-btn");

function resetSearch() {
    if (delUserSearchIpt.value.length < 1) {
        banUserModalSubmitBtn.dataset.action = "";
        banUserModalSubmitBtn.dataset.string = "";
        initDelUsers();
    }
}
delUserSearchIpt.addEventListener("keyup", resetSearch, false);

function fetchSearchedUsers(str) {
    banUserModalSubmitBtn.dataset.action = "search";
    banUserModalSubmitBtn.dataset.string = delUserSearchIpt.value;

    let data = {
        str: str
    };

    let x = new xhr();
    x.post("POST", "../assets/server/trash/users/search/", rsp => {
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
            delUsersTableBody.innerHTML = "";
            for (i in re.data) {
                let tr = document.createElement("tr");

                let tdUid = document.createElement("td");
                tdUid.textContent = re.data[i].uid;
                tr.appendChild(tdUid);

                let tdFn = document.createElement("td");
                tdFn.textContent = re.data[i].firstname;
                tr.appendChild(tdFn);

                let tdLn = document.createElement("td");
                tdLn.textContent = re.data[i].lastname;
                tr.appendChild(tdLn);

                let tdUn = document.createElement("td");
                tdUn.textContent = re.data[i].username;
                tr.appendChild(tdUn);

                let tdMail = document.createElement("td");
                tdMail.textContent = re.data[i].email;
                tr.appendChild(tdMail);

                let tdActions = document.createElement("td");
                tdActions.setAttribute("class", "text-center user-table-action-column");

                let regenBtn = document.createElement("button");
                regenBtn.setAttribute("class", "btn btn-primary mr-2");

                let regenIcon = document.createElement("i");
                regenIcon.setAttribute("class", "fas fa-sync-alt fa-sm");
                regenBtn.appendChild(regenIcon);

                let banBtn = document.createElement("button");
                banBtn.setAttribute("class", "btn btn-danger");

                let banIcon = document.createElement("i");
                banIcon.setAttribute("class", "fas fa-ban fa-sm");
                banBtn.appendChild(banIcon);

                tdActions.appendChild(regenBtn);
                tdActions.appendChild(banBtn);
                tr.appendChild(tdActions);

                let id = re.data[i].id;

                regenBtn.addEventListener("click", function() {
                    regenerateUser(id);
                }, false);

                banBtn.addEventListener("click", function() {
                    fetchBanModalValues(id);
                }, false);
                
                delUsersTableBody.appendChild(tr);
            }
            fetchFreeSpace();
        } else {
            if (re.type === "nof") {
                delUsersTableBody.innerHTML = `<tr><td colspan="6">Keine einträge gefunden ...</td></tr>`;
            } else {
                warningAlert({
                    title: re.title,
                    message: re.msg
                });
            }
        }
        delUserSearchIpt.focus();
        delUserSearchIpt.select();
    }, data);
}

function delUserSearchSubmit(e) {
    e.preventDefault();

    fetchSearchedUsers(delUserSearchIpt.value);
}
delUserSearchForm.addEventListener("submit", delUserSearchSubmit, false);