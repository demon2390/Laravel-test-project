<!DOCTYPE html>
<html>
<head>
    <title>Password reset</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            Password reset
        </div>
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="/reset-password">
                <input type="text" hidden="hidden" name="token" value="<?php echo $token; ?>">
                <input type="text" hidden="hidden" name="email" value="<?php echo $email; ?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">New password</label>
                    <input type="password" name="password" class="form-control" required="required">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Confirm password</label>
                    <input type="password" name="password_confirmation" class="form-control" required="required">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
