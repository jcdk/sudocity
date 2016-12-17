<?php

	include('../secret.php');

	// ESTABLISH DB CONNECTION TO DB
	$connect_ID=mysql_connect(DB_HOST, DB_NAME, DB_PASSWORD);
	mysql_select_db(DB_NAME) or die ("Could not connect to database");

	// PICK LINKS - A QUERY APPROACH
	$query = "SELECT r.object_id, t1.term_id AS TagID, t1.name AS FromTag
				FROM wpsu_term_relationships r  
				INNER JOIN wpsu_term_taxonomy x ON x.term_taxonomy_id = r.term_taxonomy_id
				INNER JOIN wpsu_terms t1 ON t1.term_id = x.term_id
				WHERE x.taxonomy = 'post_tag' ORDER BY object_id DESC LIMIT 400";
	$result = mysql_query($query) or die('Errant query:  '.$query);

	if(mysql_num_rows($result)) {
		while($node = mysql_fetch_assoc($result)) {
		  $nodes[$node['object_id']][] = $node['FromTag'];
		  $arrPosts[] = $node['object_id'];
		  
		}
		
		$postArr = array();
		$links = array();
		
		foreach($nodes as $key=>$val) { 
			if (count($val)>1) {
				$tArray = $nodes[$key];
				$links[] = getAllCombinations($tArray,1);
			}
		}

		foreach($links as $key=>$val) {
			foreach($val as $keyo=>$valo) {
				$linko[] = $valo;
			}		
		}

		$linko = array_map("unserialize", array_unique(array_map("serialize", $linko)));

		$linko = array_values($linko);
				
	}
	

	$output = $linko;
	echo json_encode($output);
	

function getAllCombinations($array,$deg)
{
    if (count($array)==1 || $deg<1)
        return ($array);
    $res = array();
    $deg--;
    foreach ($array as $i=>$val)
    {
        $tArray = $array;
        unset($tArray[$i]);
        $subRes = getAllCombinations($tArray,$deg);
        foreach ($subRes as $t)
        {
            $res[]= array('source'=>$val,'target'=>$t,'value'=>1);
        }
    }
    return $res;
}

?>