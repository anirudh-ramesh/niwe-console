$(document).ready(function(){  // or $(function(){
    $("#dropdown").change(function(){
        $.ajax({
        url: "ondemandmenu.php", //ajaxmenu.php
        type:"POST",
        data:{action: $('#dropdown').val()}, 

        beforeSend: function() {
                       $('#show').html('loading please wait..');
                    },

        success: function(result){
            console.log(result);                    
            $(document).ready(function update() {
            setInterval(function update() {
                $('#show').load('ajax_mysql.php') //script2.php
            }, 1000);
        });
            },
            error : function(jqXHR, textStatus, errorThrown){
     }
        });
    });
    
});     