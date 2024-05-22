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

  // handle logout
  $(".logout").click(function () {
    $.get("/grade-change/logout", function (data) {
      if (data === "success") {
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

  // function to handle submitting the course create form
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

  $('#points').on('change', function() {
    var points = $(this).val();
    var grade = '';
    if (points >= 80) {
      grade = 'A';
    } else if (points >= 70) {
      grade = 'B';
    } else if (points >= 60) {
      grade = 'C';
    } else if (points >= 60) {
      grade = 'D';
    } else if (points >= 50) {
      grade = 'E';
    } else {
      grade = 'F';
    }
    $('#grade').val(grade);
  });

  // handle submit grade form
  $("#addGradeForm").submit(function (event) {
    event.preventDefault();

    var studentId = $("#studentId").val();
    var courseId = $("#courseId").val();
    var grade = $("#grade").val();
    var points  = $("#points").val();
    $.post(
      "/grade-change/grades/store",
      {
        student_id: studentId,
        course_id: courseId,
        grade: grade,
        points: points
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
  
  // get students who belong to the same department as the selected course
  $("#courseId").on("change", function () {
    var courseId = $(this).val();
    $.get("/grade-change/students/course", { course_id: courseId }, function (data) {
      var students = JSON.parse(data);
      var options = "<option value=''>Select Student</option>";
      students.forEach((student) => {
        options += `<option value="${student.id}">${student.student_number} - ${student.full_name}</option>`;
      });
      $("#studentId").html(options);
    });
  });

  // handle any delete button
  $(".delete").click(function (e) {
    e.preventDefault();
    var id = $(this).closest("tr").data("id");
    var url = $(this).data("url");
    var data = { id: id };
    $.ajax({
      url: url,
      method: "DELETE",
      data: data,
      success: function (response) {
        console.log(response);
        window.location.reload();
      },
      error: function (xhr, status, error) {
        console.error(error);
        // Handle error
      },
    });
  });
});
