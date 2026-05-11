let form = document.querySelector("#createAccount");

let email = document.querySelector("#inputEmail");
let emailLabel = document.querySelector("#labelEmail");

let senha = document.querySelector("#inputPassword");
let senhaLabel = document.querySelector("#labelSenha");

let btnSend = document.querySelector("#btnSend");
let messageP = document.querySelector("#messageP");

btnSend.addEventListener("click", async (event) => {
    event.preventDefault();

    resetLabels();

    let getEmail = email.value.trim();
    let getSenha = senha.value.trim();

    let valid = true;
    valid = verifyEmail(getEmail, valid);
    valid = verifySenha(getSenha, valid);

    if (!valid) return;

    try {
        const formData = new FormData(form);
        const res = await fetch("logIn.php", {
            method: "POST",
            body: formData
        });

        const data = await res.json();

        if (data.success) {
            window.location.href = "startSession.php";
        } else {
            messageP.textContent = data.message;
            messageP.style.color = "red";
        }

    } catch (err) {
        messageP.textContent = "Erro ao conectar. Tente novamente.";
        messageP.style.color = "red";
    }
});

function resetLabels(){
    emailLabel.textContent = "Email";
    emailLabel.style.color = "";
    senhaLabel.textContent = "Senha";
    senhaLabel.style.color = "";
    if (messageP) messageP.textContent = "";
}

function verifyEmail(getEmail, valid){
    if(getEmail === ""){
        emailLabel.textContent = "Insira um email";
        emailLabel.style.color = "red";
        return false;
    }
    return valid;
}

function verifySenha(getSenha, valid){
    if(getSenha === ""){
        senhaLabel.textContent = "Insira uma senha";
            senhaLabel.style.color = "red";
        return false;
    }
    return valid;
}