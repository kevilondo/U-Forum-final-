//this function will fetch courses from the database everytime the user selects a different university
$(document).ready(function(){

    $('.dynamic').change(function(){
        if($(this).val() !== "")
        {
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();
            
            $.ajax({
               url: "/register/fetch",
               method: "POST",
               data: {select:select, value:value, _token:_token, dependent:dependent},
               success: function(result)
               {
                   $('#'+dependent).html(result);
               } 
            })
        }
    })
})
