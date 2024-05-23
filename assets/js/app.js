$(document).ready(function () {
  // handle logout
  $(".logout").click(function () {
    $.get("/grade-change/logout", function (data) {
      if (data === "success") {
        window.location.reload();
      }
    });
  });

  // update grade based on points
  $("#points").on("change", function () {
    var points = $(this).val();
    var grade = "";
    if (points > 100) {
      // remove d-none from the .alert
      $(".alert").removeClass("d-none");
      $(".alert").fadeIn();
      $(".error").html("Invalid points");
      setTimeout(() => {
        $("#points").val("");
        $(".alert").addClass("d-none");
      }, 5000);
      return;
    } else if (points >= 75) {
      grade = "A";
    } else if (points >= 65) {
      grade = "B";
    } else if (points >= 55) {
      grade = "C";
    } else if (points >= 45) {
      grade = "D";
    } else if (points >= 39) {
      grade = "E";
    } else if (points < 39) {
      grade = "F";
    }

    $("#grade").val(grade);
  });

  // get courses for the selected department
  $("#departmentId").on("change", function () {
    var departmentId = $(this).val();
    $.get(
      "/grade-change/courses/department",
      { department_id: departmentId },
      function (data) {
        var data = JSON.parse(data);
        console.log("Courses: ", data.courses, "Students: ", data.students);

        $("#courseId").html("<option value=''>Select Course</option>");
        $("#studentId").html("<option value=''>Select Student</option>");

        var courses = data.courses;
        var students = data.students;
        var courseOptions = "<option value=''>Select Course</option>";

        courses.forEach((course) => {
          courseOptions += `<option value="${course.course_id}">${course.course_code} - ${course.course_name}</option>`;
          $("#courseId").html(courseOptions);
        });

        var studentOptions = "<option value=''>Select Student</option>";
        students.forEach((student) => {
          studentOptions += `<option value="${student.id}">${student.student_number} - ${student.full_name}</option>`;
          $("#studentId").html(studentOptions);
        });
      }
    );
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
