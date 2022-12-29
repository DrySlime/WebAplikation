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
    if (parseInt(current) === 0) {
        prevButton.classList.add('disable');
    } else {
        prevButton.classList.remove('disable');
    }
}

const toggleNext = () => {
    if (parseInt(current) === headers.length - 1) {
        nextButton.classList.add('disable');
    } else {
        nextButton.classList.remove('disable');
    }
}

const goNext = () => {
    if (parseInt(current) < headers.length - 1) {
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
    current = parseInt(clicked);
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
    if (this.classList.contains("addAddressContainer") || this.classList.contains("exclude")) {
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
            let radioButton = radiobuttons[i];
            let id = radioButton.getAttribute('id');
            if(radioButton.getAttribute("name") === "address_buttons") {
                $.ajax({
                    url: "checkout.php",
                    method: "POST",
                    data: {address: id},
                    success: function () {
                        $('#final_address').html($('#address_'+id).html());
                    }
                });
            } else if(radioButton.getAttribute("name") === "payment_buttons") {
                $.ajax({
                    url: "checkout.php",
                    method: "POST",
                    data: {payment: id},
                    success: function () {
                        $('#final_payment').html($('#payment_'+id).html());
                    }
                });
            }
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
                    $('#final_ship').html($('#ship_'+id).html());
                    $.ajax({
                        url: "checkout.php",
                        method: "POST",
                        data: {finalPrice: final}
                    });
                }
            });
        } else if(radioButton.attr("name") === "address_buttons") {
            $.ajax({
                url: "checkout.php",
                method: "POST",
                data: {address: id},
                success: function () {
                    $('#final_address').html($('#address_'+id).html());
                }
            });
        } else if(radioButton.attr("name") === "payment_buttons") {
            $.ajax({
                url: "checkout.php",
                method: "POST",
                data: {payment: id},
                success: function () {
                    $('#final_payment').html($('#payment_'+id).html());
                }
            });
        }
        if($('input[name="payment_buttons"]').is(':checked') && $('input[name="address_buttons"]').is(':checked') && $('input[name="delivery_buttons"]').is(':checked')) {
            $('#checkoutButton').removeAttr("disabled");
        }
    }
});

jQuery.ajaxSetup({
    async: true
});

function calculatePrice(price, shipping) {
    return parseFloat(price) + parseFloat(shipping);
}