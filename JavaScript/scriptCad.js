let form = document.querySelector("#createAccount");
let nome = document.querySelector("#inputName");
let nomeLabel = document.querySelector("#labelNome");

let email = document.querySelector("#inputEmail");
let emailLabel = document.querySelector("#labelEmail");

let senha = document.querySelector("#inputPassword");
let senhaLabel = document.querySelector("#labelSenha");

let senhaConfirm = document.querySelector("#inputAuthPassword");
let senhaConfirmLabel = document.querySelector("#labelSenhaConfirm");

let btnSend = document.querySelector("#btnSend");

btnSend.addEventListener("click", (event) => {
    event.preventDefault();
    let valid = true;

    let getNome = nome.value.trim();
    let getEmail = email.value.trim();
    let getSenha = senha.value.trim();
    let getSenhaConfirm = senhaConfirm.value.trim();

    valid = verifyName(getNome,valid);
    valid = verifyEmail(getEmail,valid);
    valid = verifySenha(getSenha,valid);
    valid = verifySenhaConfirm(getSenhaConfirm,valid);
    valid = matchSenhas(getSenha, getSenhaConfirm,valid);

    if(valid){
        form.submit();
    }
});

function verifyName(getNome,valid){
    if(getNome === ""){
        nomeLabel.textContent = "Insira um nome";
        nomeLabel.style.color = "red";
        valid = false;
    }
    return valid;
}

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

function verifySenhaConfirm(getSenhaConfirm,valid){
    if(getSenhaConfirm === ""){
        senhaConfirmLabel.textContent = "Confirme sua senha";
        senhaConfirmLabel.style.color = "red";
        valid = false;
    }
    return valid;
}

function matchSenhas(getSenha, getSenhaConfirm,valid){
    if(getSenha !== getSenhaConfirm){
        senhaLabel.textContent = "As senhas não batem";
        senhaConfirmLabel.textContent = "As senhas não batem";
        senhaLabel.style.color = "red";
        senhaConfirmLabel.style.color = "red";
        valid = false;
    }
    return valid;
}