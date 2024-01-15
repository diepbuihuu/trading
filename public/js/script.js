(function ($) {
  'use strict';

  // Preloader
  $(window).on('load', function () {
    $('#preloader').fadeOut('slow', function () {
      $(this).remove();
    });
  });

$(document).on('click','#productId',()=>{
  // let id = $(this).data('pid');
  let id = $(this).val();
  // console.log($(this));
  alert(id);
});
 

})(jQuery);
