function showProfile() {
    var profile = document.getElementsByClassName('profile_icon');

    if (profile.style.height == '') {
        profile.style.height = '800px';
        profile.style.borderSpacing = '1000px';
        alert(test);
    }

    else{
        profile.style.height = '';
    }
       

}


