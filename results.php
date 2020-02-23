<?php include "blocks/head.inc.php"; ?>
<?php include "blocks/menu.inc.php"; ?>


<style>
    #cy {
      height: 70%;
      width: auto;
      position: absolute;
      left: 0;
      top: 10;
      right: 0;
      margin-left: 10%; 
      margin-right: 20%; 
    }
    
  .info-protein {
  text-align: justify;
	}

	. info-protein:after {
	  content: "";
	  display: inline-block;
	  width: 100%;
	}
	.uniprot-panel {
		float: right;
		margin-right: 15%;
		text-align: justify;
		display: inline-block;
		width: 15%;
	}
</style>
	<div class="container-wrapper">
	
			<div id="cy">
			</div>
				<div class="uniprot-panel">
				
                       <div class="btn btn-danger" role="alert">
					  	Protein Information Summary
						</div>
						   <div class="alert alert-dark" role="alert">
   						   <div class="protein-code">
						  
						   </div>
						   <div class="protein-name">

						   </div>
						   <div class="protein-function">
						   	   
					   	   </div>	   
						</div>
        		</div>
	</div>


<?php include "blocks/footer.inc.php"; ?>

<script>
	$(document).ready(function() {
		search('<?php if(isset($_POST['type']) && !empty($_POST['type'])) echo $_POST['type']; ?>', '<?php if(isset($_POST['id']) && !empty($_POST['id'])) echo $_POST['id']; ?>','<?php if(isset($_POST['filter']) && !empty($_POST['filter'])) echo $_POST['filter']; ?>');
	});
</script>


 <?php   include "blocks/closing.inc.php"; ?>