<?php

function getRating($conn, $productID)
{
    #returns a double value between 1-5

    $rating = 0;

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

            $row = mysqli_fetch_assoc($resultData);
            $ratingArr[] = $row["rating_value"];
        }

        foreach ($ratingArr as $singleRating) {
            $rating += $singleRating;
        }
        $rating = $rating / count($ratingArr);
    }
    return $rating;
}

function getAllFromReview()
{
    #returns a 2d Array filled with all review informations
}

function getOwnProductReview($conn, $product)
{
    session_start();

    #shows review information for one product for the person
    $sql = "SELECT * FROM user_review WHERE ordered_product_id = ? AND siteuser_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userid'], $product);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_write_close();
}

function getProductBasedReview($conn, $product)
{
    #shows review information for one product for the person
    $sql = "SELECT * FROM user_review INNER JOIN order_line ON user_review.ordered_product_id = order_line.id WHERE user_review.siteuser_id = ? AND order_line.product_item_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $_SESSION['userid'], $product);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return mysqli_fetch_assoc($resultData);
}

function addReview($conn, $product, $rating)
{
    session_start();

    #adds review information for one product
    $sql = "INSERT INTO user_review (siteuser_id, ordered_product_id, rating_value) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $_SESSION['userid'], $product, $rating);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_write_close();
}

function updateReview($conn, $productID, $rating){
    session_start();

    $sql = "SELECT id FROM user_review WHERE ordered_product_id IN (SELECT id FROM order_line WHERE product_item_id = ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $productID);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $resultData = mysqli_fetch_assoc($resultData)["id"];

    mysqli_stmt_close($stmt);

    $sql = "UPDATE user_review SET rating_value = ? WHERE siteuser_id = ? AND user_review.id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $rating, $_SESSION['userid'], $resultData);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_write_close();
}

function checkReview($conn, $productID)
{
    $sql = "SELECT COUNT(*) AS count FROM user_review WHERE ordered_product_id IN (SELECT id FROM order_line WHERE product_item_id = ?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../account.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $productID);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return mysqli_fetch_assoc($resultData)["count"];
}