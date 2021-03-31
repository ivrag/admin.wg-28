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