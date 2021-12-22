<?php
require 'database/db.php';
session_start();
if (!isset($_SESSION['name'])) {
    header("Location:views/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME | HOME</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/styles.css">
</head>

<body>
    <div class="container">
        <div class="content my-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="/vancepos">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="views/logout.php">Logout</a>
                        </li>

                    </ul>

                    <div class="notify-user p-2 my-3">Welcome <?php echo $_SESSION['name']; ?> , please select where you would like to go</div>
                    <hr>
                    <div class="card p-3">
                        <h5 class="card-subtitle ">
                            DASHBOARD
                        </h5>
                        <div class="card-text">
                            <p>
                                <i class="fa fa-home"></i>
                                Dashboard area
                            </p>

                        </div>
                        <div class="card-footer">
                            <a href="views/dashboard.php">
                                <i class="fa fa-home"></i>
                                GO TO DASHBOARD
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>