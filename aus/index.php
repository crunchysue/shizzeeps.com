
<?php include "../inc/head.php" ?>

<script type="text/javascript">
	$(document).ready(function(){
	
		FindShizzeepsStatic('aus');
				
		var refreshrate = 60000*11; // 11 minutes
		$.timer(refreshrate, DisplayDataStatic);
		
	
	// PDX
	$('#btnPDX').click(function(){
		location.href = "/pdx/";
	});
	
	// AUS
	$('#btnAUS').click(function(){
		location.href = "/aus/";
	});
		
	}); // doc ready
</script>


<!-- ! Buttons -->
<div id="buttons" class="corners">
	<span id="btnPDX" class="button corners">PDX</span>
	<span id="btnAUS" class="button corners">SXSW</span>
	<span style="color:white">This page does not require a login.</span>
</div>

<!-- ! Content -->
<h2 id="explanation"></h2>
(Updates every 11 minutes.)

<div id="dataout"></div>

<?php //echo phpinfo(); ?>

<?php include '../inc/foot.php' ?>