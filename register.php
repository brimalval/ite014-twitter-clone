<?php
  include "dbconnection.php";

  if(isset($_POST["btn"])){
    $user = $_POST["user"];
    $fn = $_POST["fn"];
    $ln = $_POST["ln"];
    $pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
    $cpass = $_POST["cpass"];
    $bday = $_POST["bday"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    //$profile = $_POST["profile"];

    if(password_verify($cpass, $pass)){
      $image = $_FILES['profile']['tmp_name'];
      if($image){
        $target = "uplimg/$user";
        if(!file_exists($target)){
          mkdir($target);
        }
        $icon = $target.basename($_FILES['profile']['name']);
        move_uploaded_file($image, $target.basename($_FILES['profile']['name']));
      }else{
        $icon = "img/profile-default.png";
      }

      $sql = "INSERT INTO accts (user, fn, ln, pass, bday, gender, email, icon, handle) VALUES ('$user', '$fn', '$ln', '$pass', '$bday', '$gender', '$email', '$icon', '$fn')";
      if($conn->query($sql)){
        echo "<script>alert('Successfully registered account!'); window.location = 'login.php';</script>";
      }else{
        echo "<script>alert('$sql'); window.location = 'register.php';</script>";
      }
    }else{
      echo "<script>alert('Passwords don\'t match!'); window.location = 'register.php';</script>";
    }
  }
?>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="css/formstyle.css" rel="stylesheet" type="text/css">
  <title></title>
</head>
<body>
  <div class="formbox">
    <h1>Sign-up</h1>
  <form method="POST" enctype="multipart/form-data">
    <div>
  	<input id="fn" name="fn" type="text" placeholder="First Name" required>
  	<input id="ln" name="ln" type="text" placeholder="Last Name" required>
    </div>
  	<input name="user" type="text" placeholder= "Username" required>
  	<input name="pass" placeholder="Password" type="password" required>
  	<input name="cpass" placeholder="Confirm password" type="password" required>
    Birth-date:
    <input name="bday" id="bday" type="date" required>
  	Gender:
  	<select name="gender" required>
  		<option value="M">Male</option>
  		<option value="F">Female</option>
  	</select>
  	<input name="email" placeholder="E-Mail Address" type="text" required>
    <p>Profile:</p>
    <img style="width:150px;height:150px;" id="myImg" src="img/profile-default.png"><br>
    <input type="file" name="profile" id="uploadfile">
    <p><label for="uploadfile" id="upload">
      <i class="glyphicon glyphicon-file"></i> &nbsp; Upload an image
    </label></p>
    <script src="js/jquery.js"></script>
    <script>
      /*File Upload*/
      $(document).ready(function(){
        $('#uploadfile').change(function(e){
          if(this.files && this.files[0]){
            var img= document.querySelector('#myImg');
            img.src = URL.createObjectURL(this.files[0]);
          }
        });
      });
    </script>
    <button name="btn" id="btn">Sign-up</button>
    </form>
  	<p>Already have an account? <a href="login.php">Log-in</a>
  </div>
</body>
