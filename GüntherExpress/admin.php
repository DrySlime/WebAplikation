<?php require_once "header.php"?>
<head>
    <link rel="stylesheet" href="CSS/admin.css">
    <title></title>
</head>
<body>
    <div><br><br><br></div>
    <hr>
    <div class="parentbox">
        <div class="Produkte">
            <a href="product_admin.php">
                <button class="button">
                    Produkte
                </button>
            </a>
        </div>
        <div class="Kategorien">
            <a href="category_admin.php">
                <button class="button">
                    Kategorien
                </button>
            </a>
        </div>
        <div class="Versandmethoden">
            <a href="shippingmethod_admin.php">
                <button class="button">
                    Versandmethoden
                </button>
            </a>
        </div>
        <div class="Bestellungen">
            <a href="orderedProducts_admin.php">
                <button class="button">
                    Bestellungen
                </button>
            </a>
        </div>
        <div class="Nutzer">
            <a href="userList_admin.php">
                <button class="button">
                    Benutzer
                </button>
            </a>
        </div>
    </div>

</body>
<?php require_once "footer.php"?>