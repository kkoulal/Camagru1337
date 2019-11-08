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
 animation: divisibility 2s forwards;
 }
 </style>
<?php require APPROOT . '/views/inc/header.php'; ?>

<?php flash('Password_Updated');?>
<?php flash('Passwor_Updated');?>
<div align="center">
<div align="center" class="card" style=" width: 70%; height: 75%; float: center; margin-top: 100px; border-radius: 10px; ">

	<?php foreach ($data['images'] as $image):?>
	<div >
		<div class="card" >
		<?php echo " <img style= align:center: border-radius: 1%; width: 100%;height:30%;' src='". URLROOT. $image->url ."'/>"; ?>
		<form method="GET">
		<a 
            style=" align:center: font-size: smaller;" 
            href="<?php echo URLROOT;?>/users/login">
            <img 
            src="
            <?php  echo "https://www.sccpre.cat/png/big/1/13185_like-png.png";
            ?>"
            height="30" width="30">
          	</a>
		  <?php echo $this->cameraModel->nublikes($image->id);?>


		</form>
		<form method="POST" action="<?php echo URLROOT;?>/pages/gallerie">
		
		<input type="hidden" value="<?php echo $image->id;?>" name="img_id">
		
		<div style="overflow: auto; height:80px;">
		<?php foreach ($this->cameraModel->fetchall_comments($image->id) as $comments):?>
		<?php echo '<b>'.$comments->Username.'</b> : '.$comments->comment;?><br/>	
		<?php  endforeach; ?>
		</div>
		</form>
		</div>

	<?php  endforeach; ?>
	<?php
		$count = $this->cameraModel->postcount();
		$a = $count / 5;
		$a = ceil($a);
	?>
	<form method="POST">
		<?php
		for($b=1; $b<=$a;$b++){
		?>
	
		<input type="submit" value="<?php echo $b;?>" name="page">
	<?php } ?>
	</form>

  </div>
  </div>
  </div>



<?php require APPROOT . '/views/inc/footer.php'; ?>