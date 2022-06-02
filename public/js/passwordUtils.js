$(document).ready(function () {

    // Avís de majúscules en inputs password

    let password = document.querySelector("input[name='password']");
    let passwordWarning = document.querySelector("#passwordWarning");
    passwordWarning.style.visibility = "hidden";

    password.addEventListener("keydown", function(ev){
        if (ev.shiftKey){
            passwordWarning.textContent = "Careful! Shift key pressed!";
            passwordWarning.style.visibility = "visible";
        }
    });

    password.addEventListener("keyup", function(ev){
        if (ev.getModifierState('CapsLock')){
            passwordWarning.textContent = "Careful! Caps Lock is enabled!";
            passwordWarning.style.visibility = "visible";
        } else {
            passwordWarning.style.visibility = "hidden";
        }
    });




    // Password visibility
    let passwordToggle = document.querySelector("#togglePassword");
    
    passwordToggle.addEventListener("click", function(ev){
        if (passwordToggle.checked){
            password.type = "text";
        } else {
            password.type = "password";
        }
    });











});