<?php
require '../database/db.php';
session_start();
$output = $contactPerson = $location = $email = $region = null;


if (isset($_POST['search_customer'])) {
    if (!empty($_POST['businessName'])) {
        $businessName = $db->real_escape_string($_POST['businessName']);

        $search = $db->query("SELECT * FROM customers WHERE businessName like '$businessName' ");

        if ($search->num_rows > 0) {
            while ($row = $search->fetch_object()) {
                $contactPerson = $row->contactPerson;
                $location = $row->physicalAddress;
                $email = $row->emailAddress;
                $region = $row->region;
            }
        }
    } elseif (empty($_POST['businessName'])) {
        $output = null;
    }
}


?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>QUOTATION</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../public/styles.css">
    <style type="text/css">
        @media all and (min-width: 992px) {

            .dropdown-menu li {
                position: relative;
            }

            .dropdown-menu .submenu {
                display: none;
                position: absolute;
                left: 100%;
                top: -7px;
            }

            .dropdown-menu .submenu-left {
                right: 100%;
                left: auto;
            }

            .dropdown-menu>li:hover {
                background-color: #f1f1f1
            }

            .dropdown-menu>li:hover>.submenu {
                display: block;
            }
        }


        @media (max-width: 991px) {

            .dropdown-menu .dropdown-menu {
                margin-left: 0.7rem;
                margin-right: 0.7rem;
                margin-bottom: .5rem;
            }

        }
    </style>


    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.dropdown-menu').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            })
            if (window.innerWidth < 992) {


                document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown) {
                    everydropdown.addEventListener('hidden.bs.dropdown', function() {
                        // after dropdown is hidden, then find all submenus
                        this.querySelectorAll('.submenu').forEach(function(everysubmenu) {
                            // hide every submenu as well
                            everysubmenu.style.display = 'none';
                        });
                    })
                });
                document.querySelectorAll('.dropdown-menu a').forEach(function(element) {
                    element.addEventListener('click', function(e) {

                        let nextEl = this.nextElementSibling;
                        if (nextEl && nextEl.classList.contains('submenu')) {
                            // prevent opening link if link needs to open dropdown
                            e.preventDefault();
                            console.log(nextEl);
                            if (nextEl.style.display == 'block') {
                                nextEl.style.display = 'none';
                            } else {
                                nextEl.style.display = 'block';
                            }
                        }
                    });
                })
            }
        });
    </script>

</head>

<body>


    <div class="container-fluid px-0">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/vancepos/views/dashboard.php"><i class="fa fa-columns"></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main_nav">


                    <ul class="navbar-nav">
                        <li class="nav-item active"> <a class="nav-link" href="/vancepos">Home </a> </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">

                                <i class="fa fa-shopping-cart"></i>
                                POS
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"> <i class="fa fa-money"></i> New sale</a></li>
                                <li><a class="dropdown-item" href="#"> <i class="fa fa-shopping-cart"></i> Quotation &raquo; </a>
                                    <ul class="submenu dropdown-menu">
                                        <li><a class="dropdown-item" href="quotation.php"> <i class="fa fa-quote-left"></i> New Quotation</a></li>
                                        <li><a class="dropdown-item" href="process.php"> <i class="fa fa-tasks"></i> Process Quotation</a></li>
                                        <li><a class="dropdown-item" href="#"> <i class="fa fa-truck"></i> Release Quotation</a></li>
                                </li>

                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#"> <i class="fa fa-credit-card"></i> Credit sales </a></li>
                        <li><a class="dropdown-item" href="#"> <i class="fa fa-tasks"></i> Manage All sales </a>
                    </ul>
                    </li>

                    </ul>
                    <ul class="navbar-nav ms-auto">


                        <li class="nav-item dropdown">
                            <a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown"> <i class="fa fa-user"></i> <?php echo $_SESSION['name'] ?> </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="dropdown-item" href="logout.php"> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>
    <div class="container">
        <div class="content my-4">
        <h3>QUOTATION RELEASE</h3>

<form method="POST" action="">
    <div class="form-group">
        <label class="my-3" for="businessName">Search Customer</label>
        <input type="text" name="businessName" id="businessName" class="form-control border" placeholder="Search Customer By Name">
        <div id="suggestCustomer"></div>
    </div>
</form>
<hr>
<div class="search-content" id="displayDataTable">

</div>

<h4>Customer's Quotations</h4>
<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Quotation No</th>
            <th scope="col">Customer Name</th>
            <th scope="col"> Quotation Date</th>
            <th scope="col">Quotation Cost</th>
            <th scope="col">Delivery Date</th>
            <th scope="col">Quotation Status</th>
            <th class="text-center" scope="col">Process</th>

        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Janet Jackson</td>
            <td>2021-12-18 09:29:24</td>
            <td>1,600</td>
            <td>2021-12-18 09:28:08</td>
            <td>PROCESSED</td>
            <td>
                <a href="#" class="btn btn-sm btn-danger ">
                    <i class="fa fa-truck icon-white"></i> Partial Release
                </a>

                <a href="#" class="btn btn-sm btn-danger">
                    <i class="fa fa-truck icon-white"> </i> Release
                </a>
            </td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jake Wright</td>
            <td>2021-12-18 09:29:24</td>
            <td>2,300</td>
            <td>2021-12-18 09:28:08</td>
            <td>PROCESSED</td>
            <td>
            <a href="#" class="btn btn-sm btn-danger ">
                    <i class="fa fa-truck icon-white"></i> Partial Release
                </a>

                <a href="#" class="btn btn-sm btn-danger">
                    <i class="fa fa-truck icon-white"> </i> Release
                </a>
            </td>
        </tr>
     
    


    </tbody>
</table>
<hr>
<table class="table table-bordered table-responsive">
    <thead>
        <tr>
            <th scope="col">Quotation summary</th>
            <th id="totalCost" scope="col">Cost</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">Total Quotation</th>
            <td id="totalQuotation">2</td>
        </tr>
        <tr>
            <th scope="row">Total Quotation Costs</th>
            <td class="text-danger" id="quotationCost">3,900</td>
        </tr>



    </tbody>
</table>



        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

</body>

</html>