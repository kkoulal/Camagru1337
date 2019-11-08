
<style>

@keyframes divisibility {
 0% { opacity: 1.0; }
 25% { opacity: 0.75; }
 50% { opacity: 0.50; }
 75% { opacity: 0.25; }
 100% { opacity: 0.0; }
}
.alert{
 color: #468847;
 background-color: #dff0d8;
 border-color: #d6e9c6;
 animation: divisibility 10s forwards;
 }
 </style>
<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="col-md-5">



<!--     <div class="col-md-5 col">
      <div class="card card-body bg-light mt-4">
        <h2>Create An Account</h2>
        <p>Please fill out this form to register with us</p> -->
     <div class="card card-body bg-light mt-4">
     	 <div class="card card-body bg-light mt-4">
        <?php flash('register_success');?>
        <?php flash('Password_Updated');?>
        <?php flash('deleted_success');?>
	        <h2>Login</h2>
	        <p>Please fill in your credentials to log in</p>

        <form action="<?php echo URLROOT; ?>/users/Login" method="post">
          
          <div class="form-group">
            <label for="Username">Username: <sup>*</sup></label>
            <input type="text" name="Username" class="form-control form-control-lg <?php echo (!empty($data['Username_err'])) ? 'is-invalid' : ''; ?>" value="<?php if(isset($data['Username'])){echo $data['Username'];}  ?>">
            <span class="invalid-feedback"><?php echo $data['Username_err']; ?></span>
          </div>
          <div class="form-group">
            <label for="password">Password: <sup>*</sup></label>
            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
            <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
          </div>
         

          <div class="row">
            <div class="col">
              <input type="submit" value="Log in" class="btn btn-success btn-block">
            </div>
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/forgot_password" class="btn btn-light btn-block">forget password?</a>
            </div>
          </div>
        </form>
    </div>
   </div>


    	
</div>
  
<?php require APPROOT . '/views/inc/footer.php'; ?>