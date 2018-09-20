$(function(){
    $('html').keydown(function(e){
        let rightStartMario = 'images/mario_1.png'; let rightEndMario = 'images/mario_3.png';
        let leftStartMario = 'images/mario_6.png'; let leftEndMario = 'images/mario_4.png';
        var w = $(window).innerWidth();
        var imgRight = $('#img_box img').offset().left + 200;
        if (imgRight < 200 && e.which == 37) { return false; }
        if (imgRight > w && e.which == 39) { return false; }
        switch(e.which) {
            case 39:
                var targetImg = $('#img_box img').attr('src');
                if (targetImg == rightStartMario) {
                    $('#img_box img').attr('src', 'images/mario_2.png');
                } else if (targetImg == rightEndMario) {
                    $('#img_box img').attr('src', rightStartMario);
                } else {
                    $('#img_box img').attr('src', rightEndMario);
                }
                $('#img_box img').animate({"marginLeft": '+=10px'}, 200);
                break;
            case 37:
                var targetImg = $('#img_box img').attr('src');
                if (targetImg == leftStartMario) {
                    $('#img_box img').attr('src', 'images/mario_5.png');
                } else if (targetImg == leftEndMario) {
                    $('#img_box img').attr('src', leftStartMario);
                } else {
                    $('#img_box img').attr('src', leftEndMario);
                }
                $('#img_box img').animate({"marginLeft": '-=10px'}, 200);
                break;
        }
    });
});