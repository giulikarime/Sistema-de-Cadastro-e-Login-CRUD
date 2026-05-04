let form = document.querySelector("#createAccount");

let email = document.querySelector("#inputEmail");
let emailLabel = document.querySelector("#labelEmail");

let senha = document.querySelector("#inputPassword");
let senhaLabel = document.querySelector("#labelSenha");

let btnSend = document.querySelector("#btnSend");


btnSend.addEventListener("click", (event) => {
    event.preventDefault();
    let valid = true;

    let getEmail = email.value.trim();
    let getSenha = senha.value.trim();

    valid = verifyEmail(getEmail,valid);
    valid = verifySenha(getSenha,valid);

    if(valid){
        form.submit();
    }
});

function verifyEmail(getEmail,valid){
    if(getEmail === ""){
        emailLabel.textContent = "Insira um email";
        emailLabel.style.color = "red";
        valid = false;
    }
    return valid;
}

function verifySenha(getSenha,valid){
    if(getSenha === ""){
        senhaLabel.textContent = "Insira uma senha";
        senhaLabel.style.color = "red";
        valid = false;
    }
    return valid;
}
