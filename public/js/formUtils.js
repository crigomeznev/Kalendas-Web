$(document).ready(function () {

    // Avís de majúscules en inputs password
    $("input[type='text'], input[type='email'], input[type='date'], input[type='datetime-local'], input[type='number'], input[type='password'], textarea").focus(focused);
    $("input[type='text'], input[type='email'], input[type='date'], input[type='datetime-local'], input[type='number'], input[type='password'],textarea").blur(unfocused);
    // $("textarea").addEventListener("focus", focused);

    function focused(ev){
        let source = ev.target;

        source.style.backgroundColor = "antiqueWhite";
        source.style.fontWeight = "bold";
    }

    function unfocused(ev){
        let source = ev.target;

        source.style.backgroundColor = "white";
        source.style.fontWeight = "normal";
    }
});