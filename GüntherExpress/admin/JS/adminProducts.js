$(".data_edit_button").click(function () {
    if(!$(this).attr('id')){
        return;
    }
    let id = $(this).attr('id');
    if(id.includes("editProduct")){
        let productID = id.split("_")[1];
        runProductSearch(productID);
    }
});

$("#itemidSelect").on('change', function() {
   runProductSearch($("#itemidSelect").val());
});

function runProductSearch(id) {
    $.ajax({
        url: "/admin/includes/ajaxProductData.php",
        type: "POST",
        data: {id : id},
        dataType: "json",
        success: function (data) {
            let editID = $('#itemidSelect');
            let editCategory = $('#editcategory');
            let editname = $('#editname');
            let editimage = $('#editimage');
            let editdescription = $('#editdescription');
            let editprice = $('#editprice');
            let editamount = $('#editamount');
            let deleteInput = $('#hiddenInputDelete');
            let active = $('#editactive');

            editname.focus();
            editID.val(id);
            editCategory.val(data[0]["product_category_id"]);
            editname.val(data[0]["product_name"]);
            editimage.val(data[0]["product_image"]);
            editdescription.val(data[0]["description"]);
            editprice.val(data[0]["price"]);
            editamount.val(data[0]["qty_in_stock"]);
            active.val(data[0]["active"]);
            deleteInput.val(id);
        }
    });
}