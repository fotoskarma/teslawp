jQuery(function($){
    var video_checkbox = $('#teslawp_featured_video_input_check_id');
    var video_url = $('#teslawp_featured_video_input_id');
    video_checkbox.change(function(){
        if(video_checkbox.prop('checked'))
            video_url.css({display:'inline-block'});
        else
            video_url.css({display:'none'});
    });
});