$(document).ready(function() {
  // Parallax scrolling
  $('section[data-type="background"]').each(function() {
      var $bgobj = $(this); 
      $(window).scroll(function() {
          var yPos = -($(window).scrollTop() / $bgobj.data('speed'));
          var coords = '100% ' + yPos + 'px';
       
          $bgobj.css({ backgroundPosition: coords });
      });
  });

}); 

