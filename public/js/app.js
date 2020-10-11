$(document).ready(function () {
    
    $(".table tbody select").change(function () {
        
        var status = $(this).val()
        var student_id = $(this).parent().parent().attr('data-id')
        
        var data = {
            status : status,
            student_id : student_id
        };
        if(status != ""){
            $.ajax({
                url: "?mod=users&action=editAjax",
                method: "POST",
                data: data,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    var selector_student = "tr[data-id ='" + data.student_id + "']";
                    $(selector_student).children('td:eq(4)').children('span').text(data.status)
                },
            });
        }
        
    });
});


