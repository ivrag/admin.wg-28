const pageVisitors = document.getElementById("page-visitors");
const bookingVisitors = document.getElementById("booking-visitors");

function setPageVisitors() {
    let x = new xhr();
    x.get("GET", "../assets/server/getPageVisitors/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            pageVisitors.textContent = "#Fehler";
        }
        if (re.status === true) {
            let odometer = new Odometer({
                el: pageVisitors,
                value: 0,
                format: "'ddd"
            });
            odometer.update(re.visit);
        }
    });
}

function setBookingVisitors() {
    let x = new xhr();
    x.get("GET", "../assets/server/getBookingVisitors/", rsp => {
        let re;
        try {
            re = JSON.parse(rsp);
        } catch(err) {
            bookingVisitors.textContent = "#Fehler";
        }
        if (re.status === true) {
            let odometer = new Odometer({
                el: bookingVisitors,
                value: 0,
                format: "'ddd"
            });
            odometer.update(re.visit);
        }
    });
}

function init() {
    setBookingVisitors();
    setPageVisitors();
}

window.addEventListener("load", init, false);