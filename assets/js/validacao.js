document.addEventListener("DOMContentLoaded", function () {
    // Validação do formulário de Clientes
    const clienteForm = document.getElementById("clienteForm");
    if (clienteForm) {
        clienteForm.addEventListener("submit", function (event) {
            const nome = document.getElementById("nome");
            if (nome.value.trim() === "") {
                nome.classList.add("is-invalid");
                event.preventDefault(); // Impede o envio
            } else {
                nome.classList.remove("is-invalid");
            }
        });
    }

    // Validação do formulário de Notinhas
    const notinhaForm = document.getElementById("notinhaForm");
    if (notinhaForm) {
        notinhaForm.addEventListener("submit", function (event) {
            let isValid = true;

            // Valida Descrição
            const descricao = document.getElementById("descricao");
            if (descricao.value.trim() === "") {
                descricao.classList.add("is-invalid");
                isValid = false;
            } else {
                descricao.classList.remove("is-invalid");
            }

            // Valida Valor
            const valor = document.getElementById("valor");
            if (valor.value <= 0 || valor.value === "") {
                valor.classList.add("is-invalid");
                isValid = false;
            } else {
                valor.classList.remove("is-invalid");
            }

            // Valida Status
            const status = document.getElementById("status");
            if (status.value === "") {
                status.classList.add("is-invalid");
                isValid = false;
            } else {
                status.classList.remove("is-invalid");
            }

            if (!isValid) {
                event.preventDefault(); // Impede o envio
            }
        });
    }
});
