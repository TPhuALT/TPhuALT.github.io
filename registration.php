<!-- 
    To do thing before testing:
    Create a new database named "users" and a table "user_accounts" in that data base
        (localhost/phpMyAdmin to access MySQL, username = "root", password = "")
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
<div>
    <?php
        if (isset($_POST['create'])) {

            $uname     = $_POST['uname'];
            $upassword = $_POST['upassword'];
            $uemail    = $_POST['uemail'];
            $ufname    = $_POST['ufname'];
            $ulname    = $_POST['ulname'];

            $connect = new mysqli("localhost", "root", "", "users");
            $stmt = $connect->prepare("INSERT INTO user_accounts (uname, upassword, uemail, ufname, ulname) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $uname, $upassword, $uemail, $ufname, $ulname);
            $result = $stmt->execute();
            
            if ($upassword == $_POST['confirm_password']) {
                if (!($result)) {
                    $inputResult = " * Tài khoản này đã tồn tại.";
                    $result = 0;
                } else {
                    $inputResult = " * Đăng kí thành công";
                }
            } else {
                $error = "* Mật khẩu nhập lại không đúng.";
                $result = 0;
            }

        }
    ?>
</div>

<div id="wrapper">
    <form action="./registration.php" method="POST">
        <h3>Đăng ký</h3>

        <div style="padding-bottom: 10px; color: blue">
            <?php
                if(isset($inputResult)) echo $inputResult;
            ?>
        </div>  

        <div id="countdown" style="color: blue; padding-top:5px;">
            <script>
                var check = <?php echo $result; ?>;
                if (check) {
                    var count = 4;
                    // document.getElementById("countdown").innerHTML = "Chuyển đến trang đăng nhập sau " + count + " giây...";
                    setInterval(function() {
                        count--;
                        document.getElementById("countdown").innerHTML = "Chuyển đến trang đăng nhập sau " + count + " giây...";
                        if (count == 0) {
                            location.href = "./login.php";
                        }
                    }, 1000);
                }
            </script>    
        </div>

        <div class="form-components">
            <input type="text" name="uname" required>
            <label for="uname">Username</label>
        </div>

        <div class="form-components">
            <input type="password" name="upassword" required>
            <label for="upassword">Mật khẩu</label>
        </div>

        <div class="form-components">
            <input type="password" name="confirm_password" required>
            <label for="confirm_password">Nhập lại mật khẩu</label>
        </div>
        
        <div style="padding: 5px; font-size: 16px; box-sizing: content-box; color: red;">
            <?php
                if (isset($error)) echo "<sup>", $error, "</sup>";
            ?>            
        </div>

        <div class="form-components">
            <input type="text" name="uemail" required>
            <label for="uemail">Email</label>
        </div>
        
        <div class="form-components">
            <input type="text" name="ufname" required>
            <label for="uphone">Họ</label>
        </div>

        <div class="form-components">
            <input type="text" name="ulname" required>
            <label for="uphone">Tên</label>
        </div>

        <input type="submit" name="create" value="Đăng ký" id="btn-login">
    </form>
</div>

</body>
</html>