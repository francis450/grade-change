<div class="container register-form">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Register</h2>
            <form method="post" action="/register">
                <div class="mb-3">
                    <label for="username" class="form-label">Full Name:</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
                </div>

                <!-- error message -->
                <div class="alert alert-danger" role="alert" style="display: none;">
                    <p class="error"></p>
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>