$(document).ready(function () {
  console.log("ready!");

  function reply_click(clicked_id) {
    alert(clicked_id);
  }

  $("#foo").click(function () {
    var val = foo.value;

    $.ajax({
      type: "POST",
      url: "start.inc.php",
      success: function (data) {
        alert(data);
        $("p").text(data);
      },
    });
  });
});
