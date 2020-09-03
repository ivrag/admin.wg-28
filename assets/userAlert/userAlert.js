let USER_ALERT_PARENT = undefined;
let DEFAULT_ALERT_DELAY = 5;
class userAlertSetup {
    constructor(obj = {}) {
        USER_ALERT_PARENT = obj.parent ?? undefined;
        DEFAULT_ALERT_DELAY = obj.delay ?? 5;
        document.getElementById(USER_ALERT_PARENT).setAttribute("class", "usrAlertParent");
    }
}

class userAlert {
    constructor(obj = {}) {
        if (USER_ALERT_PARENT !== undefined) {
            this.parent = document.getElementById(USER_ALERT_PARENT);
            this.type = obj.type ?? undefined;
            this.title = obj.title ?? undefined;
            this.msg = obj.msg ?? undefined;
            this.delay = obj.delay ?? DEFAULT_ALERT_DELAY;
            this.html = obj.html ?? false;

            let slAlert = document.createElement("sl-alert");
            slAlert.setAttribute("class", "mb-4");
            if (this.type === "success") {
                slAlert.setAttribute("type", "success");
            } else if (this.type === "info") {
                slAlert.setAttribute("type", "info");
            } else if (this.type === "warning") {
                slAlert.setAttribute("type", "warning");
            } else if (this.type === "danger") {
                slAlert.setAttribute("type", "danger");
            } else {
                console.error('User Alert error: unknown type. expected ("success", "info", "warning", "danger")');
                return false;
            }

            let slIcon = document.createElement("sl-icon");
            slIcon.setAttribute("slot", "icon");
            if (this.type === "success") {
                slIcon.setAttribute("name", "check2-circle");
            } else if (this.type === "info") {
                slIcon.setAttribute("name", "info-circle");
            } else if (this.type === "warning") {
                slIcon.setAttribute("name", "exclamation-triangle");
            } else if (this.type === "danger") {
                slIcon.setAttribute("name", "exclamation-octagon");
            } else {
                console.error('User Alert error: unknown type. expected ("success", "info", "warning", "danger")');
                return false;
            }
            
            let titleSection = document.createElement("div");
            let strong = document.createElement("strong");
            strong.textContent = this.title;
            titleSection.appendChild(strong);

            let msg = document.createElement("span");
            if (this.html === false) {
                msg.textContent = this.msg;
            } else {
                let rep = this.msg.replace(/<|>|script|alert()|img/igm, '');
                msg.innerHTML = rep;
            }

            slAlert.appendChild(slIcon);
            slAlert.appendChild(titleSection);
            slAlert.appendChild(msg);

            this.parent.appendChild(slAlert);

            slAlert.show();
            let showTimeout = setTimeout(function () {
                slAlert.hide().then(function() {
                    slAlert.remove();
                    clearTimeout(showTimeout);
                });
            }, this.delay * 1000);
        } else {
            console.error("User Alert error: unknown parent element.");
            return false;
        }
    }
}