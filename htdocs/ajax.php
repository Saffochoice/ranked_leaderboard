<?php 
		$myfile = fopen("info.txt", "w");
		fwrite($myfile, $_GET['str']);
		fclose($myfile);
		$file = 'info_backup_final.txt';
		$new_str =  file_get_contents("info.txt") . "--" . PHP_EOL . PHP_EOL;

		file_put_contents($file, $new_str, FILE_APPEND | LOCK_EX);


		?>