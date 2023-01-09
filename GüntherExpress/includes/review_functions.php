<?php

function getAvrgRating($conn, $productID)
{
    #this returns the average rating of the product
    #returns a double value between 1-5 which represents the rating from the $productID
    $sql = "SELECT id FROM order_line WHERE product_item_id =?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $productID);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $orderLine[] = $row["id"];;
        }
    } else {
        $orderLine = null;
    }
    mysqli_stmt_close($stmt);
    $rating = 0;
    if ($orderLine != null) {
        for ($i = 0; $i < count($orderLine); $i++) {
            $sql = "SELECT rating_value FROM user_review WHERE ordered_product_id =?;";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "s", $orderLine[$i]);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($resultData)) {
                $ratingArr[] = $row["rating_value"];
            }
        }
        foreach ($ratingArr as $singleRating) {
            $rating += $singleRating;
        }

        $rating = $rating / count($ratingArr);

        mysqli_stmt_close($stmt);
    }
    return $rating;
}

function getUsername($conn, $userID)
{
    $sql = "SELECT user_uid FROM site_user WHERE id =$userID;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        $row = mysqli_fetch_assoc($resultData);
        $username = $row["user_uid"];

    }
    return $username;
}

function getNewestProducts($conn, $amount)
{
    #get $amount many products in an Array sorted by releaseDate

    $sql = "SELECT product_name, product_image, price, id FROM product ORDER BY id DESC LIMIT $amount;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $product["product_name"] = $row["product_name"];
            $product["product_image"] = $row["product_image"];
            $product["price"] = $row["price"];
            $product["id"] = $row["id"];
            $productArr[] = $product;
            unset($product);
        }
    }
    return $productArr;
}

function getBestRatedProducts($conn, $amount)
{
    #get $amount many best rated productIDS to work with in an Array

    $sql = "SELECT id FROM product ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }

//    mysqli_stmt_prepare($stmt,$sql);
//    mysqli_stmt_bind_param($stmt,"s",$productID);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $productIDs[] = $row["id"];;
        }
    }

    for ($i = 0; $i < count($productIDs); $i++) {
        $product["AvgPrice"] = getAvrgRating($conn, $productIDs[$i]);
        $product["id"] = $productIDs[$i];
        $productArr[] = $product;
        unset($product);
    }

    uasort($productArr, fn($a, $b) => $a['AvgPrice'] <=> $b['AvgPrice']);
    $productArr = array_reverse($productArr);

    if ($amount > count($productArr)) {
        $amount = count(($productArr));
    }

    for ($i = 0; $i < $amount; $i++) {
        $finalArr[] = $productArr[$i]["id"];
    }
    return $finalArr;
}

?>
