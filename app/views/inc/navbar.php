<div>
    <div class="container">
      <a href="<?php echo URLROOT;?>">Camagru</a>

      <nav>
        <ul>
          <?php if(isset($_SESSION['user_id'])):?>
             <li><a href="<?php echo URLROOT;?>/pages/gallerie">Gallerie</a></li>
            <li><a href="<?php echo URLROOT;?>/pages/camera">camera</a></li>
             <li><a href="<?php echo URLROOT;?>/users/profile">Profile</a></li>
             <li><a href="<?php echo URLROOT;?>/users/logout">Log out</a></li>



          <?php else:?>
          <li><a href="<?php echo URLROOT;?>">Home</a></li>
          <li><a href="<?php echo URLROOT;?>/users/Register">Register</a></li>
          <li><a href="<?php echo URLROOT;?>/users/login">Log in</a></li>
          
        <?php endif;?>
        </ul>
      </nav>
    </div>
</div>