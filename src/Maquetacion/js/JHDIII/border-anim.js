$(document).ready(function () {
  $.ajax({
    url: '/Formularios/plantilla/mesag.php',
    type: 'post',
    success: function (output) {
      if (output == '0') {
        $(".box").show();
      } else {
        $(".box").hide();
      }
    }
  });
  $("#iters").click(function () {
    $(".box").hide();
  });
});
