<?php
  include_once "dbconnection.php";
  session_start();
  include_once "authLogin.php";
  if(isset($_POST["btn"])){
    $user = $_POST["user"];
    $pass = $_POST["pw"];
    $sql = "SELECT * FROM accts WHERE user = '$user'";
    $result = $conn->query($sql);
    if($row = $result->fetch_assoc()){
      if(password_verify($pass, $row['pass'])){
        $_SESSION['row'] = $row;
        $_SESSION['user'] = $user;
        $_SESSION['uid'] = $row['id'];
        $_SESSION['icon'] = $row['icon'];
        echo "<script>alert('Successfully logged in!'); window.location='home.php';</script>";
      }else{
        echo "<script>alert('User/password is invalid!'); window.location='login.php';</script>";
      }
        echo var_dump($row);
    }else{
      echo "<script>alert('Invalid username/password!');</script>";
    }
  }
?>
<html>
<head>
  <meta charset="utf-8">
  <link href="css/formstyle.css" rel="stylesheet" type="text/css">
  <title>Log-in</title>
</head>

<body>
  <div class="formbox">
    <h1>Log-in</h1>
    <form class="" method="POST">
      <input type="text" id="user" name="user" placeholder="Username">
      <input type="password" id="pw" name="pw" placeholder="Password">
      <button id="btn" name="btn" type="submit">Log-in</button>
      <p>
        Don't have an account yet? <a href="register.php">Sign-up!</a>
      </p>
    </form>
  </div>
</body>
</html>
