 let btnToTop = $('#button');
 $(window).scroll(function () {
     if ($(window).scrollTop() > 250) {
         btnToTop.addClass('show');
     } else {
         btnToTop.removeClass('show');
     }
 });

 btnToTop.on('click', function (e) {
     e.preventDefault();
     $('html, body').animate({
         scrollTop: 0
     }, '300');
 });