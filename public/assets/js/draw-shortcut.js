// Handle sidebar menu
function openCloseMenu() {
    let menu = $('.js-menu-toggle');

    if ($('body').hasClass('show-sidebar')) {
        $('body').removeClass('show-sidebar');
        menu.removeClass('active');
    } else {
        $('body').addClass('show-sidebar'); 
        menu.addClass('active');
    }
}

// Handle direction of menu
function up(){
    if ($('body').hasClass('show-sidebar')){
        var index = $('li').index($('.menu-item.active'))
        if(index == 0){
            index = $('li.menu-item').length
        }

        $('body').find('.menu-item.active').removeClass('active')
        $('li.menu-item').eq(index-1).addClass('active')
    }  
}

function down(){
    if ($('body').hasClass('show-sidebar')){
        var index = $('li').index($('.menu-item.active'))
        if(index == $('li.menu-item').length-1){
            index = -1
        }

        $('body').find('.menu-item.active').removeClass('active')
        $('li.menu-item').eq(index+1).addClass('active')
    } else{
         // Scrollbar category
        if($('#ul-scroll')[0]){
            $('#ul-scroll li.selected').focus();
        }
        // console.log('masuk')
        if($('#category_select')[0]){
            $('#category_select').focus();
        }
    }  
}

function left(){
    if($('#carouselExampleControls')[0]){
        $('#carouselExampleControls').carousel('prev');
    }
}

function right(){
    if($('#carouselExampleControls')[0]){
        $('#carouselExampleControls').carousel('next');
    }
}


// Handle draw button
function goToDraw(){
    if ($('body').hasClass('show-sidebar')){
        chooseMenu();
    } else{
        if ($('.draw-btn')[0]) {
            if($('#redraw')[0]){
                let category = $('#redraw').attr('value');
                $('#cont').load(url+'?category='+category);
            } else{
                if($('.swal-modal')[0]){
                } else{
                    let category = $('#ul-scroll li.selected').attr('value');
                    let uri = url + '?category='+category;
                    $('#cont').load(uri);
                }
            }
        } else if ($('.draw')[0]){
            $('#cont').load(drawing_url);
        } else{
            if($('#ul-scroll')[0]){
                $('#cont').load(url);
            } else{
                $('#cont').load(winner_url);   
                clearInterval(showEven);
                clearInterval(showOdd);
                clearInterval(hideOdd);
                clearInterval(hideEven);
            }
        }
    }
}

function doBounce(element, times, distance, speed) {
    for(i = 0; i < times; i++) {
        element.animate({marginTop: '-='+distance},speed)
            .animate({marginTop: '+='+distance},speed);
    }        
}


// Handle fullscreen
function fullScreen(){
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
            document.documentElement.msRequestFullscreen();
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

function chooseMenu(){
    if($('body').hasClass('show-sidebar')){ // Menu
        let menu = $('li.menu-item.active').attr('value');
        if(menu=='draw'){
            $('#cont').load(menu_url+'/new');
        } else if(menu=='recent') {
            $('#cont').load(menu_url+'/'+menu);
        } else{
            $('.main-content').load(menu_url+'/'+menu);
        }
        $('body').removeClass('show-sidebar');
        $('.js-menu-toggle').removeClass('active');
    }
}

function goToNew(){
    $('#cont').load(menu_url+'/new');
    $('body').removeClass('show-sidebar');
    $('.js-menu-toggle').removeClass('active');
}

function goToRecent(){
    $('#cont').load(menu_url+'/recent');
    $('body').removeClass('show-sidebar');
    $('.js-menu-toggle').removeClass('active');
}

function goToHistory(){
    $("#loading").fadeIn("slow");
    $('body').removeClass('show-sidebar');
    $('.js-menu-toggle').removeClass('active');
    $('#cont').load(menu_url+'/history');
}

// Bind
Mousetrap.bind({
    'm': openCloseMenu,
    'M' : openCloseMenu,
    'enter' : goToDraw,
    'up' : up,
    'right' : right,
    'down': down,
    'left' : left,
    'f' : fullScreen,
    'F' : fullScreen,
    'alt+n': goToNew,
    'alt+N': goToNew,
    'alt+R': goToRecent,
    'alt+r': goToRecent,
    'alt+H': goToHistory,
    'alt+h': goToHistory,

});