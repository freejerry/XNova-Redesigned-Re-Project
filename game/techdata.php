<?php
/*
 * techdata.php
 *
 * @version 1.1
 * @copyright 2008 by MadnessRed for XNova Redesigned
 * 
*/
includeLang('techdata');
$parse = $lang;
$Element = idstring($_GET['id']);
$ElementName = $lang['tech'][$Element];
switch ($_GET['opt']) {
case 'detail':
	$page  = "
	<html>
	<head>
		<title>"."</title>
		<script type=\"text/javascript\" src=\"./scripts/ECOTree.js\"></script>
		<link type=\"text/css\" rel=\"stylesheet\" href=\"./css/ECOTree.css\" />
		<link type=\"text/css\" rel=\"stylesheet\" href=\"./css/madnessred.css\" />
		<xml:namespace ns=\"urn:schemas-microsoft-com:vml\" prefix=\"v\"/>
		<style>v\:*{ behavior:url(#default#VML);}</style>
		<style>
			.copy {
				font-family : \"Verdana\";		
				font-size : 10px;
				color : #CCCCCC;
			}
		</style>
	</head>
	<body  style=\"height:".($divheightajusts[$Element] + 50)."px;overflow:none;\">
	<div style=\"background-image:url('".$dpath."/img/layout/wrap-header.gif');width:667px;height:34px;\"></div>
	<div style=\"background-image:url('".$dpath."/img/layout/wrap-body.gif');width:667px;\"><br />
		<a class=\"closeTB\" onclick=\"window.parent.mrbox_close();\" style='position:absolute;top:10px;right:10px;color:white;'>X</a> 
		<span style=\"margin:12px;text-align:center;\"><font color=white><strong><center>".$lang['tech'][$Element]."</strong></font><br /><br /></center></span>
		<table width=519>
		  <tr>
			<td class=c colspan=2>{TitleClass}</td>
		  </tr>
		  <tr>
			<th>{Name}</th>
			<th>{tech}</th>
		  </tr>
		  <tr>
			<th colspan=2>
			 <table>
			  <tr>
			   <td><img border=0 src='".$dpath."img/Xlarge/xlarge_".$Element.".jpg' align=top width=120 height=120></td>
			   <td style=color:white; >".$lang['descriptions'][$Element]."</td>
			  </tr>
			 </table>
			</th>
		  </tr>
		</table>		
	</div>
	<div style=\"background-image:url('".$dpath."/img/layout/wrap-footer.gif');width:667px;height:29px;\"></div>
	</body>
	</html>
	";
	die(AddUniToLinks(parsetemplate($page,array())));
break;

case 'tree':

	$heightajusts = array(
		43 => 60,
		214 => 100,
	);
	$divheightajusts = array(
		1 => 100,
		2 => 100,
		3 => 100,
		4 => 100,
		5 => 160,
		12 => 160,
		14 => 100,
		15 => 160,
		21 => 100,
		22 => 100,
		23 => 100,
		24 => 100,
		31 => 100,
		33 => 310,
		34 => 100,
		41 => 100,
		42 => 100,
		43 => 360,
		44 => 100,

		106 => 100,
		108 => 100,
		109 => 100,
		110 => 160,
		111 => 100,
		113 => 100,
		114 => 370,
		115 => 160,
		117 => 160,
		118 => 360,
		120 => 160,
		121 => 370,
		122 => 810,
		123 => 560,
		124 => 410,
		199 => 100,
		214 => 1000,
	);
	if(!in_array($Element,array_keys($heightajusts))){
		$heightajusts[$Element] = 10;
	}
	if(!in_array($Element,array_keys($divheightajusts))){
		$divheightajusts[$Element] = 800;
	}

	$n = 0;
	function get_req($id,$from = '-1',$req = 1){
		global $requeriments,$lang,$user,$planetrow,$resource,$n;
    $dpath="../skins/xr";
		//See if this item has requirements, if so give it space for the +/-
		if(is_array($requeriments[$id])){ $h = 55; }else{ $h = 46; }
		//See if we have met this requirement, get curent level
		$clevel = ($user[$resource[$id]] * 1) + ($planetrow[$resource[$id]] * 1);
		//Have we beet the requirement?
		if($clevel >= $req){
			$colour = 'lime';
			$req_txt = $req;
		}else{
			$colour = 'red';
			$req_txt = $clevel.'/'.$req;
		}
		//Add the item to the subtree
		$get_req = "\t\t\t\t".'myTree.add('.$n.','.$from.',"<a><img src=\''.$dpath.'/img/small/small_'.$id.'.jpg\' style=\'border:1px solid '.$colour.';\' /><span style=\'color:'.$colour.'\' onmouseover=\'mr_tooltip(\''.$req_txt.' - '.$lang['tech'][$id].\'');\' onmouseout=\'UnTip();\'></span></a>",46,'.$h.');'."";
		//Note this element then move onto the next.
		$from = $n; $n++;
		//If there are requirements.
		if(is_array($requeriments[$id])){
			//Then do the same for each of its requirements.
			foreach($requeriments[$id] as $nid => $req){
				$get_req .= get_req($nid,$from,$req);
			}
		}
		return $get_req;
	}

	$page  = "
	<html>
	<head>
		<title>"."</title>
		<script type=\"text/javascript\" src=\"./scripts/ECOTree.js\"></script>
		<link type=\"text/css\" rel=\"stylesheet\" href=\"./css/ECOTree.css\" />
		<link type=\"text/css\" rel=\"stylesheet\" href=\"./css/madnessred.css\" />
		<xml:namespace ns=\"urn:schemas-microsoft-com:vml\" prefix=\"v\"/>
		<style>v\:*{ behavior:url(#default#VML);}</style>
		<style>
			.copy {
				font-family : \"Verdana\";		
				font-size : 10px;
				color : #CCCCCC;
			}
		</style>
		<script type='text/javascript'>
			var myTree = null;

			function CreateTree() {
				myTree = new ECOTree('myTree','myTreeContainer');
				//myTree.config.linkType = 'B';
				myTree.config.iRootOrientation = ECOTree.RO_LEFT;					
				myTree.config.topXAdjustment = ".$heightajusts[$Element].";

				myTree.config.linkColor = \"#FFFFFF\";
				myTree.config.nodeColor = \"#FFFFFF\";
				myTree.config.nodeBorderColor = \"FFFFFF\";

				myTree.config.useTarget = false;
				myTree.config.selectMode = ECOTree.SL_SINGLE;						
				
".get_req($Element)."

				myTree.UpdateTree();
			}
		</script>
	</head>
	<body onload=\"CreateTree();\" style=\"height:".($divheightajusts[$Element] + 50)."px;overflow:none;\">
	<div style=\"background-image:url('".$dpath."/img/layout/wrap-header.gif');width:667px;height:34px;\"></div>
	<div style=\"background-image:url('".$dpath."/img/layout/wrap-body.gif');width:667px;\"><br />
		<a class=\"closeTB\" onclick=\"window.parent.mrbox_close();\" style='position:absolute;top:10px;right:10px;color:white;'>X</a> 
		<span style=\"margin:12px;text-align:center;\"><font color=white><strong><center>".$lang['tech'][$Element]."</strong></font><br /><br /></center></span>
		<div id=\"myTreeContainer\" style=\"height:".$divheightajusts[$Element]."px;overflow:none;\"></div>
	</div>
	<div style=\"background-image:url('".$dpath."/img/layout/wrap-footer.gif');width:667px;height:29px;\"></div>
	</body>
	</html>
	";
	die(AddUniToLinks(parsetemplate($page,array())));

break;
case 'techtree':
	function get_req($id,$level=1,$end=false){
		global $requeriments,$lang,$user,$planetrow,$resource;
		$get_req = '';
		if(is_array($requeriments[$id])){
			$n = 0; $t = sizeof($requeriments[$id]);
			foreach($requeriments[$id] as $id1 => $level1){
				$n++;
				if(!$end){
					$get_req .= "<div style=\"background-image:url('./img/techtree/tree_miss.png');width:".(($level - 1 )*32)."px;height:19px;left:0px;position:absolute;\"></div>";
				}else{
					$get_req .= "<div style=\"width:".(($level - 1 )*32)."px;height:19px;left:0px;position:absolute;\"></div>";
				}
				if($n == $t){
					$get_req .= "<div style=\"background-image:url('./img/techtree/tree_bot.png');width:32px;height:19px;left:".(($level - 1 )*32)."px;position:absolute;\"></div>";
					$end = true;
				}else{
					$get_req .= "<div style=\"background-image:url('./img/techtree/tree_branch.png');width:32px;height:19px;left:".(($level - 1 )*32)."px;position:absolute;\"></div>";
				}

				if($user[$resource[$id1]] > 0){ $clevel = $user[$resource[$id1]] * 1; }
				else{ $clevel = $planetrow[$resource[$id1]] * 1; }

				$get_req .= "<div style=\"background:none;width:auto;height:19px;left:".($level*32)."px;position:absolute;\">";
				$get_req .= colourNumber((1 + $clevel - $level1),$clevel." / ".$level1." - ".$lang['tech'][$id1]);
				$get_req .= "</div><br />";
				$get_req .= "";
				$get_req .= get_req($id1,($level + 1),$end);
			}
		}
		return $get_req;
	}

	$page  = "
	<html>
	<head>
	<title>"."</title>
	</head>
	<body>
	<div style=\"background-image:url('".$dpath."/img/layout/wrap-header.gif');width:667px;height:34px;\"></div>
	<div style=\"background-image:url('".$dpath."/img/layout/wrap-body.gif');width:667px;\"><br />
		<div style=\"margin-left:32px;position:relative;\">
		<font color=\"white\">".$ElementName."</font><br />".
		get_req($Element).
	"	</div>
	</div>
	<div style=\"background-image:url('".$dpath."/img/layout/wrap-footer.gif');width:667px;height:29px;\"></div>	
	</body>
	</html>
	";

	die(AddUniToLinks(parsetemplate($page,array())));

break;
}
// -----------------------------------------------------------------------------------------------------------
// History version
// - 1.0 mise en conformité code avec skin XNova
// - 1.1 ajout lien pour les details des technos
// - 1.2 suppression du lien details ou il n'est pas necessaire
?>
