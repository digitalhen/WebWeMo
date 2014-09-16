<?php
	echo "<p>Copyright &copy; 1999-" . date("Y") . " W3Schools.com</p>";
	
	include 'libs/WeMo-PHP-Toolkit-master/models/Device.php';
	include 'libs/WeMo-PHP-Toolkit-master/models/Outlet.php';

	  $outlet = new \wemo\models\Outlet("192.168.1.186");
	  echo $outlet->getName();
?>
<html>
<head>

</head>
<body>
</body>
</html>