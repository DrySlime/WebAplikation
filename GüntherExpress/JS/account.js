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


const addressModal = document.getElementById('address-modal');
const addressModalOpen = document.getElementById('address');
const addressModalClose = document.getElementById('close_address_modal');

addressModalOpen.addEventListener('click', openAddressModal);
addressModalClose.addEventListener('click', closeAddressModal)

function openAddressModal() {
    document.getElementById('close_address_modal').style.transition = 'ease-in-out 0.3s';
    document.getElementById('add_Address').style.transition = 'ease-in-out 0.3s';
    const icons = document.querySelectorAll('.address_setting_container span');
    icons.forEach(icon => {
        icon.style.transition = 'ease-in-out 0.3s'
    });
    addressModal.style.visibility = 'visible';
}

function closeAddressModal() {
    document.getElementById('close_address_modal').style.transition = 'none';
    document.getElementById('add_Address').style.transition = 'none';
    const icons = document.querySelectorAll('.address_setting_container span');
    icons.forEach(icon => {
        icon.style.transition = 'none'
    })
    addressModal.style.visibility = 'hidden';
}


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
    document.getElementById('close_orders_modal').style.transition = 'none';
    orderModal.style.visibility = 'hidden';
}