<script>
	$(function() {
		$( "#dialog" ).dialog({
			autoOpen: true,
			width: 600,
			modal:true,
		});
		$( ".dialog1" ).dialog({
			autoOpen: false,
			width: 400,
			modal:false,
		});
		

		$( ".dialog2" ).dialog({
			autoOpen: true,
			width: 500,
			height: 550,
			modal:true,
		});
		$( ".dialog3" ).dialog({
			autoOpen: true,
			width: 500,
			height: 550,
		});
		$( "#dialog-link" ).click(function( event ) {
			$( ".dialog1" ).dialog( "open" );
			event.preventDefault();
		});

		<?php if ($jancho) {?>
			$( ".dialog2" ).dialog({ width: <?php echo $jancho;?> });
		<?php }?>
		<?php if ($jalto) {?>
			$( ".dialog2" ).dialog({ height: <?php echo $jalto;?> });
		<?php }?>
	});
</script>
