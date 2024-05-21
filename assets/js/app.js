$(document).ready(function () {
  // handle login form submit
  $(".login-form").submit(function (event) {
    event.preventDefault();

    var email = $("#email").val();
    var password = $("#password").val();

    $.post(
      "/grade-change/login",
      {
        email: email,
        password: password,
      },
      function (data) {
        if (data === "success") {
          window.location.href = "/grade-change/dashboard#";
        } else {
          $(".alert").fadeIn();
          $(".error").html(data);
          $(".alert").fadeOut(2000);
        }
      }
    );
  });

  // handle register form submit
  $(".register-form").submit(function (event) {
    event.preventDefault();

    var fullname = $("#fullname").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var confirmPassword = $("#confirm-password").val();
    // var user_type = $("input[name=user_type]:checked").val();

    if (password !== confirmPassword) {
      $(".alert").fadeIn();
      $(".error").html("Password do not match");
      $(".alert").fadeOut(2000);
      return;
    }

    $.post(
      "register",
      {
        fullname: fullname,
        email: email,
        password: password,
        // user_type: user_type,
      },
      function (data) {
        if (data === "success") {
          window.location.href = "/grade-change/";
        } else {
          // $(".alert").fadeIn();
          // $(".error").html(data);
          // $(".alert").fadeOut(2000);
        }
      }
    );
  });

  // handle logout
  $(".logout").click(function () {
    $.get("/grade-change/logout", function (data) {
      console.log(Request);
      if (data.success === "success") {
        window.location.reload();
      }
    });
  });

  // handle department form submit
  $(".department-form").submit(function (event) {
    event.preventDefault();

    var department = $("#departmentName").val();
    var department_head_id = $("#departmentHead").val();
    $.post(
      "/grade-change/departments/store",
      {
        department_name: department,
        department_head_id: department_head_id,
      },
      function (data) {
        if (data === "success") {
          $(".alert").show();
          $(".success").fadeIn();
          $(".success").html("Department created successfully");
          $(".success").fadeOut(2000);
          // reload
          setTimeout(() => {
            window.location.reload();
          }, 2000);
        } else {
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

  // handle new user form submit
  $("#addUserForm").submit(function (event) {
    event.preventDefault();

    var fullname = $("#full_name").val();
    var email = $("#email").val();
    var user_type = $("#userType").val();


    $.post(
      "/grade-change/users/store",
      {
        full_name: fullname,
        email: email,
        type: user_type,
      },
      function (data) {
        if (data === "success") {
          $(".alert").show();
          $(".success").fadeIn();
          $(".success").html("User created successfully");
          $(".success").fadeOut(2000);
          // reload
   
        } else {
          $(".alert").fadeIn();
          $(".error").html(data);
          $(".alert").fadeOut(2000);
        }
      }
    );
  });
});
