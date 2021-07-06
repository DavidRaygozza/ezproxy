<?php
    //    disables php warnings
    //error_reporting(E_ERROR | E_PARSE);
    //header('location: index.php?joke/list');
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="jokes.css"> 
		<title><?=$title?></title>
	</head>
	<body>
		
	

	<main>


	<?=$output?>

	</main>
<svg id="footerSvg"xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#F1B434" fill-opacity="1" d="M0,192L60,186.7C120,181,240,171,360,192C480,213,600,267,720,277.3C840,288,960,256,1080,224C1200,192,1320,160,1380,144L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>

<footer style="font-size:small; text-align:center;">
Copyright &copy; David Raygoza 2021
</footer>
	</body>
</html>
