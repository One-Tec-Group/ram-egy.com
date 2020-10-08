<!DOCTYPE html>
<html>
<head>
	<title>Products Barcode</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
	<section class="comtent">
		<div class="well table-hide" style="height:70px;">
			<span class="btn btn-info pull-right" id="print">Print Barcode</span>
		</div>
	</section>
	<table width="40%" align="center">
		<tr>
		<?php
			$i=0;
			foreach ($data as $value) {
				if($i==2){
					$i=0;
					echo "<tr>";
				}
		?>
				<td align="center" style="height: 100px;">
					<b><?php echo $value->name; ?></b><br>
					<img src="<?php echo $value->barcode; ?>">
				</td>
		<?php
			$i++;
			}
		?>
		</tr>
	</table>
</body>
<script type="text/javascript">
	$('#print').click(function(){
		$('.table-hide').hide();
		window.print();
		$('.table-hide').show();
	});
</script>
</html>