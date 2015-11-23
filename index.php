<?PHP
	require_once __DIR__.'/includes/config.inc.php';

	include("includes/header.inc.php");
	require_once("classes/Tools.class.php");
	
	if(isset($_GET['site'])){
		$site = $_GET['site'];
	}
	else {
		$site='main';
	}
	
	switch($site){
		case 'users':
			include 'includes/user.inc.php';
			break;
		case 'events':
			include 'includes/events.inc.php';
			break;
		case 'aq':
			include 'includes/aq.inc.php';
			break;
		case 'main';
			include 'includes/main.inc.php';
			break;
		case 'aqform';
			include 'includes/aqResultForm.inc.php';
			break;
		case 'aqresult';
			include 'includes/aqResultShow.inc.php';
			break;
		case 'userform';
			include 'includes/userForm.inc.php';
			break;
	}

	include("includes/footer.inc.php");
?>