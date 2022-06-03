"use strict";

window.addEventListener("load", function () {
  var _this = this;

  setTimeout(function () {
    _this.document.getElementById("loader").classList.toggle("loader-hide");
  }, 1000);
  setTimeout(function () {
    _this.document.getElementById("loader").style.display = "none";
  }, 2000);
});