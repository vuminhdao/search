<?php 

function getResultGoogleSearch(){
	include("simple_html_dom.php");
	$url = "http://www.google.com/search?q=curl";
	$ch = curl_init();
	$timeout = 5;

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

	$html = curl_exec($ch);

	curl_close($ch);
	$html = file_get_html($url);
	$resultGoogle = array();
	foreach($html->find("li.g div.rc]") as $key=>$value){
		$resultGoogle[$key]['titleRG'] = $value->find("a",0)->plaintext;
		$resultGoogle[$key]['linkRG'] = $value->find("a",0)->href;
		$resultGoogle[$key]['linkRG'] = str_replace("/url?q=", "", $resultGoogle[$key]['linkRG']);
		$resultGoogle[$key]['descriptionRG'] = $value->find("span.st",0)->plaintext;    
	}
	return $resultGoogle;

}
$resultGoogle = getResultGoogleSearch();
?>

<div id="ires">
	<ol class="listRCG">
<?php
	$numRC = count($resultGoogle); 
	for($i=0;$i<$numRC;$i++){		
	echo"
		<li class='aRC aRC-id-001'>
			<div class='rc'>
				<div class='titleRC'>
					".$resultGoogle[$i]['titleRG']."
				</div>
				<div class='bodyRC'>
					<div class='linkRC'>
					<a href='".$resultGoogle[$i]['linkRG']."'></a>
						".$resultGoogle[$i]['linkRG']."		
					</div>
					<div class='descriptionRC'>
						".$resultGoogle[$i]['descriptionRG']."
					</div>
				</div>
			</div>
		</li>";
	}
		?>
	</ol>
</div>
