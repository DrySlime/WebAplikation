const deleteModal = document.getElementById('delete-modal');
const deleteModalOpen = document.getElementById('delete');
const deleteModalClose = document.getElementById('close_delete_modal');

if (deleteModalOpen) {
    deleteModalOpen.addEventListener('click', openDeleteModal);
    deleteModalClose.addEventListener('click', closeDeleteModal)
}

function openDeleteModal() {
    document.getElementById('close_delete_modal').style.transition = 'ease-in-out 0.3s';
    document.getElementById('delete_Account').style.transition = 'ease-in-out 0.3s';
    deleteModal.style.visibility = 'visible';
}

function closeDeleteModal() {
    document.getElementById('close_delete_modal').style.transition = 'none';
    document.getElementById('delete_Account').style.transition = 'none';
    deleteModal.style.visibility = 'hidden';
}

/*
-----------------------------
Address Modal
-----------------------------
 */

const addressModal = document.getElementById('address-modal');
const addressModalOpen = document.getElementById('address');
const addressModalClose = document.getElementById('close_address_modal');

addressModalOpen.addEventListener('click', openAddressModal);
addressModalClose.addEventListener('click', closeAddressModal)

function openAddressModal() {
    document.getElementById('close_address_modal').style.transition = 'ease-in-out 0.3s';
    document.getElementById('add_Address').style.transition = 'ease-in-out 0.3s';
    const buttons = document.querySelectorAll('.dataitem_addbutton button');
    buttons.forEach(button => {
        button.style.transition = 'ease-in-out 0.3s'
    });
    const icons = document.querySelectorAll('.address_setting_container span');
    icons.forEach(icon => {
        icon.style.transition = 'ease-in-out 0.3s'
    });
    addressModal.style.visibility = 'visible';
}

function closeAddressModal() {
    document.getElementById('close_address_modal').style.transition = 'none';
    document.getElementById('add_Address').style.transition = 'none';
    const buttons = document.querySelectorAll('.dataitem_addbutton button');
    buttons.forEach(button => {
        button.style.transition = 'none'
    });
    const icons = document.querySelectorAll('.address_setting_container span');
    icons.forEach(icon => {
        icon.style.transition = 'none'
    })
    addressModal.style.visibility = 'hidden';
}

/*
-----------------------------
Order Modal
-----------------------------
 */

const orderModal = document.getElementById('orders-modal');
const orderModalOpen = document.getElementById('orders');
const orderModalClose = document.getElementById('close_orders_modal');

orderModalOpen.addEventListener('click', openOrderModal);
orderModalClose.addEventListener('click', closeOrderModal)

function openOrderModal() {
    document.getElementById('close_orders_modal').style.transition = 'ease-in-out 0.3s';
    orderModal.style.visibility = 'visible';
}

function closeOrderModal() {
    const orderGroup = document.querySelectorAll('[id^=order_products_]');

    orderGroup.forEach(sectionGroup => {
        if (sectionGroup.classList.contains("open")) {
            sectionGroup.classList.remove("open");
        }
    });

    document.getElementById('close_orders_modal').style.transition = 'none';
    var orderModalContainers = document.getElementsByClassName('open');
    for (var k = 0; k < orderModalContainers.length;k++) {
        var orderModalContainer = orderModalContainers[k];
        orderModalContainer.style.transition = 'none';
        orderModalContainer.classList.remove('open')
    }
    var orderModalButtons = document.getElementsByClassName('order_button');
    for (var i = 0; i < orderModalButtons.length; i++) {
        var orderModalButton = orderModalButtons[i];
        orderModalButton.style.transition = 'none';
        orderModalButton.textContent = "Bestellung Anzeigen"
    }
    orderModal.style.visibility = 'hidden';
}

var openOrderProducts = document.getElementsByClassName('order_button');

for (var i = 0; i < openOrderProducts.length; i++) {
    var openSpecificOrder = openOrderProducts[i];
    openSpecificOrder.onclick = function () {
        const split = this.id.split("_");
        const id = split[2];
        showData(id)
    }
}

function showData(id) {
    const orderGroup = document.getElementById('order_products_' + id);
    const orderButton = document.getElementById('order_show_' + id);

    if (orderButton.textContent === "Bestellung Anzeigen") {
        orderButton.textContent = "Bestellung Verstecken"
    } else {
        orderButton.textContent = "Bestellung Anzeigen"
    }

    if (orderGroup.classList.contains("open")) {
        orderGroup.classList.remove("open");
    } else {
        orderGroup.classList.add("open");
    }
}

/*
-----------------------------
Payment Modal
-----------------------------
 */

const paymentModal = document.getElementById('payment-modal');
const paymentModalOpen = document.getElementById('payments');
const PaymentModalClose = document.getElementById('close_payment_modal');

paymentModalOpen.addEventListener('click', openPaymentModal);
PaymentModalClose.addEventListener('click', closePaymentModal)

function openPaymentModal() {
    document.getElementById('close_payment_modal').style.transition = 'ease-in-out 0.3s';
    document.getElementById('add_Payment').style.transition = 'ease-in-out 0.3s';
    const buttons = document.querySelectorAll('.dataitem_addbutton button');
    buttons.forEach(button => {
        button.style.transition = 'ease-in-out 0.3s'
    });
    const icons = document.querySelectorAll('.address_setting_container span');
    icons.forEach(icon => {
        icon.style.transition = 'ease-in-out 0.3s'
    });
    paymentModal.style.visibility = 'visible';
}

function closePaymentModal() {
    document.getElementById('close_payment_modal').style.transition = 'none';
    document.getElementById('add_Payment').style.transition = 'none';
    const buttons = document.querySelectorAll('.dataitem_addbutton button');
    buttons.forEach(button => {
        button.style.transition = 'none'
    });
    const icons = document.querySelectorAll('.address_setting_container span');
    icons.forEach(icon => {
        icon.style.transition = 'none'
    })
    paymentModal.style.visibility = 'hidden';
}

/*
-----------------------------
Review System
-----------------------------
 */

$(document).ready(function () {
    $(document).on('click', 'input[type="radio"]', function () {
        let itemData = $(this).attr('id');

        let itemSingleData = itemData.split("_");
        let starID = itemSingleData[0];
        let orderID = itemSingleData[1];
        let itemID = itemSingleData[2];

        $.ajax({
            url: "/includes/ajaxReviews.php",
            type: "POST",
            data: {starValue: starID, itemID: itemID, orderID: orderID},
            success: function () {

            }
        });
    });
});