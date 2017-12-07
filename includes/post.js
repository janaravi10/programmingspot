var  xhttp = new XMLHttpRequest();
var postBox = document.getElementById("postBox");

function getParameter(identifier) {
  //function for getting url GET parameter
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
var catId = getParameter("cat_id");
var catTitle = getParameter("cat_title");
function showPost(){
  //function to send data to php function  with ajax
  xhttp.onreadystatechange = function(){
   if(this.readyState == 4 && this.status == 200){
    var spinner = document.getElementById('spinner');
    spinner.parentNode.removeChild(spinner);
         if(this.responseText.trim() == "empty"){
          postBox.innerHTML += "<h2 class='alert alert-info'>Sorry .. There is no post</h2>";
         }else{
          postBox.innerHTML += this.responseText;
         postBox.innerHTML +="<button type='button' id='loader' class='btn btn-success btn-lg'>load more</button>";
         const loader = document.getElementById("loader");
         loader.addEventListener("click",loadPost);
       }
      }

  };

  xhttp.open("POST","includes/functions.php",true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  if (catId) {
    xhttp.send("page_real="+page_real+"&cat_id="+catId+"&cat_title="+catTitle);
  }else if (catId == undefined) {
    xhttp.send("page_real="+page_real+"&by=normal");
  }

}

postBox.addEventListener("load",showPost());
 function loadPost(){
   /* this function will load another five post when load more button clicked */
  const loader = document.getElementById("loader");
  loader.parentNode.removeChild(loader);
   postBox.innerHTML += '<div class="spinner" id="spinner"><div class="backspinner"><div class="innerspinner"></div></div></div>';
       page_real += 5;
      xhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200) {
          var spinner = document.getElementById('spinner');
          spinner.parentNode.removeChild(spinner);
        if(this.responseText.trim() == 'empty'){
          postBox.innerHTML += "<h2 class='alert alert-info'>Sorry .. There is no post</h2>";
        }else{
          postBox.innerHTML += this.responseText;
        }
      }
    }
      xhttp.open("POST","includes/functions.php",true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      if (catId) {
        xhttp.send("page_real="+page_real+"&cat_id="+catId+"&cat_title="+catTitle+"&loader="+true);
      }else if (catId == undefined) {
        xhttp.send("page_real="+page_real+"&by=normal");
      }
 }

