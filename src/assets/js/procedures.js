$(document).ready(function () {
  $(".btn-excluir-tarefa").click(function (e) {
    e.preventDefault();

    var id_tarefa = $(this).data("id");

    Swal.fire({
      title: "Deseja Realmente Excluir esta Tarefa?",
      showClass: {
        popup: "animate__animated animate__zoomIn",
      },
      hideClass: {
        popup: "animate__animated animate__zoomOut",
      },
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim!",
      cancelButtonText: "Não!",
    }).then((result) => {
      if (result.isConfirmed) {
        var currentPageUrl = window.location.href;
        var url = "";

        if (currentPageUrl == "http://localhost/todolist/index.php") {
          url = `src/php/backend/proc_excluir_tarefa.php?id_tarefa=${id_tarefa}`;
        } else {
          url = `../../src/php/backend/proc_excluir_tarefa.php?id_tarefa=${id_tarefa}`;
        }

        $.ajax({
          url: url,
          type: "GET",
          dataType: "json",
          success: function (response) {
            if (response.status === "success") {
              Swal.fire("SUCESSO!", response.message, "success").then(() => {
                location.reload();
              });
            } else {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            }
          },
          error: function (err) {
            Swal.fire(
              "ERRO!",
              "Ocorreu um erro ao excluir esta tarefa.",
              "error"
            );

            console.log("Status do erro:", err.status);
            console.log("Mensagem de erro:", err.statusText);
            console.log("Resposta do servidor:", err.responseText);
          },
        });
      }
    });
  });

  $(".btn-cadastro").click(function (e) {
    e.preventDefault();

    var formData = $(".form-login").serialize();

    Swal.fire({
      title: "Suas informações estão corretas?",
      showClass: {
        popup: "animate__animated animate__zoomIn",
      },
      hideClass: {
        popup: "animate__animated animate__zoomOut",
      },
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim!",
      cancelButtonText: "Não!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `../../src/php/backend/proc_cadastro.php`,
          type: "POST",
          data: formData,
          dataType: "json",
          success: function (response) {
            if (response.status == "empty_fields") {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            } else if (response.status == "find_user") {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            } else if (response.status === "success") {
              Swal.fire("SUCESSO!", response.message, "success").then(() => {
                return (window.location.href = "../../index.php");
              });
            } else {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            }
          },
          error: function (err) {
            Swal.fire(
              "ERRO!",
              "Ocorreu um erro ao se cadastrar no sistema.",
              "error"
            );

            console.log("Status do erro:", err.status);
            console.log("Mensagem de erro:", err.statusText);
            console.log("Resposta do servidor:", err.responseText);
          },
        });
      }
    });
  });

  $(".btn-login").click(function (e) {
    e.preventDefault();

    var formData = $(".form-login").serialize();

    Swal.fire({
      title: "Suas informações estão corretas?",
      showClass: {
        popup: "animate__animated animate__zoomIn",
      },
      hideClass: {
        popup: "animate__animated animate__zoomOut",
      },
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim!",
      cancelButtonText: "Não!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `../../src/php/backend/proc_login.php`,
          type: "POST",
          data: formData,
          dataType: "json",
          success: function (response) {
            if (response.status == "empty_fields") {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            } else if (response.status == "error_login") {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            } else if (response.status === "success") {
              Swal.fire("SUCESSO!", response.message, "success").then(() => {
                return (window.location.href = "../../index.php");
              });
            } else {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            }
          },
          error: function (err) {
            Swal.fire("ERRO!", "Ocorreu um erro ao logar no sistema.", "error");

            console.log("Status do erro:", err.status);
            console.log("Mensagem de erro:", err.statusText);
            console.log("Resposta do servidor:", err.responseText);
          },
        });
      }
    });
  });

  $(".btn-adicionar-tarefa").click(function (e) {
    e.preventDefault();

    var formData = $(".form-tarefa").serialize();

    Swal.fire({
      title: "Confirmar Nova Tarefa?",
      showClass: {
        popup: "animate__animated animate__zoomIn",
      },
      hideClass: {
        popup: "animate__animated animate__zoomOut",
      },
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim!",
      cancelButtonText: "Não!",
    }).then((result) => {
      if (result.isConfirmed) {
        var currentPageUrl = window.location.href;
        var url = "";
        var urlSuccess = "";

        if (currentPageUrl == "http://localhost/todolist/index.php") {
          url = `src/php/backend/proc_nova_tarefa.php`;
          urlSuccess = "index.php";
        } else {
          url = `../../src/php/backend/proc_nova_tarefa.php`;
          urlSuccess = "../../index.php";
        }

        $.ajax({
          url: url,
          type: "POST",
          data: formData,
          dataType: "json",
          success: function (response) {
            if (response.status == "empty_fields") {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            } else if (response.status === "success") {
              Swal.fire("SUCESSO!", response.message, "success").then(() => {
                return (window.location.href = urlSuccess);
              });
            } else {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            }
          },
          error: function (err) {
            Swal.fire(
              "ERRO!",
              "Ocorreu um erro ao criar uma nova tarefa.",
              "error"
            );

            console.log("Status do erro:", err.status);
            console.log("Mensagem de erro:", err.statusText);
            console.log("Resposta do servidor:", err.responseText);
          },
        });
      }
    });
  });

  $(".btn-editar-tarefa").click(function (e) {
    e.preventDefault();

    var idTarefa = $(this).data("id");
    var formEditar = $("#form-editar-" + idTarefa);
    var formData = formEditar.serialize();

    Swal.fire({
      title: "Confirmar Edição de Tarefa?",
      showClass: {
        popup: "animate__animated animate__zoomIn",
      },
      hideClass: {
        popup: "animate__animated animate__zoomOut",
      },
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sim!",
      cancelButtonText: "Não!",
    }).then((result) => {
      if (result.isConfirmed) {
        var currentPageUrl = window.location.href;
        var url = "";
        var urlSuccess = "";

        if (
          currentPageUrl == "http://localhost/todolist/index.php" ||
          currentPageUrl == "http://localhost/todolist/"
        ) {
          url = `src/php/backend/proc_editar_tarefa.php`;
          urlSuccess = "index.php";
        } else {
          url = `../../src/php/backend/proc_editar_tarefa.php`;
          urlSuccess = "../../index.php";
        }

        $.ajax({
          url: url,
          type: "POST",
          data: formData,
          dataType: "json",
          success: function (response) {
            if (response.status == "empty_fields") {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            } else if (response.status === "success") {
              Swal.fire("SUCESSO!", response.message, "success").then(() => {
                return (window.location.href = urlSuccess);
              });
            } else {
              Swal.fire("ERRO!", response.message, "error").then(() => {
                location.reload();
              });
            }
          },
          error: function (err) {
            Swal.fire(
              "ERRO!",
              "Ocorreu um erro ao editar uma tarefa.",
              "error"
            );

            console.log("Status do erro:", err.status);
            console.log("Mensagem de erro:", err.statusText);
            console.log("Resposta do servidor:", err.responseText);
          },
        });
      }
    });
  });
});
