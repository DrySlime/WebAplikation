<?php

require_once "admin_header.php";
include_once "includes/admin_functions_inc.php";
include_once "../includes/dbh_include.php";
include_once "../includes/functions_include.php";
global $conn;

if (!isset($_SESSION["useruid"])) {
    header('Location: login.php');
    die();
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="CSS/admin.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta charset="UTF-8" http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <title>The Confectioner</title>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawData);

            function drawData() {
                let data = google.visualization.arrayToDataTable([
                    ['Monat', 'Produkte'],
                    <?php
                    $month = getLastMonths();
                    for ($i = 0; $i < sizeof($month); $i++) {
                        if ($i == 7) {
                            echo "['" . $month[$i] . "'," . getOrderCountFromMonth($conn, $month[$i]) . "] \n";
                        }
                        echo "['" . $month[$i] . "'," . getOrderCountFromMonth($conn, $month[$i]) . "], \n";
                    }
                    ?>
                ]);

                let data2 = google.visualization.arrayToDataTable([
                    ['Monat', 'Einnahmen'],
                    <?php
                    $month = getLastMonths();
                    for ($i = 0; $i < sizeof($month); $i++) {
                        if ($i == 7) {
                            echo "['" . $month[$i] . "'," . getSumFromMonth($conn, $month[$i]) . "] \n";
                        } else {
                            echo "['" . $month[$i] . "'," . getSumFromMonth($conn, $month[$i]) . "], \n";
                        }
                    }
                    ?>
                ]);

                let options = {
                    title: '',
                    width: '100%',
                    legend: {position: 'bottom'},
                    vAxis: {
                        title: 'Verkaufte Produkte',
                        minValue: 1
                    },
                    chartArea: {
                        left: 40,
                        width: '90%'
                    },
                    colors: ['#fc466b']
                };
                let options2 = {
                    title: '',
                    width: '100%',
                    legend: {position: 'bottom'},
                    vAxis: {
                        title: 'Einnahmen in EUR',
                        minValue: 1
                    },
                    chartArea: {
                        left: 40,
                        width: '90%'
                    },
                    colors: ['#fc466b']
                };

                let chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
                let chart2 = new google.visualization.LineChart(document.getElementById('revenue_chart'));

                chart.draw(data, options);
                chart2.draw(data2, options2);
            }
        </script>
    </head>

    <body>
    <div class="admin_dashboard_header_wrapper">
        <div class="admin_dashboard_header_container">
            <h1>Admin Dashboard</h1>
            <h4>Willkommen zurück!</h4>
        </div>
        <div class="account_header_image">
            <img src="../img/gummies.png" alt="">
        </div>
    </div>
    <div class="admin_dashboard_wrapper">
        <div class="admin_dashboard_container">
            <div class="admin_dashboard_grid_wrapper">
                <div id="userCount" class="admin_dashboard_grid_container">
                    <div class="grid_container_wrapper">
                        <div class="grid_container_header">
                            <i class="material-icons">person</i>
                        </div>
                        <div class="grid_container_stats">
                            <h1><?php echo getCount($conn, "user") ?></h1>
                            <h4>registrierte Nutzer</h4>
                        </div>
                    </div>
                </div>
                <div id="productCount" class="admin_dashboard_grid_container">
                    <div class="grid_container_wrapper">
                        <div class="grid_container_header">
                            <i class="material-icons">inventory_2</i>
                        </div>
                        <div class="grid_container_stats">
                            <h1><?php echo getCount($conn, "product") ?></h1>
                            <h4>Produkte im Sortiment</h4>
                        </div>
                    </div>
                </div>
                <div id="orderCount" class="admin_dashboard_grid_container">
                    <div class="grid_container_wrapper">
                        <div class="grid_container_header">
                            <i class="material-icons">shopping_bag</i>
                        </div>
                        <div class="grid_container_stats">
                            <h1><?php echo getCount($conn, "orders") ?></h1>
                            <h4>Bestellungen</h4>
                        </div>
                    </div>
                </div>
                <div id="ordersOverview" class="admin_dashboard_grid_container">
                    <div class="grid_container_wrapper">
                        <div class="grid_container_header">
                            <h4>Verkaufte Produkte (Letzten 6 Monate)</h4>
                        </div>
                        <div class="grid_container_data">
                            <div id="curve_chart"></div>
                        </div>
                    </div>
                </div>
                <div id="lastOrders" class="admin_dashboard_grid_container">
                    <div class="grid_container_wrapper">
                        <div class="grid_container_header">
                            <h4>Letzten Bestellungen</h4>
                        </div>
                        <div class="grid_container_side">
                            <?php
                            $data = getLastTenOrders($conn);
                            if (mysqli_num_rows($data) == 0) { ?>
                                <div class="side_container_empty">
                                    <h4>Es gibt noch keine Bestellungen</h4>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="side_grid_wrapper">
                                    <?php
                                    $data = getLastTenOrders($conn);
                                    while ($orderArray = mysqli_fetch_assoc($data)) {
                                        ?>
                                        <div class="side_grid_container">
                                            <div class="admin_orders_info_description">
                                                <h2>Bestellung #<?php echo $orderArray['id'] ?></h2>
                                                <h4>Datum: <?php echo $orderArray['order_date'] ?></h4>
                                                <h4>Anzahl Artikel: <?php // TODO: Add Function?></h4>
                                                <h4>Zahlungsart: <?php echo getPaymentTypeFromOrder($conn, $orderArray['siteuser_id'], $orderArray['id'])['value'] ?></h4>
                                                <h4>Summe: <?php echo $orderArray['order_total'] ?>€</h4>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div id="revenueOverview" class="admin_dashboard_grid_container">
                    <div class="grid_container_wrapper">
                        <div class="grid_container_header">
                            <h4>Monatliche Einnahmen (Letzten 6 Monate)</h4>
                        </div>
                        <div class="grid_container_data">
                            <div id="revenue_chart"></div>
                        </div>
                    </div>
                </div>
                <div id="emptyProducts" class="admin_dashboard_grid_container">
                    <div class="grid_container_wrapper">
                        <div class="grid_container_header">
                            <h4>Ausverkaufte Ware</h4>
                        </div>
                        <div class="grid_container_side">
                            <?php
                            $data = getEmptyProducts($conn);
                            if (mysqli_num_rows($data) == 0) { ?>
                                <div class="side_container_empty">
                                    <h4>Alle Produkte sind noch Vorrätig</h4>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="side_grid_wrapper">
                                    <?php
                                    while ($itemArray = mysqli_fetch_assoc($data)) {
                                        ?>
                                        <div class="side_grid_container">
                                            <div class="admin_orders_info_description">
                                                <h2>Produkt #<?php echo $itemArray['id'] ?></h2>
                                                <h4>Name: <?php echo $itemArray['product_name'] ?></h4>
                                                <h4>Kategorie: <?php echo mysqli_fetch_assoc(getCategorieValueFromID($conn, $itemArray['product_category_id']))['category_name'] ?></h4>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    <script type="text/javascript" src="JS/admin.js"></script>
    </html>
<?php require_once "admin_footer.php" ?>