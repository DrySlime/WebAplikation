let headers = document.querySelectorAll(".checkout_data_header li");
let sections = document.querySelectorAll(".checkout_section");
let nextButton = document.querySelector("#nextPage");
let prevButton = document.querySelector("#prevPage");
var current = 0;

const toggleTabs = () => {
    headers.forEach(function (header) {
        header.classList.remove('active');
    });
    headers[current].classList.add("active");
}
const toggleSections = () => {
    sections.forEach(function (section) {
        section.classList.remove('active');
    });
    sections[current].classList.add("active");
}

const togglePrev = () => {
    if (current == 0) {
        prevButton.classList.add('disable');
    } else {
        prevButton.classList.remove('disable');
    }
}

const toggleNext = () => {
    if (current == headers.length - 1) {
        nextButton.classList.add('disable');
    } else {
        nextButton.classList.remove('disable');
    }
}

const goNext = () => {
    if (current < headers.length - 1) {
        current++
    }
    toggleTabs();
    toggleSections();
    toggleNext();
    togglePrev();
}

const goBack = () => {
    if (current > 0) {
        current--
    }
    toggleTabs();
    toggleSections();
    toggleNext();
    togglePrev();
}

const goToTab = (clicked) => {
    current = clicked;
    toggleTabs();
    toggleSections();
    toggleNext();
    togglePrev();
}

let containers = document.querySelectorAll(".checkout_grid_container");
for (let i = 0; i < containers.length; i++) {
    containers[i].addEventListener('click', changeBorderContainer, false);
}

let radiobuttons = document.querySelectorAll("input[type=radio]");
for (let i = 0; i < radiobuttons.length; i++) {
    radiobuttons[i].addEventListener('click', changeBorderRadio, false);
}

function changeBorderContainer() {
    if (this.classList.contains("addAddressContainer")) {
        return;
    }
    let radButton = $(this).find('input[type=radio]');
    $(radButton).prop("checked", true);
    for (let i = 0; i < containers.length; i++) {
        if (containers[i].classList.contains(getClasses(this))) {
            containers[i].style.borderColor = "transparent";
        }
    }
    this.style.borderColor = "#fc466b"
}

function changeBorderRadio() {
    for (let i = 0; i < containers.length; i++) {
        if (containers[i].classList.contains(getClasses(this))) {
            containers[i].style.borderColor = "transparent";
        }
    }
    this.parentElement.style.borderColor = "#fc466b"
}

document.addEventListener("DOMContentLoaded", function () {
    for (let i = 0; i < radiobuttons.length; i++) {
        if (radiobuttons[i].getAttribute("checked") === "checked") {
            radiobuttons[i].parentElement.style.borderColor = "#fc466b";
            return
        }
    }
});

function getClasses(element) {
    let classList = element.className.split(/\s+/);
    return classList[1]
}

$(document).on('click', '.checkout_grid_container', function () {
    if (!$(this).hasClass("addAddressContainer")) {
        let radioButton = $(this).children().first();
        let id = radioButton.attr('id');
        let value = radioButton.attr('value');
        if (radioButton.attr("name") === "delivery_buttons") {
            $.ajax({
                url: "/includes/ajaxCheckout.php",
                method: "POST",
                data: {delivery: id, price: value},
                success: function (delData) {
                    $('#lieferkosten').html(delData.split("/")[1] + ".00 €");
                    let finalElement = $('#finalprice');
                    let final = calculatePrice(delData.split("/")[2], delData.split("/")[1]);
                    finalElement.html(final);
                    $.ajax({
                        url: "checkout.php",
                        method: "POST",
                        data: {finalPrice: final}
                    });
                }
            });
        } else {
            $.ajax({
                url: "checkout.php",
                method: "POST",
                data: {address: id}
            });
        }
    }
})
;

jQuery.ajaxSetup({
    async: true
});

function calculatePrice(price, shipping) {
    return parseFloat(price) + parseFloat(shipping);
}