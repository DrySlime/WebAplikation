
// Funktion wird in login.php verwendet! Weakwarning-Signal stimmt nicht.
function showErrorMsg(type) {
    if(type === "wronginput") {
        const errorText = document.getElementById('errorMsg');
        const errorMsg = document.getElementById('errorMsgMessage');
        errorMsg.innerText = "Anmeldedaten stimmen nicht überein!";
        errorText.style.visibility = 'visible'
    } else if(type === "registered") {
        const errorText = document.getElementById('errorMsg');
        const errorMsg = document.getElementById('errorMsgMessage');
        errorMsg.innerText = "Erfolgreich Registiert!"
        errorText.style.visibility = 'visible'
    }
}