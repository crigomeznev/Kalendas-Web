$(document).ready(function () {

    // Avís de majúscules en inputs password

    // Set selected category on html select
    let passwords = document.querySelector("input[type='password']");
    passwords.addEventListener("keyup", function(ev){
        if (ev.getModifierState('CapsLock')){
            alert("Caps lock is on");
        } else {

        }
    })
});