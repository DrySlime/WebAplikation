$(".data_edit_button").click(function () {
    if (!$(this).attr('id')) {
        return;
    }
    let id = $(this).attr('id');
    if (id.includes("editCategory")) {
        let categoryID = id.split("_")[1];
        runCategorySearch(categoryID);
    }
});

$("#editcategory").on('change', function () {
    runCategorySearch($("#editcategory").val());
});

function runCategorySearch(id) {
    $.ajax({
        url: "/admin/includes/ajaxCategoryData.php",
        type: "POST",
        data: {id: id},
        dataType: "json",
        success: function (data) {
            let editCategory = $('#editcategory');
            let editname = $('#editname');
            let deleteInput = $('#hiddenInputDelete');
            let active = $('#editactive');

            editCategory.val(data[0]["id"]);
            editname.val(data[0]["category_name"]);
            active.val(data[0]["active"]);
            deleteInput.val(id);
        }
    });
}