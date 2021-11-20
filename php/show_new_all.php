<table>
<tr>
<th>Video</th>    
<th>Window</th>
<th>ExpID</th>
<th>Case</th>
<th>Algo</th>
<th>timeslot sec</th>
<th>timeslot mil</th>
<th>IAT</th>
<th>IPG Avg</th>
<th>IPG Avg GT100</th>
<th>IAT GT100</th>

<th>Throughput</th>
<th>Total Packets</th>
<th>Total Packet GT100</th>
<th>10p Length</th>
<th>20p Length</th>
<th>30p Length</th>
<th>40p Length</th>
<th>50p Length</th>
<th>60p Length</th>
<th>70p Length</th>
<th>80p Length</th>
<th>90p Length</th>

<th>Single EMA</th>
<th>CUSUM</th>
<th>Double EMA</th>
<th>P1203</th>
<th>P1203C</th>
<th>P1203N</th>
</tr>
<?php
include "config.php";

function getRows($e){
$query = "SELECT * FROM `features` where intExpID=".$e." order by timeslot asc";
$sql = mysql_query($query);
$array = array();
	while($rows = mysql_fetch_assoc($sql)){
		$array[]= $rows;
	}
	return $array;
}

function getP1203($T1, $T2,$intExpID){
	$query = "SELECT avg(P1203) as p1203 from dashoutput where intArr>".$T1." and intArr<=".$T2."  and intExpID=".$intExpID." ";
	$sql 	=mysql_query($query);
	$rows 	=mysql_fetch_assoc($sql);
	return $rows;
}
function EMACalc($mArray) {
  // $a = 2/($mRange + 1);
  $a = 0.99;
  $emaArray = [];
  // first item is just the same as the first item in the input
  $emaArray[] = $mArray[0];
  // for the rest of the items, they are computed with the previous one
  for ($i = 1; $i <count($mArray); $i++) {
    //$emaArray[] = $mArray[$i] * $a + $emaArray[$i - 1] * (1 - $a);
    $emaArray[] = $mArray[$i] * (1 - $a) + $emaArray[$i - 1] * $a; // Suneet
  }
  return $emaArray;
}

function DoubleEMACalc($mArray) {
  // $a = 2/($mRange + 1);
  $a = 0.99;
  $emaArray = [];
  // first item is just the same as the first item in the input
  $emaArray[] = $mArray[0];
  // for the rest of the items, they are computed with the previous one
  for ($i = 1; $i <count($mArray); $i++) {
    //$emaArray[] = $mArray[$i] * $a + $emaArray[$i - 1] * (1 - $a);
    // $emaArray[] = $mArray[$i] * (1 - $a) + $emaArray[$i - 1] * $a;
    $emaArray[] = ($a * $mArray[$i]) + ((1 - $a) + $emaArray[$i - 1]); // Fakhar
  }
  return $emaArray;
}


function cumsum ($arr) {
    return array_reduce($arr, function ($c, $i) { $c[] = end($c) + $i; return $c; }, []);
}

function getArrayPercentile($fID){
$query 	= mysql_query("select * from dp_times where intFID=".$fID." ");
//$sql	= mysq($query);
$array = array();
	while($rows = mysql_fetch_assoc($query)){

	$array[]= $rows['packetlen'];

	}
return $array;
}

function get_percentile($percentile, $array) {
    sort($array);
    $index = ($percentile/100) * count($array);
    if (floor($index) == $index) {
         $result = ($array[$index-1] + $array[$index])/2;
    }
    else {
        $result = $array[floor($index)];
    }
    return $result;
}

function getArray_dp_timestamp($fID){
$query 	= mysql_query("select * from dp_times where intFID=".$fID." ");
//$sql	= mysq($query);
$array = array();
	while($rows = mysql_fetch_assoc($query)){

	$array[]= $rows['dp_timestamp'];

	}
return $array;
}
function returnField($expid,$return){
$query = mysql_query("select algo,case_name,window_size,video_name from experiments where id=".$expid." ");
$rows=mysql_fetch_assoc($query);
return $rows[$return];

}

