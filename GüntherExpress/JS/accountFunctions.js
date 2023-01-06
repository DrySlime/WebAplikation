function fillData(value, order, item) {
    let rating = document.getElementById(value + "_" + order + "_" + item);
    rating.checked = true;
}

function showErrorMsg(bool, err) {
    if (bool === true) {
        const errorText = document.getElementById('accountError');
        errorText.style.visibility = 'visible'
        switch (err) {
            case 'invaliduid':
                errorText.innerText = "Der Benutzername kann nicht verwendet werden!";
                break;
            case 'invalidemail':
                errorText.innerText = "Diese Email besitzt schon ein Account, oder ist nicht richtig!";
                break;
            case 'uidexists':
                errorText.innerText = "Dieser Benutzername existiert schon!";
                break;
            case 'wrongpassword':
                errorText.innerText = "Dein Passwort stimmt nicht überein!";
                break;
            case 'deletionfailed':
                errorText.innerText = "Wir könnten deinen Account nicht löschen!";
                break;
        }
    } else {
        const errorText = document.getElementById('accountError');
        errorText.style.visibility = 'hidden'
    }
}