<html>
<head>
<title>Highcharts with mySQL and PHP - Ajax101.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="data2.js" charset="utf-8" ></script>
</head>
<body>
  <?php
  $question1 = isset($_GET['type']) ? $_GET['type'] : '';
  setcookie('mycookie1',$question1);
  ?>
<div id="chart" style="height: 400px; margin: 0 auto"></div>



</body>
</html>
