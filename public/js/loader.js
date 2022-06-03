window.addEventListener("load", function(){
    setTimeout(() => {
        this.document.getElementById("loader").classList.toggle("loader-hide");
    }, 1000);
    setTimeout(() => {
        this.document.getElementById("loader").style.display = "none";
    }, 2000);
});
