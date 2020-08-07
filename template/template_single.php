<?php
global $jag_api;
$template_api = $jag_api->template;
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var html = "";
    var key = '<?php _e($template_api['key']) ?>';
    var ajax_url = '<?php _e($template_api['ajax_url']) ?>';
    var api_url = '<?php _e($template_api['url']) ?>';
    var action = '<?php _e($template_api['action']) ?>';
    var element = '<?php _e($template_api['elementor']) ?>';
    $.ajax({
        type: 'GET',
        url: api_url,
        headers: {
            key: key
        }
        success: function(data){
            $.each(data.data, function(index, item){
                var data_ajax = {
                    'action': action,
                    data: item,
                }
                $.post(ajax_url,data_ajax,function(resulf){
                    $(element).append(resulf);
                })

            })
        },
        error: function(errors){
            console.log(errors);
        }
    })
</script>
