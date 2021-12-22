<?php
require '../database/db.php';
session_start();
$errors = "";

if (isset($_POST['submit'])) {
    $cardNo = $_POST['cardNo'];
    $password = $_POST['password'];

    if (empty($cardNo) || empty('password')) {
        $errors = 'please fill all required fields';
    } else {
        $cardNo = $db->real_escape_string($cardNo);
        $password = $db->real_escape_string($password);

        $select = $db->query("SELECT id,userName from users WHERE cardNo = '$cardNo' AND password = '$password' ");

        if ($select->num_rows == 0) {
            $errors = "please enter the correct card number and password";
        } else {
            $result =  $select->fetch_object();
            $_SESSION['name'] = $result->userName;
            header("location:/vance");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN | USER</title>
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/styles.css">
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="row justify-content-center my-5 ">
                <div class=" col-sm-12 col-md-6">
                    <div class="card mt-3">
                        <div class="card-header text-center">
                            <div class="container" id="logo"></div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="cardNo">Card No</label>
                                    <input type="password" name="cardNo" id="cardNo" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-success" type="submit" name="submit" value="Verify card">
                                </div>
                            </form>
                            <?php if ($errors) : ?>
                                <div class="alert alert-danger"> <?php echo $errors ?> </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>