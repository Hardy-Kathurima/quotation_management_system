<?php
require '../database/db.php';
session_start();

if (isset($_GET['customer'])) {
    $customer = $_GET['customer'];
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
    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="#item-form">
                        <input type="hidden" id="updateId">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="itemCost">Item Cost</label>
                                    <input type="number" id="itemCost" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" id="quantity" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="totalCost">Total Cost</label>
                                    <input type="number" id="totalCost" class="form-control" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="form-group my-3"> <button type="button" onclick="updateItem()" class="btn btn-primary">Edit item</button></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>


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
                                        <li><a class="dropdown-item" href="#"> <i class="fa fa-tasks"></i> Process Quotation</a></li>
                                        <li><a class="dropdown-item" href="release.php"> <i class="fa fa-truck"></i> Release Quotation</a></li>
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

            <h3>QUOTATION PROCESSING</h3>
            <div class="my-4">
                <a href="process.php" type="button" class="btn btn-primary">
                    <i class="fa fa-hourglass-end icon-white"></i> Finish adjusting
                </a>

                <a href="#" type="button" class="btn btn-success">
                    <i class="fa fa-plus icon-white"></i> Add items
                </a>

                <div id="displayUpdate"></div>
            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {

            displayUpdate();
        });

        function editItem(updateId) {
            $("#updateModal").modal("show");
            $("#updateId").val(updateId);

            $.post("update_item.php", {
                updateId: updateId
            }, function(data, status) {
                var order_id = JSON.parse(data);

                $("#quantity").val(order_id.quantity);
                $("#itemCost").val(order_id.itemCost);
                $("#totalCost").val(order_id.totalCost);
            });
        }

        function displayUpdate() {
            var customer = '<?php echo $customer; ?>';
            $.ajax({

                url: 'fetch_edit.php',
                method: "POST",
                data: {
                    customer: customer
                },
                success: function(data) {
                    $('#displayUpdate').html(data);
                }

            });
        }

        function updateItem() {
            var itemQuantity = $("#quantity").val();
            var itemCost = $("#itemCost").val();
            var totalCost = itemCost * itemQuantity;
            $.ajax({
                url: "update_item.php",
                method: "POST",
                data: {
                    itemCost: itemCost,
                    itemQuantity: itemQuantity,
                    totalCost: totalCost
                },
                success: function(data) {
                    $("#updateModal").modal("hide");


                    setTimeout(() => {
                        displayUpdate();
                    }, 1000);
                }
            });
        }
    </script>

</body>

</html>