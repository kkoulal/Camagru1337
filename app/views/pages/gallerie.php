<?php require APPROOT . '/views/inc/header.php'; ?>
<div align="center">
<div align="center" class="card" style=" width: 70%; height: 75%; float: center; margin-top: 100px; border-radius: 10px; ">

	<?php foreach ($data['images'] as $image):?>

		<div class="card">
		<?php echo "<img style='border-radius: 1%; width: 100%;height:30%;' src='". URLROOT. $image->url ."'/>"; ?>
		<form method="GET">
		<!-- <a 
            style="font-size: smaller;"  -->
           
            <img id="<?php echo $image->id;?>" onclick="like_ajax(<?php echo $image->id;?>)"
            src="
            <?php if (!($this->cameraModel->isliked($image->id))) 
            echo "https://www.sccpre.cat/png/big/1/13185_like-png.png"; 
            else echo "https://www.pngix.com/pngfile/big/35-351395_pouce-bleu-youtube-png-pouce-lev-transparent-png.png";
            ?>"
            height="3%" width="3%">
          	<!-- </a> -->
			  <span id="likesNbr<?php echo $image->id ;?>"><?php echo $this->cameraModel->nublikes($image->id);?>


		</form>
		</div>
		<form method="POST" action="<?php echo URLROOT;?>/pages/gallerie">
		<input style="width: 100%" type="text" name="comment">
		<input type="hidden" value="<?php echo $image->id;?>" name="img_id">
		<input type="submit" value="comment" name="ok">
		<div style="overflow: auto; height:80px;">
		<?php foreach ($this->cameraModel->fetchall_comments($image->id) as $comments):?>
		<?php echo '<b>'.$comments->Username.'</b> : '.$comments->comment;?><br/>	
		<?php  endforeach; ?>

		</div>
		</form>
		

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
  <script>
  function like_ajax(imgId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var arr = this.responseText.trim().split(',');
      document.getElementById(imgId).src = arr[0];
      document.getElementById('likesNbr' + imgId).innerHTML = arr[1];
    }
  };
  xhttp.open("GET", "http://localhost:8001/camagru/galleries/likeAjax?id=" + imgId, true);
  xhttp.send(); 
}
  </script>


<?php require APPROOT . '/views/inc/footer.php'; ?>