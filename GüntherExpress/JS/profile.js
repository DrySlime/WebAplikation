function showProfile() {
    var profile_info = document.getElementsById('profile_info');

    if (profile_info.style.display === 'none') {
        profile_info.style.display = 'inline';
        alert(Text);
    }

    else{
        profile_info.style.display = 'none';
    }
       

}

function showProfileEdit() {
    alert('help');
    var profile_info = document.getElementsById('profile_info');
    var change_profile = document.getElementsById('change_profile');
    alert('help');
    profile_info.style.display = 'none';
    change_profile.style.display = 'inline';
}



