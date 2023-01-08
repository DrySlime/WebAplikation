$(":button").click(function () {
    if ($(this).attr('class') === undefined) {
        return;
    }
    let classList = $(this).attr('class').split(/\s+/);
    $.each(classList, function (index, classItem) {
        let classData = classItem;
        if (classData.includes("reset")) {
            let form = classData.split("_")[1];
            document.getElementById(form).reset();
            switch (form) {
                case "searchUserForm":
                    window.location.href = "admin_users.php";
                    break;
                case "searchProductForm":
                    window.location.href = "admin_products.php";
                    break;
                case "searchOrderForm":
                    window.location.href = "admin_orders.php";
                    break;
                case "searchCategoryForm":
                    window.location.href = "admin_categories.php";
                    break;
                case "searchShippingForm":
                    window.location.href = "admin_shipping.php";
                    break;
            }
        }
    });
});