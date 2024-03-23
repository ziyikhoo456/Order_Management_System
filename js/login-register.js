$(document).ready(function() {
    $("#togglePassword").on('click', function(event) {
        event.preventDefault();
        if($('#password').attr("type") == "text"){
            $('#password').attr('type', 'password');
            $('#togglePassword i').addClass( "fa-eye" );
            $('#togglePassword i').removeClass( "fa-eye-slash" );
        }else if($('#password').attr("type") == "password"){
            $('#password').attr('type', 'text');
            $('#togglePassword i').removeClass( "fa-eye" );
            $('#togglePassword i').addClass( "fa-eye-slash" );
        }
    });

    $("#registerBtn").on('click',function(event){
        console.log($("#phone").val());
        let newPhone = $("#phone").val().slice(0,-1);
        $("#phone").val(newPhone);
        console.log($("#phone").val());
    })

});

//mask phone
document.addEventListener('DOMContentLoaded', () => {
    for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
        const pattern = el.getAttribute("placeholder"),
            slots = new Set(el.dataset.slots || "_"),
            prev = (j => Array.from(pattern, (c,i) => slots.has(c)? j=i+1: j))(0),
            first = [...pattern].findIndex(c => slots.has(c)),
            accept = new RegExp(el.dataset.accept || "\\d", "g"),
            clean = input => {
                input = input.match(accept) || [];
                return Array.from(pattern, c =>
                    input[0] === c || slots.has(c) ? input.shift() || c : c
                );
            },
            format = () => {
                const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                    i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                    return i<0? prev[prev.length-1]: back? prev[i-1] || first: i;
                });
                el.value = clean(el.value).join``;
                el.setSelectionRange(i, j);
                back = false;
            };
        let back = false;
        el.addEventListener("keydown", (e) => back = e.key === "Backspace");
        el.addEventListener("input", format);
        el.addEventListener("focus", format);
        el.addEventListener("blur", () => el.value === pattern && (el.value=""));
    }
});