<?php include "blocks/head.inc.php"; ?>
<?php include "blocks/menu.inc.php"; ?>


<style>
    #cy {
      height: 70%;
      width: 60%;
      position: absolute;
      left: 0;
      top: 10;
      right: 0;
      margin-left: auto; 
      margin-right: auto; 
    }
</style>


 <div id="cy"></div>
  
				



<?php include "blocks/footer.inc.php"; ?>

<script>
	$(document).ready(function() {
		search('<?php if(isset($_POST['type']) && !empty($_POST['type'])) echo $_POST['type']; ?>', '<?php if(isset($_POST['id']) && !empty($_POST['id'])) echo $_POST['id']; ?>','<?php if(isset($_POST['filter']) && !empty($_POST['filter'])) echo $_POST['filter']; ?>');
	});
</script>


 <?php   include "blocks/closing.inc.php"; ?>