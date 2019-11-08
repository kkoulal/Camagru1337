<?php require APPROOT . '/views/inc/header.php'; ?>

<?php
  if (isset($_GET['ntoken']))
    $_SESSION['ntoken'] = $_GET['ntoken'];
?>
<div class="col-md-5">



<!--     <div class="col-md-5 col">
      <div class="card card-body bg-light mt-4">
        <h2>Create An Account</h2>
        <p>Please fill out this form to register with us</p> -->
     <div class="card card-body bg-light mt-4">
       <div class="card card-body bg-light mt-4">
        <?php flash('register_success');?>
          <h2>Reset password</h2>
          <p>Please enter a new password</p>

        <form action="<?php echo URLROOT; ?>/users/redirect_forgot_password" method="POST">
          
          <div class="form-group">
            <label for="password">Password: <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="repassword">Repeat Password: <sup>*</sup></label>
            <input type="password" name="repassword" class="form-control form-control-lg <?php echo (!empty($data['repassword_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['repassword']; ?>">
            <span class="invalid-feedback"><?php echo $data['repassword_err']; ?></span>
          </div>
         

          <div class="row">
            <div class="col">
              <input type="submit" value="Reset" class="btn btn-success btn-block">
            </div>

          </div>
        </form>
    </div>
   </div>


      
</div>
  
<?php require APPROOT . '/views/inc/footer.php'; ?>