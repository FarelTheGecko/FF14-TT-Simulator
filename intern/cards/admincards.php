<?php session_start();
require("../dbconnect/conn.php");

$o= $_GET['o'];

$direction= $_GET['direction'];

if ($o=="") 		$order="ORDER BY rarity,tt_cards.name;";
if ($o=="name") 	$order="ORDER BY tt_cards.name  $direction;";
if ($o=="rarity") 	$order="ORDER BY rarity  $direction,tt_cards.name;";
if ($o=="type") 	$order="ORDER BY type  $direction,tt_cards.name;";
if ($o=="p1") 		$order="ORDER BY p1  $direction,p2 $direction,p3 $direction,p4 $direction,tt_cards.name;";
if ($o=="p2") 		$order="ORDER BY p2  $direction,p3 $direction,p4 $direction,p1 $direction,tt_cards.name;";
if ($o=="p3") 		$order="ORDER BY p3  $direction,p4 $direction,p1 $direction,p2 $direction,tt_cards.name;";
if ($o=="p4") 		$order="ORDER BY p4  $direction,p1 $direction,p2 $direction,p3 $direction,tt_cards.name;";
if ($o=="patch") 	$order="ORDER BY patch  $direction,tt_cards.name;";

if ($direction=="desc")	$direction="asc";
elseif ($direction=="asc")	$direction="desc";
if ($direction=="")	$direction="desc";

if ($o=="name") 	$directionname		="&direction=$direction";
if ($o=="rarity") 	$directionrarity	="&direction=$direction";
if ($o=="type") 	$directiontype		="&direction=$direction";
if ($o=="p1") 		$directionp1		="&direction=$direction";
if ($o=="p2") 		$directionp2		="&direction=$direction";
if ($o=="p3") 		$directionp3		="&direction=$direction";
if ($o=="p4") 		$directionp4		="&direction=$direction";
if ($o=="patch") 	$directionpatch		="&direction=$direction";

$query = "SELECT tt_cards.id as cardid, tt_cards.name as cardname, tt_attribute.name as cardtype,rarity,p1,p2,p3,p4,patch
FROM tt_cards LEFT OUTER JOIN tt_attribute ON tt_cards.type=tt_attribute.id
WHERE deleted=0
$order";

require("../dbconnect/get_query.php");
if(!$result) echo" Query failed !".mysql_error();

$link->close;
?>
<html>

<?php 
include("../inter_header.php");
?>
<body><center>
<div class='header'>Cards</div>

<div class='buttonbox'>
	<a href='cardnew.php'  class='linkbutt_int'>
		<button type="button" class="btn btn-primary">Add card</button>
	</a>
	<a href='admincards.php'  class='linkbutt_int'>
		<button type="button" class="btn btn-primary">All cards</button>
	</a>
</div>


<div align='center'>
	<div style='width:800px; max-width:100%; padding:  0 0 20px 0;'>
	<?php
	echo '<table border="1">';
	echo"<div class='row bold'>
					<div class='col-xs-4 col-sm-2'>
						<a href='admincards.php?o=name$directionname'>
						Name</a>
					</div>
					<div class='col-xs-4 col-sm-2'>
						<a href='admincards.php?o=rarity$directionrarity'>
						Rarity	 </a>
					</div>
					<div class='col-xs-4 col-sm-2'>
						<a href='admincards.php?o=type$directiontype'>
						Type	 </a>
					</div>
					<div class='col-xs-4 col-sm-2'>Power
						<a href='admincards.php?o=p1$directionp1'>	&#x2BC5;	</a>
						<a href='admincards.php?o=p2$directionp2'>	&#x2BC8;	</a>
						<a href='admincards.php?o=p3$directionp3'>	&#x2BC6;	</a>
						<a href='admincards.php?o=p4$directionp4'>	&#x2BC7;	</a>
					</div>
					<div class='col-xs-4 col-sm-2'>
						<a href='admincards.php?o=patch$directionpatch'>
						Patch	 </a>
					</div>
					<div class='col-xs-4 col-sm-2'>&nbsp;</div>
				</div>";

			$num = mysqli_num_rows($result);
			for ($i = 0; $i < $num; $i++)
				{
				$row = mysqli_fetch_array($result);

				$cardid = $row[cardid];
				$rarity = $row[rarity];
					if ($rarity == 1) $rarity = "★";
					if ($rarity == 2) $rarity = "★★";
					if ($rarity == 3) $rarity = "★★★";
					if ($rarity == 4) $rarity = "★★★★";
					if ($rarity == 5) $rarity = "★★★★★";
					if ($rarity == 6) $rarity = "★★★★★★";
				$type = $row[cardtype];
				$name = $row[cardname];

				$p1 = $row[p1];	if($p1==10) $p1='A';
				$p2 = $row[p2];	if($p2==10) $p2='A';
				$p3 = $row[p3];	if($p3==10) $p3='A';
				$p4 = $row[p4];	if($p4==10) $p4='A';
				
				$patch = number_format($row[patch],2);

				echo"
				<div class='row cardinlist'>
					<div class='col-xs-4 col-sm-2'><a href='cardedit.php?nr=$cardid'>$name</a></div>
					<div class='col-xs-4 col-sm-2'>$rarity</div>
					<div class='col-xs-4 col-sm-2'>$type</div>
					<div class='col-xs-4 col-sm-2 powerlevels'>
						&nbsp;$p1<br>
						$p4&nbsp;$p2<br>
						&nbsp;$p3	
					</div>
					<div class='col-xs-4 col-sm-2'>$patch</div>
					<div class='col-xs-4 col-sm-2'>		
						<a href='carddel.php?nr=$cardid'>delete</a>
					</div>
				</div>
				";

				}
	echo"</table>";
	
	$link->close;

	$result->free;
	?>

	</div>
</div>
</body>
</html>