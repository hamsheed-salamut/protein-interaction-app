<?php include "blocks/head.inc.php"; ?>

<?php 
	$param =  $_GET['pid'];
	echo '<script language="javascript">';
	//echo 'alert("'.$param.'")';
	echo 'var pdbidentifier = ' .$param;
	echo '</script>';
	?>

<div class="container">
		<div class="row">
        <div class="col-md-6">
				<select id="jsmol_dropdown" class="form-control">
					<option value="1">Ball and Stick</option>
					<option value="2">Spacefill</option>
					<option value="3">Wireframe</option>
					<option value="4">Ribbon</option>
					<option value="5">Backbone</option>
					<option value="6">Trace</option>
				</select>
			</div>
			<div class="col-md-6">
				<div id="jsmol_panel">
				</div>
			</div>

		</div>
	</div>


    <?php include "blocks/footer.inc.php"; ?>


<script>
	$(document).ready(function() {		
		Jmol._isAsync = false;
		var jmolApplet0;
		console.log('i am in');
		var s = document.location.search;
		Jmol._debugCode = (s.indexOf("debugcode") >= 0);
		
		jmol_isReady = function(applet) {
			// document.title = (applet._id + " - Jmol " + Jmol.___JmolVersion);
			jmolApplet0 = applet;
			
			 // blue, deepskyblue, cornflowerblue, cadetblue, turquoise
			 // , cyan, yellow, gold, green, greenblue, chartreuse, mediumspringgreen, 
			 // aquamarine, deeppink, magenta, purple, darkmagenta, blueviolet, violet, 
			 // orange, red, redorange, indianred, lightsalmon, tan, burlywood, sienna, gray,
			 // white, and bl
			var colors = 'select carbon; color gray;select nitrogen; color blue;select oxygen; color red;select sulfur; color yellow;';
			$("#jsmol_dropdown").change(function() {
				Jmol.script(applet,"set frank off; select all; hbonds off; spin off; wireframe off; spacefill off; trace off; set ambient 40; set specpower 40; slab off; ribbons off; cartoons off; label off; monitor off");
                //Jmol.script(applet,"set frank off; select all; hbonds off; spin off; wireframe off; spacefill off; trace off; set ambient 40; set specpower 40; slab off; ribbons off; cartoons off; label off; monitor off");
                Jmol.script(applet,'Select all; ;ribbon only; color group;');
				switch($(this).val()) {
					case '1': // bal and stick
						Jmol.script(applet,'select all; spacefill 23%; wireframe 0.15;');
						break;
					case '2': // spacefill
						Jmol.script(applet,'select all;spacefill only;');
						break;
					case '3': // wirefram
						Jmol.script(applet,'select all;Wireframe only');
						break;
					case '4': // ribbon
						Jmol.script(applet,'Select all; ;ribbon only; color group;');
						break;
					case '5': // Backbone
						Jmol.script(applet,'Select all; Backbone only;');
						break;
					case '6': // Trace
						Jmol.script(applet,'Select all; Trace only;');
						break;				
				}
			});
			
			var a = sessionStorage.getItem("sent");
			console.log('val is');
			console.log(a);
			$.ajax({
				url:'static/pdb/pdb3aln.ent',
				// url:'static/pdb/pdb4tkh.ent',
				type:'HEAD',
				error: function()
				{
					//file not exists
					console.log('pdb file does not exists');
					$("#jsmol_dropdown").css("display","none");
				},
				success: function()
				{
					var colors = 'select carbon; color gray;select nitrogen; color blue;select oxygen; color red;select sulfur; color yellow;';
				//	console.log('yooo ' + pdbidentifier);
					console.log('pdb file exists');
					var url = "http://www.rcsb.org/pdb/files/"+ <?php echo json_encode($_GET['pid']); ?> + ".pdb";
					$("#jsmol_dropdown").css("display","block");
					$("#jsmol_description").text("");
					Jmol.script(jmolApplet0,'load ' + url); //http://www.rcsb.org/pdb/files/
                    Jmol.script(applet,'Select all; ;ribbon only; color group;');
					// Jmol.script(jmolApplet0,'load static/pdb/pdb4tkh.ent');
				}
			});			
		}
		
		var Info = {
			width: 500,
			height: 500,
			debug: false,
			color: "0xFFFFFF",
			addSelectionOptions: false,
			use: "HTML5",   // JAVA HTML5 WEBGL are all options
			j2sPath: "static/js/jsmol/j2s", // this needs to point to where the j2s directory is.
			script: "set antialiasDisplay;",
			serverURL: "http://chemapps.stolaf.edu/jmol/jsmol/php/jsmol.php",
			readyFunction: jmol_isReady,
			disableJ2SLoadMonitor: true,
			disableInitialConsole: true,
			allowJavaScript: true
			//defaultModel: "$dopamine",
			//console: "none", // default will be jmolApplet0_infodiv, but you can designate another div here or "none"
		}

		
		$("#jsmol_panel").html(Jmol.getAppletHtml("jmolApplet0", Info));
		
		var lastPrompt=0;
	});
</script>
    </script>