"use strict";

let form = document.querySelector(".send_form"),
    x = document.getElementById("x_select"),
    y = document.getElementById("y_select"),
    r;

function checkX() {
    if (x.value === "") {
        x.classList.add("input_err");
        return false;
    }
    return true;

}

function checkY() {
    let yVal = y.value.replace(',', '.');
    if (yVal.trim() === "" || !isFinite(yVal) || (yVal <= -5 || yVal >= 5)) {
        y.classList.add("input_err");
        return false;
    }
    return true;
}

function checkR() {
    let buttons = document.querySelectorAll(".r_button");
    if (r === undefined) {
        buttons.forEach(button => button.classList.add("input_err"));
        return false;
    }
    buttons.forEach(button => button.classList.remove("input_err"));
    return true;
}

function changeR(rValue) {
    let button = document.getElementById("r_" + rValue);
    if (!button.classList.contains("sel")) {
        r = rValue;
        let oldSelectedButton = document.querySelector(".sel");
        if (oldSelectedButton !== null)
            oldSelectedButton.classList.remove("sel");
        button.classList.add("sel");
        checkR();
    } else {
        r = undefined;
        button.classList.remove("sel");
    }
}

form.addEventListener("submit", function (e) {
    e.preventDefault();
    if (checkX() && checkY() && checkR()) {
        let formData = new FormData();
        formData.append("x", x.value);
        formData.append("y", y.value.replace(',', '.'));
        formData.append("r", r);

        let xhr = new XMLHttpRequest();
        xhr.onloadend = function () {
            if (xhr.status === 200) {
                document.querySelector(".result_table").innerHTML = xhr.response;
            } else console.log("status: ", xhr.status)
        };
        xhr.open("POST", "server.php");
        xhr.send(formData);


    }

});

x.addEventListener("input", function () {
    x.classList.remove("input_err");

});
y.addEventListener("input", function () {
    y.classList.remove("input_err");
});