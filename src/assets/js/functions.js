window.addEventListener("load", function () {
  exibirLoginAlert();

  function exibirLoginAlert() {
    Swal.fire({
      title: "Entrar",
      showClass: {
        popup: "animate__animated animate__fadeInDown",
      },
      hideClass: {
        popup: "animate__animated animate__fadeOutUp",
      },
      icon: "info",
      html:
        '<form id="formLogin">' +
        '<div class="mb-3">' +
        '<label for="senha_login_arquivadas" class="form-label">Senha <span style="color: red; font-weight: bold;">*</span></label>' +
        '<input type="password" class="form-control" id="senha_login_arquivadas" name="senha_login_arquivadas" placeholder="Digite sua senha" required>' +
        "</div>" +
        "</form>",
      allowOutsideClick: false,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Entrar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      var senha_login = $("#senha_login_arquivadas").val();

      var loginFormData = new FormData();
      loginFormData.append("senha_login_arquivadas", senha_login);

      if (result.isConfirmed) {
        $.ajax({
          url: "../php/backend/proc_login_arquivadas.php",
          type: "POST",
          data: loginFormData,
          dataType: "json",
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.status === "success") {
              Swal.fire("SUCESSO!", response.message, "success").then(() => {
                return (window.location.href = "arquivadas.php");
              });
            } else {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                return exibirLoginAlert();
              });
            }
          },
          error: function (err) {
            Swal.fire(
              "ERRO!",
              "Ocorreu um erro ao entrar nas Tarefas Arquivadas.",
              "error"
            );

            console.log("Status do erro:", err.status);
            console.log("Mensagem de erro:", err.statusText);
            console.log("Resposta do servidor:", err.responseText);
          },
        });
      } else {
        return Swal.close();
      }
    });
  }
});
