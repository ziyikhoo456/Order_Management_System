$(document).ready(function() {
    $("#loginIconPassword").on('click', function(event) {
        event.preventDefault();
        if($('#loginPassword').attr("type") == "text"){
            $('#loginPassword').attr('type', 'password');
            $('#loginIconPassword i').addClass( "fa-eye" );
            $('#loginIconPassword i').removeClass( "fa-eye-slash" );
        }else if($('#loginPassword').attr("type") == "password"){
            $('#loginPassword').attr('type', 'text');
            $('#loginIconPassword i').removeClass( "fa-eye" );
            $('#loginIconPassword i').addClass( "fa-eye-slash" );
        }
    });

    $("#registerIconPassword").on('click', function(event) {
        event.preventDefault();
        if($('#registerPassword').attr("type") == "text"){
            $('#registerPassword').attr('type', 'password');
            $('#registerIconPassword i').addClass( "fa-eye" );
            $('#registerIconPassword i').removeClass( "fa-eye-slash" );
        }else if($('#registerPassword').attr("type") == "password"){
            $('#registerPassword').attr('type', 'text');
            $('#registerIconPassword i').removeClass( "fa-eye" );
            $('#registerIconPassword i').addClass( "fa-eye-slash" );
        }
    });

    //remove last character which is '_' for value of phone input if the phone digit is 7 digits long
    $("#registerBtn").on('click',function(event){
        if(($("#phone").val().slice(-1) == '_'))
        {
            let newPhone = $("#phone").val().slice(0,-1);
            $("#phone").val(newPhone);
        }
    })

});

//mask phone input for register
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