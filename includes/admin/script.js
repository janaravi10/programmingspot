
var  xhttp = new XMLHttpRequest();
var passwordForm = document.getElementById('passwordForm');
if (passwordForm) {
  passwordForm.addEventListener('submit',changePassword);
  function changePassword(e){
    /*this function is used to change the password of the user */
    e.preventDefault();
    var  xhttp = new XMLHttpRequest();
    var oldPassword = document.getElementById('oldPassword').value;
    var newPassword = document.getElementById('newPassword').value;
    var passwordBox = document.getElementById('passwordBox');
    if (newPassword.length < 8) {
     passwordBox.innerHTML = "<h4>password must greater than 8 charters </h4>";
      setTimeout(function(){
        passwordBox.innerHTML = "";
      },1000);
      passwordForm.reset();
      return false;
    }

    xhttp.onreadystatechange = function(){
     if(this.readyState == 4 && this.status == 200){
           passwordBox.innerHTML = this.responseText;
           passwordForm.reset();
           setTimeout(function(){
             passwordBox.innerHTML = "";
           },1000);
        }

    };
    xhttp.open("POST","includes/functions.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("change_password=submit&old_password="+oldPassword+"&new_password="+newPassword);

  };
}

var updateProfileForm = document.getElementById("updateProfileForm");
if (updateProfileForm) {
updateProfileForm.addEventListener('submit',updateProfile);
function updateProfile(e){
  e.preventDefault();
  checkUsername(callback);
};
};


function callback(data) {
  var  xhttp = new XMLHttpRequest();
  //callback to handle the submission of form after username checked;
  var val = data.trim();
  updateFormIndicate = document.getElementById("updateFormIndicate");
  if (val == "username available") {
    var username = document.getElementById("username").value,
    firstname = document.getElementById("firstname").value,
    lastname = document.getElementById("lastname").value,
    email =  document.getElementById('email').value;
    xhttp.onreadystatechange = function(){
     if(this.readyState == 4 && this.status == 200){
          updateFormIndicate.innerHTML = "<h4 class='indicate'>done</h4>";
          setTimeout(function(){
            updateFormIndicate.innerHTML = "";
          },1000);
        };
    };
    xhttp.open("POST","includes/functions.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("update_profile=submit&username="+username+"&user_firstname="+firstname+"&user_lastname="+lastname+"&user_email="+email);
  }else if (val == "username is already exist") {
      updateFormIndicate.innerHTML = "<h4 class='indicate'>Username is not available</h4>";
      setTimeout(function(){
        updateFormIndicate.innerHTML = "";
      },1000);
  }
};
if (document.getElementsByClassName('approve')) { 
  /* function to add event lisntenr for buttons */
  var approve = document.getElementsByClassName('approve');
  function approvalEventListener() {
   for (var i = 0; i < approve.length; i++) {
     approve[i].addEventListener("click",function (e){
       e.preventDefault();
       var getParam = getLinkParam("a",this);
       approveComments(getParam,0);
       return false;
     });
   };
   var unapprove = document.getElementsByClassName('unapprove');
   for (var i = 0; i < unapprove.length; i++) {
     unapprove[i].addEventListener("click",function (e) {
       e.preventDefault();
       var getParam = getLinkParam("ua",this);
       approveComments(getParam,1);
       return false;
     });
   };
   /* function to add event lisntenr for buttons */
 }
 approvalEventListener();
  function approveComments(parameter,status){
    /* this function change the status of the comments */
    var  xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
     if(this.readyState == 4 && this.status == 200){
       document.getElementById('table').innerHTML += this.responseText;
       var tbl = document.getElementById('table');
       tbl = tbl.getElementsByClassName('script');
       for (var i = 0; i < tbl.length; i++) {
         eval(tbl[i].text);
       };
       var CommentStatus = document.getElementsByClassName('status');
       for (var i = 0; i < CommentStatus.length; i++) {
         CommentStatus[i].innerHTML = statusArray[i];
       }
        };
    };
    xhttp.open("POST","includes/functions.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if (status === 0) {
      xhttp.send("a="+parameter+"&status=h");
    }else if (status === 1) {
      xhttp.send("ua="+parameter+"&status=h");
    };
  };
  function getLinkParam(identifier,elem) {
    /* this function gets the anchor tag parameter*/
     var result = undefined, tmp = [];
     var items = elem.getAttribute("href");
     var indexQ = items.indexOf("?");
     items = items.substr(indexQ+1);
     items = items.split("&");
     for (var index = 0; index < items.length; index++) {
         tmp = items[index].split("=");

         if (tmp[0] === identifier){
             result = decodeURIComponent(tmp[1]);
         };
     };
     return result;
  };
}
var delComment = document.getElementsByClassName('delComment');
if (delComment) {
 
  function deleteEventListener(){
    /* this function adds the event listner for delte button */
  for (var i = 0; i < delComment.length; i++) {
    
    delComment[i].addEventListener("click",function (e) {
      e.preventDefault();
      var getParam = getLinkParam("del_comment",this);
      var commentPostId = getLinkParam("com_post_id",this);
      delComments(getParam,commentPostId);
      return false;
    });
  };
  }
  deleteEventListener();
}
function delComments(parameter,commentPostId) {
   /* this function will  delete the comment a user has made */
  var  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function(){
   if(this.readyState == 4 && this.status == 200){
        reloadComment();
      };
  };

  xhttp.open("POST","includes/functions.php",true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("del_comment="+parameter+"&com_post_id="+commentPostId);
};

function reloadComment() {
  /* this function will load the table information after user has deleted any comments */
  var  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function(){
   if(this.readyState == 4 && this.status == 200){
    var childElem = document.getElementById('tableWrapper');
    childElem.parentNode.removeChild(childElem);
     document.getElementById('tableContainer').innerHTML += this.responseText;
     deleteEventListener();
     approvalEventListener();
      };
  };

  xhttp.open("POST","includes/comments.php",true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("delcom=f");
};
// codes for changing username ;

if (document.getElementById("username")) {
  username.addEventListener("keyup",checkUsernameEvent);
}

function checkUsernameEvent () {

  var  xhttp = new XMLHttpRequest();
  var  usernameValue = document.getElementById("username").value;
  xhttp.onreadystatechange = function(){
   if(this.readyState == 4 && this.status == 200){
       document.getElementById('username').nextSibling.innerHTML = this.responseText;
      };
  };
  xhttp.open("POST","includes/functions.php",true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("check_username="+ usernameValue);
}
function checkUsername(callbackfun) {
  var  xhttp = new XMLHttpRequest();
  //function to check username availablity in database
  var  usernameValue = document.getElementById("username").value;
  xhttp.onreadystatechange = function(){
   if(this.readyState == 4 && this.status == 200){
       document.getElementById('username').nextSibling.innerHTML = this.responseText;
     /* function  manage callback from the response*/
       callbackfun(this.responseText);
      };
  };

  xhttp.open("POST","includes/functions.php",true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("check_username="+ usernameValue);
}

function messageFun(){
  /* this function  is used to send the message to others */
  var sendMessage_btn = document.getElementById("sendMessage");
  sendMessage_btn.addEventListener("click",sendMessageFun);
  var showMessages = document.getElementById("message");
showMessages.scrollTop = showMessages.scrollHeight;
  function sendMessageFun(e){
    e.preventDefault();
    var  xhttp = new XMLHttpRequest();
      var messageContent = document.getElementById("messageArea").value;

      if(!messageContent.length == 0){
if (receiverId) {
        xhttp.onreadystatechange = function(){
          if(this.readyState == 4 && this.status == 200){
              if(this.responseText.trim() == "done"){
                showMessages.innerHTML+= '<div class="chat self"><img src="../img/'+userImage+'" class="user-photo" alt="""><div class="chat-message">'+messageContent+'</div></div>';
                showMessages.scrollTop = showMessages.scrollHeight;
              }else{
                alert("sorry some thing went wrong"+this.responseText);

              }
             };
         };

         xhttp.open("POST","includes/functions.php",true);
         xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xhttp.send("receiver_id="+receiverId+"&message_content="+messageContent);
}else{
  alert("Please click any user");
}
      }else{
        alert("send something");
      }
  }
}
messageFun();

  function deleteAccountFun(){
    /* this function make alert to prompt user when he trys to delete the account*/
    if(confirm("Are you sure! you want to delete the account")){
      return true;
    }
      return false;
  }

