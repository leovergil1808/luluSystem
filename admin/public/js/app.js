$(document).ready(function () {
    
    
    $("input[attribute ='']").change(function () {
        // var active_ajax = "";
        // var num_order = $(this).val();
        // var product_id = $(this).parent("td").parent("tr").attr("title");
        // // var price = $(this).parent("td").prev(".price").text();

        // var data = {
        //     active_ajax: active_ajax,
        //     product_id: product_id,
        //     num_order: num_order,
        //     // price: price,
        // };

        // $.ajax({
        //     url: "?mod=cart&controller=index&action=update",
        //     method: "POST",
        //     data: data,
        //     dataType: "json",
        //     success: function (data) {
        //         console.log(data)
        //         $(data.str_selector).find("td.total").text(data.sub_total);
        //         $("#total-price > span").text(data.total);
        //         $("span#num").text(data.cart_num_order);
        //     },
        // });
        console.log("hjahahahahah");
    });
    
    // $("#form-slider").on('submit', function() {
        
    //     var data = new FormData(this);
    //     var inputFile = $('#upload-thumb');
    //     var fileToUpload = inputFile[0].files;
        
    //     if (fileToUpload.length > 0) {
    //         var formData = new FormData();
    //         for (var i = 0; i < fileToUpload.length; i++) {
    //             var file = fileToUpload[i];
    //             formData.append('file[]', file, file.name);
    //         }
    //         $.ajax({
    //             url: '?mod=slider&action=uploadSlider',
    //             type: 'post',
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             dataType: 'text',
    //             success: function(data) {
    //                 $("#slider-thumb").html(data);
    //             },
    //             error: function(xhr, ajaxOptions, thrownError) {
    //                 alert(xhr.status);
    //                 alert(thrownError);
    //             }
    //         });
    //     }
    //     //alert('ok');
    //     return false;    
    // });
});
