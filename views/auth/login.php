<div class="row justify-content-center">
    <div class="col-md-6">
        <h1 class="text-center">Login</h1>
        <form class="login-form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <!-- Add error message here -->
            <div class="alert alert-danger" role="alert" style="display: none;">
                <p class="error"></p>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
</div>
