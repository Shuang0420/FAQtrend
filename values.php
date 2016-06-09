<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "FAQsys";


  // 创建连接
  $conn = new mysqli($servername, $username, $password, $dbname);
  //$conn->query("SET NAMES utf8");

  // 检测连接
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $question = $_COOKIE['mycookie'] ? $_COOKIE['mycookie'] : '';
  echo $question."=";
    if ($question == '大盘') {
      $sql = "SELECT date,SUM(count) adjustedCount FROM `FAQsys`.`FQtable` GROUP BY date";
    } else {
      $sql = "SELECT date,adjustedCount FROM `FAQsys`.`FQtable` WHERE question LIKE '".$question."'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 输出每行数据
        while($row = mysqli_fetch_array($result)) {
            echo $row['date'] . "/" . $row['adjustedCount']. "/" ;
        }

    } else {
        echo "0 results";
    }

    mysqli_close($conn);





?>
