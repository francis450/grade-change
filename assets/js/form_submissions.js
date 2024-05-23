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
          window.location.href = "/grade-change/dashboard/";
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

  // handle submitting the course create form
  $("#create-course-form").submit(function (event) {
    event.preventDefault();

    var courseName = $("#courseName").val();
    var courseCode = $("#courseCode").val();
    var departmentId = $("#departmentId").val();
    $.post(
      "/grade-change/courses/store",
      {
        course_name: courseName,
        course_code: courseCode,
        department_id: departmentId,
      },
      function (data) {
        if (data === "success") {
          $(".alert").show();
          $(".success").fadeIn();
          $(".success").html("Course created successfully");
          $(".success").fadeOut(2000);
          // reload
          window.location.reload();
        } else {
          $(".alert").fadeIn();
          $(".error").html(data);
          $(".alert").fadeOut(2000);
        }
      }
    );
  });

  // handle submit student form
  $("#addStudentForm").submit(function (event) {
    event.preventDefault();

    console.log("submitted");

    var studentUserId = $("#studentName").val();
    var departmentId = $("#department").val();
    $.post(
      "/grade-change/students/store",
      {
        user_id: studentUserId,
        department_id: departmentId,
      },
      function (data) {
        if (data === "success") {
          $(".alert").show();
          $(".success").fadeIn();
          $(".success").html("Student created successfully");
          $(".success").fadeOut(2000);
          // reload
          window.location.reload();
        } else {
          $(".alert").show();
          $(".alert").fadeIn();
          $(".error").html(data);
          $(".alert").fadeOut(2000);
        }
      }
    );
  });

  // handle submit grade form
  $("#addGradeForm").submit(function (event) {
    event.preventDefault();

    var studentId = $("#studentId").val();
    var courseId = $("#courseId").val();
    var grade = $("#grade").val();
    var points = $("#points").val();
    $.post(
      "/grade-change/grades/store",
      {
        student_id: studentId,
        course_id: courseId,
        grade: grade,
        points: points,
      },
      function (data) {
        if (data === "success") {
          $(".alert").show();
          $(".success").fadeIn();
          $(".success").html("Grade added successfully");
          $(".success").fadeOut(2000);
          // reload
          window.location.reload();
        } else {
          $(".alert").show();
          $(".alert").fadeIn();
          $(".error").html(data);
          $(".alert").fadeOut(2000);
        }
      }
    );
  });

  // method="post" action="/grade-change/grade-change-requests/store"
  $("#addGradeChangeRequestForm").submit(function (event) {
    event.preventDefault();

    var courseId = $("#course_id").val();
    var grade = $("#grade").val();
    var points = $("#points").val();
    var reason = $("#reason").val();
    var attachment = $("#attachment")[0];
    var formData = new FormData();

    if (attachment.files.length > 0) {
      // Access the first file selected (files[0])
      var file = attachment.files[0];

      // Log file information
      console.log("File name:", file.name);
      console.log("File size:", file.size, "bytes");
      console.log("File type:", file.type);

      // Add the file to the form data
      formData.append("attachment", file);
    }

    // Append other form data
    formData.append("course_id", courseId);
    formData.append("points", points);
    formData.append("grade", grade);
    formData.append("reason", reason);

    console.log("Form data", formData);

    $.ajax({
      url: "/grade-change/grade-change-requests/store",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        if (data === "success") {
          $(".alert").show();
          $(".success").fadeIn();
          $(".success").html("Grade change request added successfully");
          $(".success").fadeOut(2000);
          window.location.reload();
        } else {
          $(".alert").show();
          $(".alert").fadeIn();
          $(".error").html(data);
          $(".alert").fadeOut(2000);
        }
      },
      error: function (jqXHR, error) {
        console.error("Error submitting form: ", error);
        $(".alert").show();
        $(".alert").fadeIn();
        $(".error").html(
          "An error occurred while submitting the form. Please try again."
        );
        $(".alert").fadeOut(2000);
      },
    });
  });

  // post edit user form
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
});
