<?php
  $servername = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'FAQsys';

  // 创建连接
  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->query('SET NAMES utf8');

  // 检测连接
  if ($conn->connect_error) {
      die('Connection failed: '.$conn->connect_error);
  }
  //$question_multipleLines = $_COOKIE['mycookie2'];
    $question1 = $_COOKIE['mycookie'] ? $_COOKIE['mycookie'] : '';
    echo $question1.'=';
    $sql1 = "SELECT date,dayCount,Count FROM `FAQsys`.`FQtable` WHERE question LIKE '".$question1."'";
    $result1 = $conn->query($sql1);

    if ($result1->num_rows > 0) {
        // 输出每行数据
        while ($row = mysqli_fetch_array($result1)) {
            echo $row['date'].'/'.$row['dayCount'].'/'. 10 * $row['Count'].'/';
        }
    } else {
        echo '0 results';
    }

    mysqli_close($conn);
