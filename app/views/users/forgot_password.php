<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="col-md-12">

     <div class="card card-body bg-light mt-4">
     	 <div class="card card-body bg-light mt-4">
        <?php flash('register_success');?>
	        <h2>Reset Password</h2>
	        <p>Please Enter your email</p>

        <form action="<?php echo URLROOT; ?>/users/forgot_password" method="post">
          
          <div class="form-group">
            <label for="email">Email: <sup>*</sup></label>
            <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php if(isset($data['email'])){echo $data['email'];}  ?>">
            <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
          </div>


          <div class="row">
            <div class="col">
              <input type="submit" value="submit" class="btn btn-success btn-block">
            </div>
          
          </div>
        </form>
    </div>
   </div>


    	
</div>
  
<?php require APPROOT . '/views/inc/footer.php'; ?>