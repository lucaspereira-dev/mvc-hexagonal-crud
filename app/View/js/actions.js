function listUsers() {
  $.ajax({
    url: "/users",
    method: "GET",
    success: function (data) {
      $("#userList").empty();
      data.forEach(function (user) {
        $("#userList").append(`
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                            <td>${user.email}</td>
                            <td>${user.password}</td>
                            <td>${user.birthday}</td>
                            <td>
                              <div style="display: flex; justify-content: flex-start; align-items: center; gap: 5px;">
                                <button class="btn btn-info" title="Editar" data-bs-toggle="modal" data-bs-target="#userModal" onclick="getUser('${user.id}')">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                  </svg>
                                </button>
                                <button class="btn btn-danger" title="Excluir" onclick="deleteUser('${user.id}')">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                  </svg>
                                </button>
                              </div>
                            </td>
                        </tr>
                    `);
      });
    },
    error: function ({ responseJSON }, status, error) {
      handleDisplayErrors(responseJSON)
    },
  });
}

async function getUser(id) {
  $.ajax({
    url: "/users/" + id,
    method: "GET",
    success: function (user) {
      $("#userId").val(user.id);
      $("#name").val(user.name);
      $("#email").val(user.email);
      $("#password").val(user.password);
      $("#birthday").val(user.birthday);
    },
    error: function ({ responseJSON }, status, error) {
      $("#userModal").modal("hide");
      handleDisplayErrors(responseJSON)
    },
  });
}

async function createUser(formData) {
  await $.ajax({
    url: "/users",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify(formData),
    success: function (data) {
      $("#userModal").modal("hide");
      listUsers();
      if (Object.hasOwn(data, "message")) {
        notification(data.message);
      }
    },
    error: function ({ responseJSON }, status, error) {
      handleDisplayErrors(responseJSON)
    },
  });
}

async function updateUser(userId, formData) {
  await $.ajax({
    url: "/users/" + userId,
    method: "PUT",
    contentType: "application/json",
    data: JSON.stringify(formData),
    success: function (data) {
      $("#userModal").modal("hide");
      listUsers();
      if (Object.hasOwn(data, "message")) {
        notification(data.message);
      }
    },
    error: function ({ responseJSON }, status, error) {
      handleDisplayErrors(responseJSON)
    },
  });
}

async function deleteUser(id) {
  $("#confirmDeleteModal").modal("show");
  $("#confirmDelete").on("click", async function () {
    await $.ajax({
      url: "/users/" + id,
      method: "DELETE",
      success: function (data) {
        listUsers();
        if (Object.hasOwn(data, "message")) {
          notification(data.message);
        }
      },
      error: function ({ responseJSON }, status, error) {
        handleDisplayErrors(responseJSON)
      },
      complete: function () {
        $("#confirmDeleteModal").modal("hide");
      },
    });
  });
}
// ------------------------------------------------------------------------------------------------
function notification(message, type = "success", duration = 3000) {
  const style = {
    timeOut: duration,
    positionClass: "toast-bottom-right",
  };
  if (type == "success") {
    toastr.success(message, style);
  } else if (type == "info") {
    toastr.info(message, style);
  } else if (type == "warning") {
    toastr.warning(message, style);
  } else if (type == "error") {
    toastr.error(message, style);
  }
}

function handleDisplayErrors(response) {
  if (Object.hasOwn(response, "message")) {
    notification(response.message, "error");
  }
  if (Object.hasOwn(response, "errors") && response.errors) {
    for (const key in response.errors) {
      displayErrorInput(key, response.errors[key]);
    }
  }
}

function displayErrorInput(input, message) {
  $(`#${input}Error`).text(`* ${message}`);
  setTimeout(function () {
    $(`#${input}Error`).text("");
  }, 9000);
}

function serializeFormToJson(form) {
  const formData = {};
  $(form)
    .serializeArray()
    .forEach((field) => {
      formData[field.name] = field.value;
    });
  return formData;
}

function cleanInputs() {
  $("#userId").val("");
  $("#name").val("");
  $("#email").val("");
  $("#password").val("");
  $("#birthday").val("");
}

// -----------------------------------------------------------

// Carregamento da pagina e evento para modal
window.addEventListener("load", function () {
  listUsers();
  $("#userForm").submit(function (e) {
    e.preventDefault();
    const userId = $("#userId").val();
    const formData = serializeFormToJson(this);
    userId ? updateUser(userId, formData) : createUser(formData);
  });
});
