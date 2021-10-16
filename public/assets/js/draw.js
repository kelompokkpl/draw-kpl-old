$(document).ready(function() {
    // Select item
    var scrollW = document.getElementById('wrap-scroll');
    var scrollUl = document.getElementById('ul-scroll');
    var itemsScrolled, itemsMax, cloned = false;
    var listOpts = {
        itemCount: null,
        itemHeight: null,
        items: []
    };

    function initItems(scrollSmooth) {
        listOpts.items = [].slice.call(scrollUl.querySelectorAll('li'));
        listOpts.itemHeight = listOpts.items[0].clientHeight;
        listOpts.itemCount = listOpts.items.length;
        if (!itemsMax) {
            itemsMax = listOpts.itemCount;
        }
        if (scrollSmooth) {
            var seamLessScrollPoint = (itemsMax - 3) * listOpts.itemHeight;
            scrollW.scrollTop = seamLessScrollPoint;
        }
    }

    initItems();

    $('.wrap-container').scroll(function(){
        itemsScrolled = Math.ceil($(this).scrollTop() / listOpts.itemHeight);
        if ($(this).scrollTop() < 1) {
            itemsScrolled = 0;
        }
        listOpts.items.forEach(function (ele) {
            ele.classList.remove('selected');
            ele.classList.remove('semi');
        });
        if (itemsScrolled < listOpts.items.length) {
            listOpts.items[itemsScrolled].classList.add('selected');
            listOpts.items[(itemsScrolled+1)].classList.add('semi');
            listOpts.items[(itemsScrolled-1)].classList.add('semi');
        }
        if (itemsScrolled > listOpts.items.length - 3) {
            for (_x = 0; _x <= itemsMax - 1; _x++) {
                if (window.CP.shouldStopExecution(1)) {
                    break;
                }
                var node = listOpts.items[_x];
                if (!cloned) {
                    node = listOpts.items[_x].cloneNode(true);
                }
                scrollUl.appendChild(node);
            }
            initItems(cloned);
            cloned = true;
            itemsScrolled = 0;
            window.CP.exitedLoop(1);
        }
    })
});


// Sidebar
$(function() {

  // 'use strict';

  $('.js-menu-toggle').click(function(e) {

    var $this = $(this);

    if ( $('body').hasClass('show-sidebar') ) {
      $('body').removeClass('show-sidebar');
      $this.removeClass('active');
    } else {
      $('body').addClass('show-sidebar'); 
      $this.addClass('active');
    }

    // e.preventDefault();

  });

  // click outisde offcanvas
  $(document).mouseup(function(e) {
    var container = $(".sidebar");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      if ( $('body').hasClass('show-sidebar') ) {
        $('body').removeClass('show-sidebar');
        $('body').find('.js-menu-toggle').removeClass('active');
      }
    }
  }); 

});
