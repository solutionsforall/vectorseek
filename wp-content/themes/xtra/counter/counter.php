<?php 

/* Notes - add items manually to 'counter.txt'
           one item per line, in this format;
           id||0
           e.g. click-005||0
           e.g. my-id||0
           e.g. download-01||0
*/

$postID = $_GET['postID']; // vector post ID
$file = 'counter'.$postID.'.txt'; // path to text file that stores counts
$fh = fopen($file, 'r+');
$id = $_REQUEST['id']; // posted from page
$lines = '';
while(!feof($fh)){
	$line = explode('||', fgets($fh));
	$item = trim($line[0]);
	$num = trim($line[1]);
	if(!empty($item)){
		if($item == $id){
			$num++; // increment count by 1
			echo $num;
		}
		$lines .= "$item||$num\r\n";
	}
} 
file_put_contents($file, $lines);
fclose($fh);

?>	