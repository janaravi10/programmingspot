if (document.getElementById('cbx')) {
  function checkAllEventListener() {
    /* this function used for the check boxs which is used in the admin panel */
      document.getElementById("cbx").addEventListener("click",function(Event){
      if(document.getElementById("cbx").checked){
       var checkboxes = document.getElementsByClassName("cbxs");
          for(let i = 0;i <checkboxes.length; i++){
          checkboxes[i].checked = true;
          }
      }else{
          var checkboxes = document.getElementsByClassName("cbxs");
          for(let i = 0;i <checkboxes.length; i++){
          checkboxes[i].checked = false;
          }
      }

  });
  }
  checkAllEventListener();
}

var delPost = document.getElementsByClassName('delPost');
if (delPost) {
  /* code to  addevent listner for delete button */

  function EventListenerForDel(){
  for (var i = 0; i < delPost.length; i++) {
    delPost[i].addEventListener("click",function (e) {
      e.preventDefault();
      var getParam = getLinkParam("del_post",this);
      delPosts(getParam);
      return false;
    }); 
  };
};
EventListenerForDel();
};
function delPosts(parameter) {
  /* function  to delete the post */
  xhttp.onreadystatechange = function(){
   if(this.readyState == 4 && this.status == 200){
        reloadPost();
      };
  };
  xhttp.open("POST","includes/functions.php",true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("del_post="+parameter);
};

function reloadPost() {
  /* function to reload the post information */

  xhttp.onreadystatechange = function(){
   if(this.readyState == 4 && this.status == 200){
    var childElem = document.getElementById('tableWrapper');
    childElem.parentNode.removeChild(childElem);
     document.getElementById('tableContainer').innerHTML += this.responseText;
     EventListenerForDel();
     addFormlistener();
     checkAllEventListener();
      };
  };
  xhttp.open("POST","includes/all_post.php",true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("del_post=true");
};


addFormlistener();
function addFormlistener() {
  /* functio  to addform event listner after the response is come to the element */
  var bulkOptionBtn = document.getElementById("submitbtn");
  if(bulkOptionBtn){
  bulkOptionBtn.addEventListener("click",addBulkOption);
  }
  };
function addBulkOption(e) {
  e.preventDefault();
  /* this function will add functionality to bulk features */
  var bulkOption = document.getElementById("selectField").value;
  var checkboxes = document.getElementsByClassName("checkboxes");
  var checkBoxesArray = [];
  function arrayConverter() {
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].checked) {
           checkBoxesArray[i] = checkboxes[i].value;
           }
    }
  checkBoxesArray = JSON.stringify(checkBoxesArray);
  }
  arrayConverter();
xhttp.onreadystatechange = function(){
  if(this.readyState == 4 && this.status == 200){
        reloadPost();
     };
 };
 xhttp.open("POST","includes/functions.php",true);
 xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 xhttp.send("checkboxes="+checkBoxesArray+"&bulk_option="+bulkOption);
};
