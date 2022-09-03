<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModalLabel">Create an Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action = "/forum/partials/_handlesignup.php" method = "post">
            <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">User Name</label>
                        <!-- <input type="email" class="form-control" id="email" name = "email" aria-describedby="emailHelp"> -->
                        <input type="text" class="form-control" id="email" name = "email" aria-describedby="emailHelp">
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name = "password">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Retype Password</label>
                        <input type="password" class="form-control" id="repassword" name = "repassword">
                        <div id="emailHelp" class="form-text">Passwords must be same and atleast 8 character long.</div>
                    </div>
                  
                    <button type="submit" class="btn btn-primary my-1">Sign Up</button>
                </div>
                
            </form>
      </div>
     
    </div>
  </div>
</div>