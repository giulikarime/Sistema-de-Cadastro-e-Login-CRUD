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
let messageP = document.querySelector("#messageP");

btnSend.addEventListener("click", async (event) => {
    event.preventDefault();
    resetLabels();

    let getNome = nome.value.trim();
    let getEmail = email.value.trim();
    let getSenha = senha.value.trim();
    let getSenhaConfirm = senhaConfirm.value.trim();

    let valid = true;
    valid = verifyName(getNome, valid);
    valid = verifyEmail(getEmail, valid);
    valid = verifySenha(getSenha, valid);
    valid = verifySenhaConfirm(getSenhaConfirm, valid);
    valid = matchSenhas(getSenha, getSenhaConfirm, valid);

    if (valid) {
        valid = await alreadyExistEmail(getEmail);
    }

    if (valid) {
        form.submit();
    }
});

function resetLabels() {
    nomeLabel.textContent = "Nome de Usuário";
    nomeLabel.style.color = "";
    emailLabel.textContent = "Email";
    emailLabel.style.color = "";
    senhaLabel.textContent = "Senha";
    senhaLabel.style.color = "";
    senhaConfirmLabel.textContent = "Confirme sua senha";
    senhaConfirmLabel.style.color = "";
    messageP.textContent = "";
}

function verifyName(getNome, valid) {
    if (getNome === "") {
        nomeLabel.textContent = "Insira um nome";
        nomeLabel.style.color = "red";
        return false;
    }
    return valid;
}

function verifyEmail(getEmail, valid) {
    if (getEmail === "") {
        emailLabel.textContent = "Insira um email";
        emailLabel.style.color = "red";
        return false;
    }
    return valid;
}

function verifySenha(getSenha, valid) {
    if (getSenha === "") {
        senhaLabel.textContent = "Insira uma senha";
        senhaLabel.style.color = "red";
        return false;
    }
    return valid;
}

function verifySenhaConfirm(getSenhaConfirm, valid) {
    if (getSenhaConfirm === "") {
        senhaConfirmLabel.textContent = "Confirme sua senha";
        senhaConfirmLabel.style.color = "red";
        return false;
    }
    return valid;
}

function matchSenhas(getSenha, getSenhaConfirm, valid) {
    if (getSenha !== getSenhaConfirm) {
        senhaLabel.textContent = "As senhas não batem";
        senhaConfirmLabel.textContent = "As senhas não batem";
        senhaLabel.style.color = "red";
        senhaConfirmLabel.style.color = "red";
        return false;
    }
    return valid;
}

async function alreadyExistEmail(getEmail) {
    try {
        const res = await fetch(`index.php?email=${encodeURIComponent(getEmail)}`);
        const data = await res.json();

        if (data.exists) {
            messageP.textContent = "Este email já está cadastrado.";
            messageP.style.color = "red";
            return false;
        }
        return true;
    } catch (err) {
        messageP.textContent = "Erro ao verificar email. Tente novamente.";
        messageP.style.color = "red";
        return false;
    }
}