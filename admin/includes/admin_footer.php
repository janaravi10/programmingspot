    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <script  src="script.js"></script>
    <script type="text/javascript" src="post.js"></script>
    <script type="text/javascript">
    	// const deleteAccount = document.getElementById("deleteAccount");
     //    deleteAccount.addEventListener("submit",deleteAccountFun);
        function deleteAccountFun(){
        	if(confirm("Are you sure! you want to delete the account")){
        		return true;
        	}
            return false;
        }
    </script>
    </body>
    
    </html>
    


