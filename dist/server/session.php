<?PHP
session_start();

include_once("db.class.php");  

   
    
//Check what the user whats to do. 
if($_GET['a']==1) 
{     
  //-- Login --//
  
  // Check for login POST data
  if(isset($_POST['accountName']) and isset($_POST['password'])) 
  {
    // With both the account name and password provided, start the log in process.
    login(); 
  }
      
}
elseif($_GET['a']==0)
{
  
  
  // Check for SESSION data
  if(isset($_SESSION)) 
  {
    session_destroy(); 
    redirect("back",0,"No Command! Setting up system data...");
  }
  
}
else
{     
  // Sessions page (no operation has been set so display the sessions information page)
  sessionInfo(); 
  
}

// Check the database, create the session or draw the log in form for the user 
function login()
{
	$db = new DB("nmos_sb", "Warabimochi1"); 
    // Check for the account name. Use the core function "SqlDo" to execute the mysql query 
    $result = $db->query("SELECT * from user WHERE userName = '".$db->res($_POST['accountName'])."'");
    
    // If a match is found. (Has to only find 1 value to prevent sql abuse) 
    if($result->num_rows === 1)
    {
      	// The name has been matched, now the password will be checked
      	$userAccount = $result->fetch_object();  

        // Check the password
        if (sha1($_POST['password']) == $userAccount->userPassword )
        { 
          
          //Debug printout
          # print_r($row); 
          
          // Set the session variables
          $_SESSION['id'] = $userAccount->userID;
          $_SESSION['account'] = $userAccount->userName;
          
                                              
          redirect("back",2,"Logged in! Setting up system data...");
          
          
          }
        else
        {                        
                    // Password did not match. 
          echo "Wrong Password.";
          redirect("back",1,"Sending you back to log in form....");
                                
        }     
      
    }
    else
    {
      // Account name was not found
      echo "The account name was not found.";
    }
    
    

// End of login() 
}

function redirect($where,$wait,$write="") 
{
    ?>
    
    <script type="text/javascript">
    <!--
    
    function delayer()
    {
      window.<?PHP if($where=="back") { ?>history.go(-1) <?PHP } else { echo "location =\"".$where."\""; } ?>
    }
    
    setTimeout('delayer()', <?PHP echo $wait * 1000; ?>);
    
    -->
    </script>
    
    <?PHP       
    
    if($write!="") 
    { 
        
        echo "<center>";
        echo "Setting up session...<br />";            
        echo $write;
        echo "</center>";
        
    }       
    
}  


function sessionInfo()
{
    ?>
    
    If would appear that you have ended up in the sessions section without telling us what you want to do. <br /><br />
    What would you like to do?    
        
  <?PHP
}
        


?>