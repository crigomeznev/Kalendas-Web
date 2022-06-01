"use strict";

$(document).ready(function () {
  // Set selected category on html select
  var curcategory = $("input[name='_category_id']").val();
  $("#category_id").val(curcategory); // Clear select

  $("#clear").click(function (ev) {
    $("#category_id").val(null);
  });
  console.log($("#clear"));
});