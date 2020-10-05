
<?php
	//echo "---AUTH---";
	$passes = array("go");
	function update($pass) {
	    return md5(strtolower($pass.date("H")));
	}
	// Apply update function on all keywords of $passes array
	$passes = array_map("update", $passes);
	// Get $pass in POST params (from password form below); if valid then redirect
	if (!empty($_POST)) {
		$pass = $_POST['pass'];
		$valid = true;
		if (empty($pass)) {
			$passError = 'Entrer un pass valide, non vide';
			$valid = false;
		}
		if (!in_array(md5(strtolower($pass)), $passes)) {
			$passError = 'Entrer un pass valide';
			$valid = false;
		}
		echo $valid;
		if ($valid) {
			// Write the cookie in the browser with the MD5 encrypted password value, validity time is 2 min (1200s)
			setcookie('pass', md5($pass), (time() + 1200));
			// Redirect to the desired page
			header("Location: ".$_SERVER['PHP_SELF']);
		}
	}
	$cookie = $_COOKIE['pass'];
	$token = $_GET['token'];
	$ref_token = "go".date("H");
	// Check if the cookie value is not empty : that means that the user browser has a valid cookie (the user has already entered the password with the form)
	// Check also if the token provided in the url fit ref_token value
	// echo "Token is ".$token."\n";
	// echo "Token compare is ".strcmp($token, $ref_token)."\n";
	if(strcmp($token, $ref_token)!=0 && $cookie=="") { 
		?>
		<div class="container">
			<div class="span10 offset1">
				<div class="row">
					<div class="col-md-4">
						<h3>Votre code ?</h3>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
							<div class="control-group <?php echo !empty($passError)?'error':'';?>">
								<label class="control-label"><font color='#FFFFFF'>pass</font></label>
								<div class="controls">
									<input name="pass" type="text" placeholder="pass" value="" autofocus>
								</div>
								<?php if (!empty($passError)): ?>
									<span class="help-inline"><font color='#FFD700'><?php echo $passError;?></font></span>
								<?php endif; ?>
							</div>
							<p/>
							<div class="form-actions">
								<button type="submit" class="btn btn-success">Essayer</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
		exit("");
	} else {
		// Cookie is not empty
		// TODO => verify here if the cookie has a good content ???
		// echo "Ref token is ".$ref_token."\n";
		// echo "Cookie not empty : ".$cookie." => good value ?\n";
		// echo "Display the initial target page content";
	}
	//echo "---END AUTH---";
?>

