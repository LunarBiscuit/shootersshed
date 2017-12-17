<?PHP

class Nav
{

	var $page = "";

	function __construct($page)
	{
		$this->page = $page;
	}
	
	
	function bar()
	{
		?>
		
		
		<nav class="navbar navbar-inverse " role="navigation">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle Nav</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand visible-xs" href="#">Shooters Bar</a>
		    </div>
                    
                    <?PHP $aniClass = 'active'; ?>
		
		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li <?PHP echo (($this->page == "about")? "class='$aniClass'" : "") ?>><a href="/">About</a></li>
		        <li <?PHP echo (($this->page == "gallery")? "class='$aniClass'" : "") ?>><a href="/gallery.php">Gallery</a></li>
                        <li <?PHP echo (($this->page == "events")? "class='$aniClass'" : "") ?>><a href="/events/">Events</a></li>
                        
                        <li <?PHP echo (($this->page == "shhh")? "class='$aniClass'" : "") ?>><a href="/shhh.php">Shhh</a></li>
                        
                        <li <?PHP echo (($this->page == "booths")? "class='$aniClass'" : "") ?>><a href="/booths.php">Booths</a></li>
                        
                        
                        <li <?PHP echo (($this->page == "loyalty")? "class='$aniClass'" : "") ?>><a href="/loyalty.php">Loyalty</a></li>
		        <li <?PHP echo (($this->page == "contact")? "class='$aniClass'" : "") ?>><a href="/contact.php">Contact</a></li>
                        
		        
		      </ul>
	
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		
		
		<?PHP
	}

}


?>


