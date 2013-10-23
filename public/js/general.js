$(document).ready(function() {
    $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
});

  $('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});