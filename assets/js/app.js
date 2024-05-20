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
});