//////////////////////////////////////////////
for($e=19;$e<=27;$e++){
$vals = getRows($e);
$first = 0;
$second=0;
$count=1;
for($i=0;$i<count($vals); $i++ ){
	 $first = $i;
	 $second = $first+1; // I get keys here to make time sequence
	

	$T1 = $vals[$first]['timeslot']*1000;
	$T2 = $vals[$second]['timeslot']*1000;

	//Call P1203 Function to Get Aggregated P1203 b/w two time slots

	$QoE   = getP1203($T1, $T2, $vals[$i]['intExpID']);
	$P1203 = $QoE['p1203'];
	// echo '<br>';
	$packetsLenArray 	=  	getArrayPercentile($vals[$i]['intID']);
	$dp_timestamp  		= 	getArray_dp_timestamp($vals[$i]['intID']);

	$differences=[];
	$z=0;
    for($j=1;$j<count($dp_timestamp);$j++){
        $differences[]=abs($dp_timestamp[$j]-$dp_timestamp[$z++]);
    }
?>

 <?php if($P1203>0){?><tr>
    <td><?php echo returnField($vals[$i]['intExpID'],'video_name');?></td>
<td><?php echo returnField($vals[$i]['intExpID'],'window_size');?></td>
<td><?php echo $vals[$i]['intExpID'];?></td>
<td><?php echo returnField($vals[$i]['intExpID'],'case_name');?></td>
<td><?php echo returnField($vals[$i]['intExpID'],'algo');?></td>

<td><?php echo $vals[$i]['timeslot'];?></td>
<td><?php echo $vals[$i]['timeslot']*1000;?></td>
<td><?php echo $vals[$i]['iitdp'];?></td>

<td><?php echo $vals[$i]['avg_time'];?></td>
<td><?php echo $vals[$i]['avg_time_gt100'];?></td>
<td><?php echo $vals[$i]['iitdp_gt100'];?></td>

<td><?php echo $vals[$i]['tpt'];?></td>
<td><?php echo $vals[$i]['total_dp'];?></td>

<td><?php echo $vals[$i]['total_dp_gt100'];?></td>
<td><?php  
echo get_percentile(10, $packetsLenArray); ?></td>
<td><?php #$packetsLenArray =  getArrayPercentile05($rows['intID']); 
echo get_percentile(20, $packetsLenArray); ?></td>
<td><?php #$packetsLenArray =  getArrayPercentile05($rows['intID']); 
echo get_percentile(30, $packetsLenArray); ?></td>
<td><?php #$packetsLenArray =  getArrayPercentile05($rows['intID']); 
echo get_percentile(40, $packetsLenArray); ?></td>
<td><?php #$packetsLenArray =  getArrayPercentile05($rows['intID']); 
echo get_percentile(50, $packetsLenArray); ?></td>
<td><?php #$packetsLenArray =  getArrayPercentile05($rows['intID']); 
echo get_percentile(60, $packetsLenArray); ?></td>
<td><?php #$packetsLenArray =  getArrayPercentile05($rows['intID']); 
echo get_percentile(70, $packetsLenArray); ?></td>
<td><?php #$packetsLenArray =  getArrayPercentile05($rows['intID']); 
echo get_percentile(80, $packetsLenArray); ?></td>
<td><?php #$packetsLenArray =  getArrayPercentile05($rows['intID']); 
echo get_percentile(90, $packetsLenArray); ?></td>
<td><?php echo array_sum(EMACalc($differences));?></td>
<td><?php  echo array_sum(cumsum($differences));?></td>
<td><?php  echo array_sum(DoubleEMACalc($differences));?></td>

<td><?php echo $P1203;?></td>
<td><?php if($P1203>=1 && $P1203<=2){ echo "Poor";}elseif($P1203>2 && $P1203<=3){ echo "Average";}elseif($P1203>3 && $P1203<=4){echo "Good";}elseif($P1203>4 && $P1203<=5){echo "Excellent";} ?></td>

<td><?php if($P1203>=1 && $P1203<=2){ echo 1;}elseif($P1203>2 && $P1203<=3){ echo 2;}elseif($P1203>3 && $P1203<=4){echo 3;}elseif($P1203>4 && $P1203<=5){echo 4;} ?></td>

</tr><?}?>  


<?php }//out for loop
}//e for loop
?>
</table>