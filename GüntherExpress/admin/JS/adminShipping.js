$(".data_edit_button").click(function () {
    if (!$(this).attr('id')) {
        return;
    }
    let id = $(this).attr('id');
    if (id.includes("editShipping")) {
        let categoryID = id.split("_")[1];
        runShippingSearch(categoryID);
    }
});

$("#editshipping").on('change', function () {
    runShippingSearch($("#editshipping").val());
});

function runShippingSearch(id) {
    $.ajax({
        url: "/admin/includes/ajaxShippingData.php",
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function (data) {
            let editname = $('#editname');
            let editshipping = $('#editshipping')
            let editprice = $('#editprice');
            let deleteInput = $('#hiddenInputDelete');

            editname.focus();
            editshipping.val(data[0]["id"]);
            editprice.val(data[0]["shipping_price"])
            editname.val(data[0]["shipping_name"]);
            deleteInput.val(id);
        }
    });
}