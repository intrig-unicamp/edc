<?php 

include "config.php";
$path = '5-s-all/tears/qos/';


function experimentID($files_name){
	$query = "SELECT * FROM experiments WHERE file_name='".$files_name."' and window_size='5' and video_name='tears' ";
	$sql = mysql_query($query);
	$rows = mysql_fetch_assoc($sql);
	
	return $rows['id'];
	//echo "<br>";
}



$dirs = array();

// directory handle
$dir = dir($path);

while (false !== ($entry = $dir->read())) {
    if ($entry != '.' && $entry != '..') {
       if (is_dir($path . '/' .$entry)) {
            $dirs[] = $entry; 
       }
    }
}
//echo 'Hello';

#print_r($dirs);
#die();
foreach($dirs as $names ){

	// echo 'THE DIR NAME '.$names;
	$files = array_diff(scandir($path."".$names), array('.', '..'));
	$totalFilesinEachDirectory =  count($files); // total number of files in each directory

	for($i = 2; $i<=$totalFilesinEachDirectory+1; $i++ ){

				$fh = fopen($path."".$names."/".$files[$i],'r');
				$array = array();
				while ($line = fgets($fh)) {
					 $values = explode(',',$line);
					 $file = explode('.',$files[$i]);
					 $parameters = explode('_',$file[0]);
					 echo '<pre>'; #print_r($parameters);echo '</pre>';
					 
					 #$match = 'host_'.$parameters[1].'_'.$parameters[2].'_'.$parameters[3].'_'.$parameters[4];
					 $intExpID = experimentID($names);
					 #$dpTimes = str_replace('[','',$values[6]);
					 #$dpTimes = str_replace(']','',$values[6]);
					 //$values[5];
					 $array[] = array($intExpID,$values[0],$values[1],$values[2],$values[3],$values[4],$values[5],$values[6],$values[7],$values[8],$values[9],$values[10],$values[11],$values[12],$values[13],$values[14]);
				}



				echo '<pre>';  print_r($array);  echo '</pre>';
				$s = 0;	
				foreach($array as $rows ){
					if($s != 0){
						echo  $query = "insert into features set intExpID='".$rows[0]."', timeslot ='".$rows[1]."', iitdp='".$rows[2]."', iitdp_gt100='".$rows[3]."', avg_time='".$rows[4]."' , avg_time_gt100='".$rows[5]."' , tp='".$rows[6]."' ,tpt='".$rows[7]."' , total_dp='".$rows[8]."' , total_dp_gt100 = '".$rows[9]."', std_less= '".$rows[10]."',  std_grt= '".$rows[11]."' ";
						mysql_query($query);
						$portID  = mysql_insert_id();
						#$dataPacketTimes = explode("~",$rows[6]);
						$dataPacketTimeString = explode("~",$rows[12]);
						$dataPacketString = explode("~",$rows[13]);

						for($j=0; $j<count($dataPacketTimeString)-1; $j++){
							echo $tQ = "insert into dp_times set intExpID ='".$rows[0]."', intFID='".$portID."', dp_timestamp='".$dataPacketTimeString[$j]."' ,packetlen= '".$dataPacketString[$j]."',dp_times_sec = '".date('Y-m-d H:i:s',$dataPacketTimeString[$j])."'  ";
							mysql_query($tQ);


						}


						echo '<br>';
					}
						$s++;

				}

	}







}

?>



