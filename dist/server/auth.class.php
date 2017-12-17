<?PHP
session_start();

include_once(__DIR__ . "/db.class.php");


final class Auth
{

	public function __contruct()
	{
		
	}
	
	
	public static function sessionCheck()
	{
		return (isset($_SESSION['id']));		
	}
	
	public static function drawAuthForm()
	{
		?>
		<div class='col-md-offset-2 col-md-8'>
			<form class="form-horizontal" method="post" id="signin" action="/server/session.php?a=1">
			    <div class="form-group">
			        <label for="username" class="control-label col-md-2">Username</label>
			        <div class="col-md-10">
			            <input type="text" class="form-control" id="accountName" name="accountName" required>
			        </div>
			    </div>
			    <div class="form-group">
			        <label for="password" class="control-label col-md-2">Password</label>
			        <div class="col-md-10">
			            <input type="password" class="form-control" id="password" name="password" required>
			        </div>
			    </div>
			    <div class="form-group">
			        <div class="col-md-offset-2 col-md-10">
			            <button type="submit" id="signin_submit" class="btn btn-primary">Login</button>
			        </div>
			    </div>
			</form>
		</div>
	

        <?PHP

	}

}