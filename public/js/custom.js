$(document).ready(function (){
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
            $('#preview').show();
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });

    $(document).on('click','.banner-image-update-btn', function (){
        var img_id = $(this).parent().find('.banner-img-id').val();
        var img_url = $(this).closest('.banner-img').find('.card-img').attr('src');
        var external_url = $(this).closest('.banner-img').find('.external_url_link').html();
        $('.modal_banner_image_id').val(img_id);
        $('.modal_external_url').val(external_url);
        $('.preview-banner').attr('src',img_url);
        $('.preview-banner').show();
        $('#bannerUploadImageModal').modal('show');
    });

    $(document).on('click','.category-management-update-btn', function (){
        var category_id = $(this).parent().find('.category-id').val();
        var category_name = $(this).parent().find('.category-name').val();
        console.log(category_name);
        $('.modal_banner_image_id').val(category_id);
        $('.category_name_value').val(category_name);
        $('#bannerUploadImageModal').modal('show');
        $('.preview-banner').attr('src',img_url);
    });

    $(document).on('click','.banner-image-delete-btn', function (){
        var img_id = $(this).parent().find('.banner-img-id').val();
        $('.modal_del_banner_image_id').val(img_id);
        $('#bannerDeleteImageModal').modal('show');
    });

    $('#bannerUploadImageModal').on('hidden.bs.modal', function (e) {
        $('.modal_banner_image_id').val('');
        $('.preview-banner').attr('src','');
        $('.preview-banner').hide();
        $('#banner_image_form')[0].reset();
    });
    $('#bannerDeleteImageModal').on('hidden.bs.modal', function (e) {
        $('.modal_del_banner_image_id').val('');
    });

    //product
    $(document).on('click','.product-update-btn', function (){
        var product_id = $(this).parent().find('.product_id').val();
        var img_url = $(this).parent().find('.product_image').val();
        //var img_url = $(this).closest('.parent-tr').find('.thumb-img').attr('src');
        var name = $(this).closest('.parent-tr').find('.pname').html();
        var category = $(this).parent().find('.category_id').val();
        var product_locked = $(this).parent().find('.product_locked').val();
        $('.modal_product_id').val(product_id);
        $('#category').val(category);
        $('#name').val(name);
        $('.preview-banner').attr('src',img_url);
        $('.preview-banner').show();
        $('#bannerUploadImageModal').modal('show');
        if(product_locked == 1){
            $('.custom-control-checkbox').attr('checked','true')
        }else{
            $('.custom-control-checkbox').removeAttr('checked')
        }
    });

    $(document).on('click','.product-delete-btn', function (){
        var product_id = $(this).parent().find('.product_id').val();
        $('.modal_del_banner_image_id').val(product_id);
        $('#bannerDeleteImageModal').modal('show');
    });

    $('.sortable-banner').sortable({
        animation: 400,
        stop: function( event, ui ) {
            var image_ids = [];
            $('.banner-inner-sortable').each(function (){
                image_ids.push($(this).attr('data-target'));
            });
            $.ajax({
                url: APP_URL+"/admin/banner-images/update/sort",
                method: "POST",
                data: { ids : image_ids },
                dataType: "JSON"
            }).done(function( data ) {
                if(data.status){
                    $().msgpopup({
                        text: 'Order updated successfully!',
                        success: true, // false
                        time: 5000, // or false
                        x: true, // or false
                    });
                }else {
                    $().msgpopup({
                        text: 'There is some issue in updating order',
                        success: false, // false
                        time: 5000, // or false
                        x: true, // or false
                    });
                    $('.sortable-banner').sortable('cancel');
                }
            }).fail(function( jqXHR, textStatus ) {
                $('.sortable-banner').sortable('cancel');
                console.log( "Request failed: " + textStatus );
            });
        }
    }).disableSelection();

    $('.sortable-table-body').sortable({
        axis:'y',
        start:function (event, ui){
            ui.placeholder.height('200');
        },
        stop: function( event, ui ) {
            var image_ids = [];
            $('.sortable-table-row').each(function (){
                image_ids.push($(this).attr('data-target'));
            });
            $.ajax({
                url: APP_URL+"/admin/product/update/order",
                method: "POST",
                data: { ids : image_ids },
                dataType: "JSON"
            }).done(function( data ) {
                if(data.status){
                    $().msgpopup({
                        text: 'Order updated successfully!',
                        success: true, // false
                        time: 5000, // or false
                        x: true, // or false
                    });
                }else {
                    $().msgpopup({
                        text: 'There is some issue in updating order',
                        success: false, // false
                        time: 5000, // or false
                        x: true, // or false
                    });
                    $('.sortable-table-body').sortable('cancel');
                }
            }).fail(function( jqXHR, textStatus ) {
                $().msgpopup({
                    text: 'There is some issue in updating order',
                    success: false, // false
                    time: 5000, // or false
                    x: true, // or false
                });
                $('.sortable-table-body').sortable('cancel');
                console.log( "Request failed: " + textStatus );
            });
        }
    }).disableSelection();

    $(document).on('change','.notification_category',function (){
        var cat_id = $('.notification_category').val();

        $.ajax({
            url: APP_URL+"/admin/category/products",
            method: "POST",
            data: { category_id : cat_id },
            dataType: "JSON"
        }).done(function( data ) {
            var options = "<option value=''>Select Product</option>";
            if(data.status){
                $.each(data.products , function (k,v){
                    options += "<option value='"+v.id+"'>"+v.name+"</option>";
                });
                $('.notification_product').html(options);
            }
            $('.notification_product').html(options);
        }).fail(function( jqXHR, textStatus ) {
            console.log( "Request failed: " + textStatus );
        });

    });

    $('.sortable-category-body').sortable({
        axis:'y',
        start:function (event, ui){
            ui.placeholder.height('100');
        },
        stop: function( event, ui ) {
            var image_ids = [];
            $('.sortable-table-row').each(function (){
                image_ids.push($(this).attr('data-target'));
            });
            $.ajax({
                url: APP_URL+"/admin/category/update/order",
                method: "POST",
                data: { ids : image_ids },
                dataType: "JSON"
            }).done(function( data ) {
                if(data.status){
                    $().msgpopup({
                        text: 'Order updated successfully!',
                        success: true, // false
                        time: 5000, // or false
                        x: true, // or false
                    });
                }else {
                    $().msgpopup({
                        text: 'There is some issue in updating order',
                        success: false, // false
                        time: 5000, // or false
                        x: true, // or false
                    });
                    $('.sortable-table-body').sortable('cancel');
                }
            }).fail(function( jqXHR, textStatus ) {
                $().msgpopup({
                    text: 'There is some issue in updating order',
                    success: false, // false
                    time: 5000, // or false
                    x: true, // or false
                });
                $('.sortable-table-body').sortable('cancel');
                console.log( "Request failed: " + textStatus );
            });
        }
    }).disableSelection();
});
function checkPass()
{
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    var message = document.getElementById('error-nwl');
    var goodColor = "#66cc66";
    var badColor = "#ff6666";

    if(pass1.value.length > 5)
    {
        pass1.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "character number ok!"
    }
    else
    {
        pass1.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = " you have to enter at least 6 digit!"
        return;
    }

    if(pass1.value == pass2.value)
    {
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "ok!"
    }
    else
    {
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = " These passwords don't match"
    }
}