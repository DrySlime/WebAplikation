let headers = document.querySelectorAll(".checkout_data_header li");
let sections = document.querySelectorAll(".checkout_section");
let nextButton = document.querySelector("#nextPage");
let prevButton = document.querySelector("#prevPage");
let current = 0;

const toggleTabs = () => {
    headers.forEach(function(header) {
        header.classList.remove('active');
    });
    headers[current].classList.add("active");
}
const toggleSections = () => {
    sections.forEach(function(section) {
        section.classList.remove('active');
    });
    sections[current].classList.add("active");
}

const togglePrev = () => {
    const method = current === 0 ? 'add' : 'remove';
    prevButton.classList[method]("disable");
}

const toggleNext = () => {
    const method = current === headers.length - 1 ? 'add' : 'remove';
    nextButton.classList[method]("disable");
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
    if(clicked !== current){
        current = clicked;
        toggleTabs();
        toggleSections();
        toggleNext();
        togglePrev();
    }
}

let containers = document.querySelectorAll(".checkout_address_grid_container");
for (let i = 0; i < containers.length; i++) {
    containers[i].addEventListener('click', changeBorderContainer, false);
}

let radiobuttons = document.querySelectorAll("input[type=radio]");
for (let i = 0; i < radiobuttons.length; i++) {
    radiobuttons[i].addEventListener('click', changeBorderRadio, false);
}

function changeBorderContainer() {
    if(this.classList.contains("addAddressContainer")){
        return;
    }
    let radButton = $(this).find('input[type=radio]');
    $(radButton).prop("checked", true);
    for (let i = 0; i < containers.length; i++) {
        containers[i].style.borderColor = "transparent";
    }
    this.style.borderColor = "#fc466b"
}

function changeBorderRadio() {
    for (let i = 0; i < containers.length; i++) {
        containers[i].style.borderColor = "transparent";
    }
    this.parentElement.style.borderColor = "#fc466b"
}

document.addEventListener("DOMContentLoaded", function() {
    for (let i = 0; i < radiobuttons.length; i++) {
        if(radiobuttons[i].getAttribute("checked") === "checked") {
            radiobuttons[i].parentElement.style.borderColor = "#fc466b";
            return
        }
    }
});