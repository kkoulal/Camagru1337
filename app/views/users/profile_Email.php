<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="col-md-6">


     
     	 <div class="card card-body bg-light mt-4">
	        <p>Enter your new Email</p>
        <form action="<?php echo URLROOT; ?>/users/profile_Email" method="post">
          <div class="form-group">
            <label for="name">New Email:</label>
            <input type="Email" name="Email" class="form-control form-control-lg <?php echo (!empty($data['Email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['Email']; ?>">
            <span class="invalid-feedback"><?php echo $data['Email_err']; ?></span>
          </div>
          <div class="row">
            <div class="col">
              <input type="submit" value="Change Email " class="btn btn-success btn-block">
            </div>
          </div>
        </form>
    </div>
   </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>