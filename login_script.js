var loginform = document.getElementById("loginform");
if(loginform){
    loginform.addEventListener('submit',validateLogin);
    function validateLogin(){
        var username = document.getElementById("username");
        var password = document.getElementById("password");
        if(password < 8){
            document.getElementById("validateBox").innerHTML = "password must be 8 character or higher";
            return false;
        }else{
            return true;
        }
         if(username == ''){
            document.getElementById("validateBox").innerHTML = "please provide username";
            return false;
         }else{
             return true;
         }
       
    }
}