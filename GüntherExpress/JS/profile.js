var showProfile = 0;
function showProfile() {
    alert('hier');
    if (showProfile == 0) {
        document.getElementsByClassName('profile_info').style.display = 'inline';
        showProfile = 1;
    } else {
        document.getElementsByClassName('profile_info').style.display = 'none';
        showProfile = 0;
    }
    alert(showProfile);
}