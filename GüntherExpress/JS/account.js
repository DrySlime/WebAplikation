var modal = document.getElementById('delete-modal');
var modalOpen = document.getElementById('delete');
var modalClose = document.getElementById('close_modal');

modalOpen.addEventListener('click', openModal);
modalClose.addEventListener('click', closeModal)

function openModal() {
    document.getElementById('close_modal').style.transition = 'ease-in-out 0.3s';
    document.getElementById('delete_Account').style.transition = 'ease-in-out 0.3s';
    modal.style.visibility = 'visible';
}

function closeModal() {
    document.getElementById('close_modal').style.transition = 'none';
    document.getElementById('delete_Account').style.transition = 'none';
    modal.style.visibility = 'hidden';
}