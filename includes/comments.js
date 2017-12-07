const followBtn = document.getElementById('followBtn');
var getparam = getParameter("post_id");
const form = document.getElementById("formComment");
const commentBox = document.getElementById("commentBox");
const likeBtn = document.getElementById("likeBtn");
const dislikeBtn = document.getElementById('dislikeBtn');
document.body.onload = function(){
    if(followBtn){
following_check(followBtn);
}
likeInfo();
}
function getParameter(identifier) {
    /* this function  will get the url parameter for sending it into the ajax request*/
   var result = undefined, tmp = [];

   var items = window.location.search.substr(1).split("&");

   for (var index = 0; index < items.length; index++) {
       tmp = items[index].split("=");

       if (tmp[0] === identifier){
           result = decodeURIComponent(tmp[1]);
       }
   }

   return result;
}
form.addEventListener('submit',addComment);
function addComment(e){
   e.preventDefault();
 /* this function will add comment to the specific post */
   var xhttp = new XMLHttpRequest();
   var comment = document.getElementById("comment").value;
   var submit = document.getElementById("submit").value;
   xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
          document.getElementById("alert").innerHTML = this.responseText;
          form.reset();
          setTimeout(function(){
            document.getElementById("alert").innerHTML = "";
          },1000)
          showComments();
       }

 };
   xhttp.open("POST","includes/functions.php",true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send("post_id="+getparam+"&comment_content="+comment+"&add_comment=add_comment");
}
/* commentbox is element to show alert*/
commentBox.addEventListener("load",showComments());

function showComments(){
    /*this function will get the comments from database  for specific post*/
    var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function(){
   if(this.readyState == 4 && this.status == 200){
         document.getElementById("commentBox").innerHTML = this.responseText;
      }

  };

  xhttp.open("POST","includes/functions.php",true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("p_id="+getparam);
}
if(likeBtn){
  likeBtn.addEventListener("click",liking);
  dislikeBtn.addEventListener("click",liking);
  function liking(e){
   e.preventDefault();
   /* this function will manage the like feature*/
   var xhttp = new XMLHttpRequest();
    var linkParam = getLinkParam("like",this);
   xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
       document.getElementById('alertliking').innerHTML = "<span class='alertliking'> You "+this.responseText+"d</span>";
       if(this.responseText.trim() == 'login'){
        document.getElementById('alertliking').innerHTML = "<span class='alertliking'> You  should"+this.responseText+"</span>";
       }
       reloadLikes();
       reloadDislikes();
       likeInfo();
       setTimeout(function(){
        document.getElementById("alertliking").innerHTML = "";
      },1000);
      
       }
 
   };
 
   xhttp.open("POST","includes/functions.php",true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send("p_id_liking="+getparam+"&like="+linkParam+"&likeCall=true");
  }
}
function reloadLikes(){
    /* this function will reload the like count by fetching the like count in the database*/
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          document.getElementById('showLikes').innerHTML = this.responseText;
           }
       };
    xhttp.open("POST","includes/functions.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("p_id_likes_count="+getparam+"&count_likes=like");
}
function reloadDislikes(){
    /* this function will reload the dislike count by fetching the  dislike count in the database*/
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          document.getElementById('showDislikes').innerHTML = this.responseText;
           }
       };
    xhttp.open("POST","includes/functions.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("p_id_likes_count="+getparam+"&count_dislikes=dislike");
}

function likeInfo() {
    /* this function will show either the user cliked like or dislike when past login*/
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var likeBtn = document.getElementById('likeBtn');
            var dislikeBtn = document.getElementById('dislikeBtn');
          if(this.responseText.trim()=='like'){
              likeBtn.classList.add("black");
              dislikeBtn.classList.add("gray");
              dislikeBtn.classList.remove('black');
              likeBtn.classList.remove('gray');
          }else if(this.responseText.trim()=='dislike'){
              likeBtn.classList.remove('black');
                likeBtn.classList.add("gray");
                dislikeBtn.classList.add("black");
                dislikeBtn.classList.remove('gray');
          }else{
            likeBtn.classList.add("gray");
            dislikeBtn.classList.add("gray");
          }
           }
       };
    xhttp.open("POST","includes/functions.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("p_id_like_info="+getparam);
}
function getLinkParam(identifier,elem) {
    /* this function will get the anchor tag url parameter to send to the ajax request*/
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
if(followBtn){
followBtn.addEventListener("click",function (e){
    e.preventDefault();
    follow(followBtn);
});
}

function follow(e){
    /* this function will manage the follow request feature*/
    var user_id = getLinkParam("user_id",e);
    var friend_id = getLinkParam("friend_id",e);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          if(this.responseText.trim()=="You following"){
              followBtn.classList.remove("btn-default");
              followBtn.classList.add("btn-success");
              followBtn.innerHTML = this.responseText.trim();
          }else if(this.responseText.trim()== "unfollowed"){
            followBtn.classList.remove("btn-success");
            followBtn.classList.add("btn-default");
            followBtn.innerHTML = "Follow";
          }

           }
       };
    xhttp.open("POST","includes/functions.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if(e.innerHTML == "You following"){
        xhttp.send("user_id="+user_id+"&friend_id="+friend_id+"&unfollow=true");
    }else{
        xhttp.send("user_id="+user_id+"&friend_id="+friend_id+"&follow=true");
    }
    
}
function following_check(e) {
    /* this function will check whether user is already following the post author*/
   var xhttp = new XMLHttpRequest();
   var user_id = getLinkParam("user_id",e);
   var friend_id = getLinkParam("friend_id",e);
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
          if(this.responseText.trim()=="You following"){
              followBtn.classList.remove("btn-default");
              followBtn.classList.add("btn-success");
              followBtn.innerHTML = this.responseText.trim();
          }
          }
       };
    xhttp.open("POST","includes/functions.php",true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("user_id="+user_id+"&friend_id="+friend_id+"&following_check=true");
}
