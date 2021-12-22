<?php
require '../database/db.php';
session_start();
$output = $customerPhone = $location  = null;



if (isset($_POST['search_customer'])) {
    if (!empty($_POST['customerName'])) {
        $customerName = $db->real_escape_string($_POST['customerName']);

        $search = $db->query("SELECT * FROM customers WHERE customerName like '$customerName' ");

        if ($search->num_rows > 0) {
            while ($row = $search->fetch_object()) {
                $customerPhone = $row->customerPhone;
                $location = $row->customerLocation;
                $customerRef = $row->customerRef;
            }
        }
    } elseif (empty($_POST['customerName'])) {
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
    <link href="../public/print.css" rel="stylesheet" media="print" type="text/css">
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
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add item to quote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="#item-form">
                        <input type="hidden" name="itemId" id="setId">
                        <div class="form-group mb-2 item-search ">
                            <label for="item">Select item</label>
                            <input type="text" name="item" id="item" class="form-control">
                            <div class="suggestions my-3" id="suggestions"></div>
                        </div>
                        <div id="test-value"></div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="selectedItem">Item</label>
                                    <input type="text" name="selectedItem" id="selectedItem" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="item">Selected item cost</label>
                                    <input type="number" name="" id="itemCost" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="item">Quantity</label>
                                    <input type="number" name="" id="quantity" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item">Delivery cost</label>
                                    <input type="number" name="" id="deliveryCost" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item">Additional cost</label>
                                    <input type="number" name="" id="additionalCost" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row my-2">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="itemCategory">Item Category</label>
                                    <input type="text" name="" id="itemCategory" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group my-3"> <button type="button" onclick="setItems()" class="btn btn-success">Add item</button></div>
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
                                        <li><a class="dropdown-item" href="#"> <i class="fa fa-quote-left"></i> New Quotation</a></li>
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

            <h4>QUOTATION</h4>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="customerName">Search Customer</label>
                    <input type="text" name="customerName" id="customerName" class="form-control">
                    <div id="suggestCustomer"></div>
                </div>
            </form>
            <hr>
            <div class="search-content" id="displayDataTable">

            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="customerPhone" class="mb-2">Mobile</label>
                        <input type="text" name="customerPhone" id="customerPhone" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="customerLocation" class="mb-2">Location</label>
                        <input type="text" name="customerLocation" id="customerLocation" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="customerRef" class="mb-2">Customer Ref</label>
                        <input type="text" name="customerRef" id="customerRef" class="form-control">
                    </div>
                </div>


            </div>

            <div class="my-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add item to quote
                </button>
                <button class="btn btn-dark" id="resetInputs" onclick="resetItems()">Refresh Items</button>
            </div>
            <hr>
            <div id="displayTable">
                <h1 id="customer"></h1>
            </div>


            <hr>


            <hr>

            <div class="bg-primary text-white p-2">
                special instructions
            </div>


            <div>
                <form action="" class="my-3">
                    <div class="form-group">
                        <label for="special" class="my-2">Enter special Instructions</label>
                        <textarea name="" id="special" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div>

                <a href="" id="savePdf" target="_blank" class="btn btn-success" onclick="savePdf(event)">save quotation</a>


            </div>


        </div>


    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- <script src="../public/main.js"></script> -->
    <script>
        $(function() {
            load_quotations();



            // search customer
            $("#customerName").keyup(function() {
                var customerName = $(this).val();
                $.ajax({
                        method: "POST",
                        url: "search_customer.php",
                        data: {
                            customerName: customerName
                        }
                    })
                    .done(function(data) {
                        $("#suggestCustomer").show();
                        $("#suggestCustomer").html(data);
                    });

            });

            // end search
            $("#item").keyup(function() {
                var itemName = $(this).val();
                $.ajax({
                        method: "POST",
                        url: "search_item.php",
                        data: {
                            item: itemName
                        }
                    })
                    .done(function(data) {
                        $("#suggestions").show();
                        $("#suggestions").html(data);
                    });

            });



        });

        // getcustomer
        function getCustomer(customerId, customerName) {

            $.ajax({
                type: 'get',
                url: 'getCustomer.php?customerId=' + customerId,
                success: function(data) {
                    var data = jQuery.parseJSON(data);
                    $.each(data, function(index, value) {
                        $('#customerPhone').val(value.customerPhone);
                        $('#customerLocation').val(value.customerLocation);
                        $('#customerRef').val(value.customerRef);

                    });
                }
            })


        }

        // end get customer

        function getData(stockId, itemName) {

            $.ajax({
                type: 'get',
                url: 'getData.php?stockId=' + stockId,
                success: function(data) {
                    var data = jQuery.parseJSON(data);
                    $.each(data, function(index, value) {
                        $('#setId').val(value.stockId)
                        $('#selectedItem').val(value.itemName);
                        $('#itemCost').val(value.itemCost);

                        $('#itemCategory').val(value.itemCategory);
                        $('#quantity').val(1);
                        $('#additionalCost').val(0);
                        $('#deliveryCost').val(0);

                    });
                }
            })


        }


        function selectItem(stockId, itemName) {
            $("#item").val(itemName);
            $("#suggestions").hide();
            getData(stockId, itemName);

        }

        function selectCustomer(customerId, customerName) {
            $("#customerName").val(customerName);
            $("#suggestCustomer").hide();
            getCustomer(customerId, customerName);

        }

        function load_quotations() {
            $.ajax({

                url: 'fetch_quote.php',
                method: "POST",
                success: function(data) {
                    $('#displayTable').html(data);
                }

            });
        }

        function setItems() {
            var displayData = 'true';
            var customerName = $("#customerName").val();
            var customerPhone = $("#customerPhone").val();
            var customerLocation = $("#customerLocation").val();
            var customerRef = $("#customerRef").val();
            var quantity = $('#quantity').val();
            var itemId = $('#setId').val();
            var itemCost = $('#itemCost').val();
            var deliveryCost = $('#deliveryCost').val();
            var itemName = $('#item').val();
            var additionalCost = $('#additionalCost').val();
            var itemCategory = $('#itemCategory').val();
            var totalCost = parseInt($("#quantity").val()) * parseInt($("#itemCost").val());


            $.ajax({
                type: 'post',
                url: 'addItem.php',
                data: {
                    itemId: itemId,
                    quantity: quantity,
                    displayData: displayData,
                    additionalCost: additionalCost,
                    deliveryCost: deliveryCost,
                    itemCost: itemCost,
                    itemCategory: itemCategory,
                    customerLocation: customerLocation,
                    customerName: customerName,
                    customerRef: customerRef,
                    customerPhone: customerPhone,
                    itemName: itemName,
                    totalCost: totalCost

                },
                success: function(data, status) {
                    load_quotations();
                    $('#displayTable').html(data);


                }


            });


            $('#exampleModal').modal('hide');


        }

        function resetItems() {
            var clearData = "true";

            $.ajax({
                url: "clear.php",
                method: 'POST',
                data: {
                    clearData: clearData
                },
                success: function(data, status) {
                    alert("all quotations have been cleared");
                    setTimeout(() => {
                        load_quotations();
                    }, 1000);
                }
            });

        }

        function savePdf(event) {
            var customerName = $('#customerName').val();
            var quotationCost = $("#totalQuotation").text();
            var special = $("#special").val();
            var customerPhone = $("#customerPhone").val();
            var customerLocation = $("customerLocation").val();
            if (!customerName && !special) {
                alert("please fill all the required fields");
                event.preventDefault();
            }
            if (!quotationCost) {
                alert("no quotation added");
                event.preventDefault();
            }

            if (customerName && quotationCost) {
                // pdf data
                var custom = $('#customerName').val();
                var phone = $('#customerPhone').val();
                var ref = $("#customerRef").val();
                var location = $("#customerLocation").val();
                var quotationNo = Math.floor(Math.random() * 100) + 1;

                var link = `save_quote.php?customer=${custom}&phone=${phone}&location=${location}&quotation=${quotationNo}&ref=${ref}`;
                $("#savePdf").attr("href", link);


                // end pdf data
                $.ajax({
                    method: "POST",
                    url: "capture.php",
                    data: {
                        customerName: customerName,
                        quotationCost: quotationCost,
                        special: special,
                        customerPhone: customerPhone,
                        customerLocation: customerLocation
                    },
                    success: function(data, status) {
                        setTimeout(() => {
                            load_quotations();
                        }, 2000);
                    }
                });
            }


        }

        function deleteItem(itemId) {
            var itemId = itemId;
            var action = 'delete';

            if (confirm("are you sure you want to remove this quotation?")) {
                $.ajax({
                    url: 'clear.php',
                    method: "POST",
                    data: {
                        itemId: itemId,
                        action: action
                    },
                    success: function(data) {
                        setTimeout(() => {
                            load_quotations();
                        }, 1000);
                    }
                })
            }

        }
    </script>
</body>

</html>