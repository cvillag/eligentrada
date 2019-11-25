<?php 
	include 'initBD.php';
	
	$query = "select * from evento order by prioridad ,fechaCreacion";
	
	$result = mysql_query($query);
	if($numR = mysql_num_rows($result) > 0){
		while ($row = mysql_fetch_row($result)){
			echo '<h1>'.$row[1].'</h1>';
			echo '<p>' .$row[2]. '</p>';
			echo '<p>' .$row[3]. '</p>';
			echo '<p>' .$row[4]. '</p>';
			echo '<p>' .$row[5]. '</p>';
			echo '<p>' .$row[6]. '</p>';
			echo '<p>' .$row[7]. '</p>';
			echo '<p>' .$row[8]. '</p>';
		}
	}
?>