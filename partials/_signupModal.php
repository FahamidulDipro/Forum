<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="signupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Sign Up for a <strong>ForumBest</strong> account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="partials/_handleSignup.php" method="POST"  enctype="multipart/form-data">

                    <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Profile Picture</label>
                    <input type="file" name="file" id="file" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                        <input type="password" name="cpassword" class="form-control" id="cpassword" required>
                        <div id="emailHelp" class="form-text">Please retype your password again</div>
                    </div>
                    <button type="submit" name = "submit" class="btn btn-success">Signup</button>
                </form>
            </div>
        </div>
    </div>
</div>