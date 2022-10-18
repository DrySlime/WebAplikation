function check_form() {
     
    var fn = document.getElementById("firstname").value; 
    var ln = document.getElementById("lastname").value; 
    var addr = document.getElementById("adress").value; 
    var email = document.getElementById("email").value; 
    var pas = document.getElementById("password").value;
    var re_pas = document.getElementById("repeat_password").value;  
    
    if (pas!=re_pas){
        console.log(pas);
        alert("Passwörter stimmen nicht überein");
        return false;
           
    }else if((fn=="")|(ln=="")|(addr=="")|(email=="")){
        alert("Felder wurden ausgelassen");
        return false;
    }else{
        document.getElementByName("register_button").submit(); 
        return false;    
    }
  }