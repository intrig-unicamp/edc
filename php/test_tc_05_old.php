<?php 
include "config.php";



$path = '5-s-all/tears/qoe/';

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

echo "<pre>"; print_r($dirs); echo "</pre>";




foreach($dirs as $names ){//loop to get all values

$dirNames 		= explode("_", $names);
echo "<pre>"; print_r($dirNames); echo "</pre>";

$file_name 				= $names;
#$delay 				= $dirNames[6];
$type 					= $dirNames[3];
$case   				= $dirNames[5];
$users 					= $dirNames[7];
$protocol 				= $dirNames[11];
$server 				= $dirNames[13];
$algo 					= $dirNames[9];

echo $query 			= "insert into  experiments (file_name, type,case_name, protocol_name, server_name,algo, users,window_size,video_name) values ('".$file_name."','".$type."','".$case."','".$protocol."','".$server."','".$algo."','".$users."','5','tears') ";
$sql 			= mysql_query($query);
$insertID 		= mysql_insert_id();

echo '<br>';

#die();
#echo "<br>";

$files = array_diff(scandir($path."".$names), array('.', '..'));
echo 'TOTAL --- '.$totalFilesinEachDirectory =  count($files); // total number of files in each directory




for($i = 2; $i<$totalFilesinEachDirectory+2; $i++ ){ // this loop to read all files from folder with +1 because index start with 2
	echo $files[$i];
	$uExp =  explode("_",$files[$i]);
	#echo $files[$i];	
	//echo "<br>";
	$uNum = (int) filter_var($uExp[1], FILTER_SANITIZE_NUMBER_INT);


#die();

$fh = fopen($path."".$names."/".$files[$i],'r');
$array = array();
while ($line = fgets($fh)) {




  // <... Do your work with the line ...>
  $line = str_replace("New connection was opened", ',', $line);
  $space = preg_replace('!\s+!', ' ', $line);
  
  $space = rtrim($space);
  //$space = ltrim($space);
  $space = explode(' ',$space);
  $pos = array_search(',', $space);
  unset($space[$pos]); 

  $array[] = $space;
}//while loop ends here
fclose($fh);
//$array = array_filter($array);

echo "<pre>";
//print_r($array);
echo "</pre>";
//die();
$c = 0;

foreach(array_slice($array, 1) as $key=>$rows ){





	//echo $key;
	  echo $query = "insert into dashoutput set 
										intExpID	= ".$insertID.", 
										intSeg 		= ".$rows[1].",
										intArr 		= ".$rows[2].",
										intDel      =".$rows[3].",
										intSta      =".$rows[4].",
										intRep      =".$rows[5].",
										intDelRate  =".$rows[6].",
										intActRate  =".$rows[7].",
										intByteSize =".$rows[8].",
										floatBuf    =".$rows[9].",

										algorithm_used  		='".$rows[10]."',
										Seg_Dur		=".$rows[11].",
										Width    				=".$rows[13].",
										Height  				=".$rows[14].",


										Protocol    			='".$rows[19]."',
										P1203    				=".$rows[20].",
										Clae    				=".$rows[21].",
										Duanmu    				=".$rows[22].",
										Yin    					=".$rows[23].",
										Yu          			=".$rows[24].",
										intUser     			=".$uNum."
										        
										";

										mysql_query($query);
										echo "<br>";echo "<br>";echo "<br>";

	if (++$c== 122) break;									
	
	}

	

}//2


}//1





?>
