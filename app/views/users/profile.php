<?php require APPROOT . '/views/inc/header.php'; ?>

 <div  class="card card-body bg-light mt-4">
     	 <div style="margin-top:8%" class="card card-body bg-light mt-4">
	        <h2 style="text-align: center;">Change your informations</h2>
	     

        <form action="<?php echo URLROOT; ?>/users/Profile" >

             <div class="row">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/profile_Username" class="btn btn-light btn-block">Change Username</a>
            </div>
          </div>

           <div class="row">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/profile_email" class="btn btn-light btn-block">Change Email</a>
            </div>
          </div>

          <div class="row">
            <div class="col">
             <a href="<?php echo URLROOT; ?>/users/profile_password" class="btn btn-light btn-block">Change Password</a>
            </div>
          </div>


           <div class="row">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/deleteaccount" class="btn btn-light btn-block">deleteaccount</a>
            </div>
          </div>
          <div style="position:center;">
           </div>
        </form>
        <form method="post" action="<?php echo URLROOT; ?>/users/Profile">
                <input type='hidden' name="check" id="tester" value="test"/>
                <input type="checkbox" onclick="this.form.submit()"   <?php
                $check = $this->userModel->ischecked();
                  if($check->notif == 1) echo"checked"; else echo""; ?> >
                    <label for="notif">Want to recieve Notification?</label>
           </form>

           
        <?php 
        //print_r($_SESSION);
        ?>
    </div>
   </div>

   <div class="card card-body bg-light mt-4">
     	 <div class="card card-body bg-light mt-4">
	        <h2 style="text-align: center;">Your Activities</h2>
	        <p></p>

        <form action="<?php echo URLROOT; ?>/users/Profile" >

             <div class="row">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/dltcomments" class="btn btn-light btn-block">Delete all your Comments</a>
            </div>
          </div>

           <div class="row">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/dltlikes" class="btn btn-light btn-block">Delete all your Likes</a>
            </div>
          </div>


           <div class="row">
            <div class="col">
              <a href="<?php echo URLROOT; ?>/users/dltlpics" class="btn btn-light btn-block">Delete all your Pictures</a>
            </div>
          </div>

          </div>
          <div style="position:center;">
           </div>
           </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>


