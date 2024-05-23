$(document).ready(function () {
  // edit user form
  $("#editUserForm").submit(function (e) {
    e.preventDefault();
    var full_name = $("#editUserModal #full_name").val();
    var email = $("#editUserModal #email").val();
    var user_type = $("#editUserModal #userType").val();
    var id = $("#editUserModal #user_id").val();

    $.post(
      "/grade-change/users/update",
      {
        full_name: full_name,
        email: email,
        user_type: user_type,
        id: id,
      },
      function (data) {
        if (data === "success") {
          // $('#editUserModal').modal('hide');
          window.location.reload();
        } else {
          // $('#editUserModal').modal('hide');
          $(".alert").fadeIn();
          $(".error").html(data);
          $(".alert").fadeOut(2000);
        }
      }
    );
  });

  //fetch department details for editing
  $(".edit-department").click(function (e) {
    e.preventDefault();

    var departmentId = $(this).closest("tr").data("id");
    $.ajax({
      url: "/grade-change/department/show",
      method: "GET",
      data: { id: departmentId },
      success: function (response) {
        let res = JSON.parse(response);
        let department = res["department"][0];
        let departmentHead = res["head"][0];
        console.log(res);
        console.log(department);
        console.log(departmentHead);
        $("#editDepartmentModal #departmentName").val(department.name);
        if (departmentHead) {
          $("#editDepartmentModal #departmentHead").val(departmentHead.id);
        }

        // Show the modal
        $("#editDepartmentModal").modal("show");
      },
      error: function (xhr, status, error) {
        console.error(error);
        // Handle error
      },
    });
  });
});
