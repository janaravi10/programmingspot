if (document.getElementById('cbx')) {
  /* this function will add event listner for check boxes */
  function checkAllEventListener() {
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
  /* function to set event listner for delte post btn */
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
  /* function to delete the posts */
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
  /* function to load the table */
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
  /* function  to add event listner for the new form */
  var bulkOptionBtn = document.getElementById("submitbtn");
  if(bulkOptionBtn){
  bulkOptionBtn.addEventListener("click",addBulkOption);
  }
  };
function addBulkOption(e) {
  /* function to add bulk option to delete the post etc ..*/
  e.preventDefault();
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
