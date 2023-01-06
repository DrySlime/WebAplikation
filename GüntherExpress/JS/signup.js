function showErrorMsgEmpty() {
    const errorText = document.getElementById('errorText');
    const errorContent = document.getElementById('errorTextContent');
    errorContent.innerText = 'Bitte fülle alle Felder aus!';
    errorText.style.visibility = 'visible'
}
function showErrorMsgInvalid() {
    const errorText = document.getElementById('errorText');
    const errorContent = document.getElementById('errorTextContent');
    errorContent.innerText = 'Dein Benutzername beinhaltet ungültige Zeichen!';
    errorText.style.visibility = 'visible'
}
function showErrorMsgEmail() {
    const errorText = document.getElementById('errorText');
    const errorContent = document.getElementById('errorTextContent');
    errorContent.innerText = 'Diese Email besitzt schon ein Account, oder ist nicht richtig!';
    errorText.style.visibility = 'visible'
}
function showErrorMsgUsername() {
    const errorText = document.getElementById('errorText');
    const errorContent = document.getElementById('errorTextContent');
    errorContent.innerText = 'Dieser Benutzername und oder Email existiert schon!';
    errorText.style.visibility = 'visible'
}
function showErrorMsgPasswords() {
    const errorText = document.getElementById('errorText');
    const errorContent = document.getElementById('errorTextContent');
    errorContent.innerText = 'Deine Passwörter stimmen nicht überein!';
    errorText.style.visibility = 'visible'
}