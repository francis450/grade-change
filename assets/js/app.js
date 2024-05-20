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
          window.location.href = "/"; 
        } else {
          $(".alert").fadeIn();
          $(".error").html(data);
          $(".alert").fadeOut(2000);
        }
      }
    );
  });

  $(".register-form").submit(function (event) {
    event.preventDefault();

    var fullname = $("#fullname").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var confirmPassword = $("#confirm-password").val();

    if (password !== confirmPassword) {
      $(".alert").fadeIn();
      $(".error").html("Password do not match");
      $(".alert").fadeOut(2000);
      return;
    }

    $.post(
      "/grade-change/register",
      {
        fullname: fullname,
        email: email,
        password: password,
      },
      function (data) {
        if (data === "success") {
          window.location.href = "/login";
        } else {
          $(".alert").fadeIn();
          $(".error").html(data);
          $(".alert").fadeOut(2000);
        }
      }
    );
  });
});
