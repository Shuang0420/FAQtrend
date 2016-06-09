<html>
<head>
<title>Highcharts with mySQL and PHP - Ajax101.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<style type="text/css">  /* table design */
	table {
		overflow:hidden;
		border:1px solid #d3d3d3;
		background:#fefefe;
		width:500px;
    top:450px;
		margin:5% auto 0;
    font-size:12px;
		-moz-border-radius:5px; /* FF1+ */
		-webkit-border-radius:5px; /* Saf3-4 */
		border-radius:5px;
		-moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
		-webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
	}

	th, td {padding:18px 28px 18px; text-align:left; }

	th {padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;}

	td {border-top:1px solid #e0e0e0; border-right:1px solid #e0e0e0;}

	tr.odd-row td {background:#f6f6f6;}

	td.first, th.first {text-align:left}

	td.last {border-right:none;}

	/*
	Background gradients are completely unnecessary but a neat effect.
	*/

	td {
		background: -moz-linear-gradient(100% 25% 90deg, #fefefe, #f9f9f9);
		background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f9f9f9), to(#fefefe));
	}

	tr.odd-row td {
		background: -moz-linear-gradient(100% 25% 90deg, #f6f6f6, #f1f1f1);
		background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f1f1f1), to(#f6f6f6));
	}

	th {
		background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed);
		background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#ededed), to(#e8eaeb));
	}

	/*
	I know this is annoying, but we need additional styling so webkit will recognize rounded corners on background elements.
	Nice write up of this issue: http://www.onenaught.com/posts/266/css-inner-elements-breaking-border-radius

	And, since we've applied the background colors to td/th element because of IE, Gecko browsers also need it.
	*/

	tr:first-child th.first {
		-moz-border-radius-topleft:5px;
		-webkit-border-top-left-radius:5px; /* Saf3-4 */
	}

	tr:first-child th.last {
		-moz-border-radius-topright:5px;
		-webkit-border-top-right-radius:5px; /* Saf3-4 */
	}

	tr:last-child td.first {
		-moz-border-radius-bottomleft:5px;
		-webkit-border-bottom-left-radius:5px; /* Saf3-4 */
	}

	tr:last-child td.last {
		-moz-border-radius-bottomright:5px;
		-webkit-border-bottom-right-radius:5px; /* Saf3-4 */
	}

</style>
</head>
<body>

  <div id="div_hot" style="position:absolute;height:200px;top:20px;left:10px">
  <table style="border=1">
  <tr><th>今日热点(top10)</th><th>热度</th></tr>
  <?php
  $conn = new mysqli('localhost', 'root', '', 'FAQsys');
  $conn->query('SET NAMES utf8');
  $result = $conn->query('SELECT * FROM FQrank ORDER BY Chisquare DESC LIMIT 10');
  $count = 0;
  if ($result->num_rows > 0) {
      // 输出每行数据
      while ($row = mysqli_fetch_array($result)) {
          //echo "<option value=".$data['question'].$question == 'option1' ? ' selected' : ''.'>'.$data['question']."</option>\n";
          echo'<tr><td width="250px">'.$row['Question'].'</td><td width="150px">'.$row['Chisquare'].'</td><tr>';
      }
  }
  ?>
  </table>
  </div>

  <?php
        if (isset($_GET['adjusted']) || isset($_GET['two_series'])) {
            echo "<script type='text/javascript'>document.getElementById('div_hot').style.display='none';</script>";
            $question = isset($_GET['type']) ? $_GET['type'] : '';
            setcookie('mycookie', $question);
            //echo "<div style='position:absolute;width:100%;left:0;top:50％'>
            //<table style='margin:0 auto;'></table>
            //</div>";
            echo '<div style="position:absolute;height:200px;top:450px;left:100px">';
            //echo '<center>
            echo '<table style="border=1">';
            //echo '<caption>问题日统计</caption>';
            echo '<tr><th width="300px">日期</th><th>频率</th><th>大盘</th><th width="300px">调整后频率</th></tr>';
            $conn = new mysqli('localhost', 'root', '', 'FAQsys');
            $conn->query('SET NAMES utf8');
            $result = $conn->query("SELECT * FROM FQtable WHERE question = '".$question."'");

            if ($result->num_rows > 0) {
                // 输出每行数据
                while ($row = mysqli_fetch_array($result)) {
                    //echo "<option value=".$data['question'].$question == 'option1' ? ' selected' : ''.'>'.$data['question']."</option>\n";
                  echo'<tr><td width="300px">'.$row['Date'].'</td><td>'.$row['Count'].'</td><td>'.$row['dayCount'].'</td><td width="300px">'.$row['adjustedCount'].'</td><tr>';
                }
            }

            echo '</table>';
            //echo '</center>';
            echo '</div>';

            echo '<div style="position:absolute;height:200px;top:450px;left:700px">';
            //echo '<center>
            echo '<table style="border=1">';
            //echo '<caption>原始问题范例</caption>';
            //可以选择改成与左边table行数相同，即行数＝date
            echo '<tr><th>原始问题范例(前75条)</th></tr>';
            $conn = new mysqli('localhost', 'root', '', 'FAQsys');
            $conn->query('SET NAMES utf8');
            $result = $conn->query("SELECT DISTINCT originalQuestion FROM Questions WHERE question = '".$question."' ");
            $count = 0;
            if ($result->num_rows > 0) {
                // 输出每行数据
                while ($row = mysqli_fetch_array($result)) {
                    //echo "<option value=".$data['question'].$question == 'option1' ? ' selected' : ''.'>'.$data['question']."</option>\n";
                  if (strpos($row['originalQuestion'], '##') !== false) {
                      $originalQuestion = explode('##', $row['originalQuestion']);
                      foreach ($originalQuestion as $value) {
                          if ($count < 75) {
                              echo'<tr><td>'.$value.'</td><tr>';
                              ++$count;
                          }
                      }
                  } else {
                      if ($count < 75) {
                          echo'<tr><td width="500px">'.$row['originalQuestion'].'</td><tr>';
                          ++$count;
                      }
                  }
                }
            }

            echo '</table>';
            //echo '</center>';
            echo '</div>';

            if (isset($_GET['adjusted'])) {
                echo '<script type="text/javascript" src="data2.js" charset="utf-8" ></script>';
            } else {
                echo '<script type="text/javascript" src="data.js" charset="utf-8" ></script>';
            }
        }

  ?>

  <form name="input" action="#" method="get">
  Question:
  <?php
    $record = 0;
    $conn = new mysqli('localhost', 'root', '', 'FAQsys');
    $conn->query('SET NAMES utf8');
    $result = $conn->query('SELECT DISTINCT Question question FROM (SELECT question,SUM(adjustedCount) FROM FQtable GROUP BY date,Question ORDER BY SUM(adjustedCount) DESC) AS A LIMIT 50');

    echo "<select name=type size=1>\n";
    if ($result->num_rows > 0) {
        // 输出每行数据
        while ($data = mysqli_fetch_array($result)) {
            //echo "<option value=".$data['question'].$question == 'option1' ? ' selected' : ''.'>'.$data['question']."</option>\n";
          echo '<option value='.$data['question'].'>'.$data['question']."</option>\n";
        }
    }
    mysqli_close($conn);

    echo "</select>\n";
  ?>
  <input type="submit" value="adjusted" name="adjusted"/>
  <input type="submit" value="two_series" name="two_series"/>
  </form>

<div id="chart" style="height: 400px; margin: 0 auto"></div>


</body>
</html>
