<?php

/**
 * notes.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

//Language
getLang('notes');


switch ($_GET['mode']) {
	case 'read':
	case 'write':
		//Do we have a note?
		if(idstring($_GET['note']) > 0){
			//Get the note
			$note = doquery("SELECT * FROM {{table}} WHERE `owner` = '".$user['id']."' AND `id` = '".idstring($_GET['note'])."' LIMIT 1 ;",'notes',true);
		}else{
			//No note
		}
		
		break;
	case 'add':
		//Add note to the database
		doquery("INSERT INTO {{table}} SET `owner` = '".$user['id']."', `time` = '".time()."', `priority` = '".idstring($_GET['pri'])."', `title` = '".mysql_real_escape_string($_GET['subject'])."', `text` = '".mysql_real_escape_string($_GET['note'])."' ;","notes");
		
		break;
	default:
	
		//Get the notes first.
		//`id`, `owner`, `time`, `priority`, `title`, `text`
		$query = doquery("SELECT * FROM {{table}} WHERE `owner` = '".$user['id']."' LIMIT 1 ;",'notes');
		
		//New note button
		$parse['page'] .= '
		<table cellspacing="0" cellpadding="0" id="notizen">
			<tr>
				<th colspan=4>
					<div style="margin-left:32px;">
						<a id="newNote" class="button188" href="#" onclick="getAXAH(\'./?page=notes&mode=write\',\'notesbody\');"><span>'.$lang['newnote'].'</span></a>
					</div>
				</th>
			</tr>';

		
		//Row titles
		$parse['page'] .= '
			<tr>
				<th class="spacer"/>					
				<th class="subject">'.$lang['Subject'].'</th>
				<th class="date">'.$lang['Date'].'</th>
				<th class="spacer"/>
			</tr>';
		
		$n = 0; $class = 'alt';
		while($row = mysql_fetch_assoc($query)){
			//Add one to the count of notes
			$n++;
			
			//Alternating row classes
			if($class == 'alt'){ $class = ''; }else{ $class = 'alt'; }
			if($row['priority'] == 2){ $pri = 'overmark'; }
			elseif($row['priority'] == 1){ $pri = 'undermark'; }
			else{ $pri = ''; }
			
			//Parse the row
			$parse['page'] .= '
			<tr class="'.$class.'">
				<th class="spacer"/>					
				<th class="subject">
				<a href="#" onclick="getAXAH(\'./?page=notes&mode=read&note='.$row['id'].'\',\'notesbody\');">
					<spam class="'.$pri.'">'.$row['title'].'</span>
				</a>
				</th>
				<th class="date">'.date("jS F H:i",$row['time']).'</td>
				<th class="spacer"/>
			</tr>';
		}

	
		makeAXAH(parsetemplate(gettemplate('network/notes'), $parse));
		break;
}
die();







$lang['PHP_SELF'] = './?page=notes';

if($_POST["s"] == 1 || $_POST["s"] == 2){//Edicion y agregar notas

	$time = time();
	$priority = $_POST["u"];
	$title = ($_POST["title"]) ? mysql_escape_string(strip_tags($_POST["title"])) : $lang['NoTitle'];
	$text = ($_POST["text"]) ? mysql_escape_string(strip_tags($_POST["text"])) : $lang['NoText'];

	if($_POST["s"] ==1){
		doquery("INSERT INTO {{table}} SET owner={$user['id']}, time=$time, priority=$priority, title='$title', text='$text'","notes");
		message($lang['NoteAdded'], $lang['Please_Wait'],'notes.'.$phpEx,"3");
	}elseif($_POST["s"] == 2){
		/*
		  pequeño query para averiguar si la nota que se edita es del propio jugador
		*/
		$id = intval($_POST["n"]);
		$note_query = doquery("SELECT * FROM {{table}} WHERE id=$id AND owner=".$user["id"],"notes");

		if(!$note_query){ error($lang['notpossiblethisway'],$lang['Notes']); }

		doquery("UPDATE {{table}} SET time=$time, priority=$priority, title='$title', text='$text' WHERE id=$id","notes");
		message($lang['NoteUpdated'], $lang['Please_Wait'], 'notes.'.$phpEx, "3");
	}

}
elseif($_POST){//Borrar

	foreach($_POST as $a => $b){
		/*
		  Los checkbox marcados tienen la palabra delmes seguido del id.
		  Y cada array contiene el valor "y" para compro
		*/
		if(preg_match("/delmes/i",$a) && $b == "y"){

			$id = str_replace("delmes","",$a);
			$note_query = doquery("SELECT * FROM {{table}} WHERE id=$id AND owner={$user['id']}","notes");
			//comprobamos,
			if($note_query){
				$deleted++;
				doquery("DELETE FROM {{table}} WHERE `id`=$id;","notes");// y borramos
			}
		}
	}
	if($deleted){
		$mes = ($deleted == 1) ? $lang['NoteDeleted'] : $lang['NoteDeleteds'];
		message($mes,$lang['Please_Wait'],'notes.'.$phpEx,"3");
	}else{header("Location: ./?s=".UNI."&page=networkmnotice");}

}else{//sin post...
	if($_GET["a"] == 1){//crear una nueva nota.
		/*
		  Formulario para crear una nueva nota.
		*/

		$parse = $lang;

		$parse['c_Options'] = "<option value=2 selected=selected>{$lang['Important']}</option>
			  <option value=1>{$lang['Normal']}</option>
			  <option value=0>{$lang['Unimportant']}</option>";

		$parse['cntChars'] = '0';
		$parse['TITLE'] = $lang['Createnote'];
		$parse['text'] = '';
		$parse['title'] = '';
		$parse['inputs'] = '<input type=hidden name=s value=1>';

		$parse['page'] .= parsetemplate(gettemplate('notes_form'), $parse);

		$display['page'] = $parse['page'];
		displaypage(parsetemplate(gettemplate('networkmnotice'), $display),$lang['Notes']);

	}
	elseif($_GET["a"] == 2){//editar
		/*
		  Formulario donde se puestra la nota y se puede editar.
		*/
		$note = doquery("SELECT * FROM {{table}} WHERE owner={$user['id']} AND id=$n",'notes',true);

		if(!$note){ message($lang['notpossiblethisway'],$lang['Error']); }

		$cntChars = strlen($note['text']);

		$SELECTED[$note['priority']] = ' selected="selected"';

		$parse = array_merge($note,$lang);

		$parse['c_Options'] = "<option value=2{$SELECTED[2]}>{$lang['Important']}</option>
			  <option value=1{$SELECTED[1]}>{$lang['Normal']}</option>
			  <option value=0{$SELECTED[0]}>{$lang['Unimportant']}</option>";

		$parse['cntChars'] = $cntChars;
		$parse['TITLE'] = $lang['Editnote'];
		$parse['inputs'] = '<input type=hidden name=s value=2><input type=hidden name=n value='.$note['id'].'>';

		$parse['page'] .= parsetemplate(gettemplate('notes_form'), $parse);

		$display['page'] = $parse['page'];
		displaypage(parsetemplate(gettemplate('networkmnotice'), $display),$lang['Notes']);
	}
	else{//default

		$notes_query = doquery("SELECT * FROM {{table}} WHERE owner={$user['id']} ORDER BY time DESC",'notes');
		//Loop para crear la lista de notas que el jugador tiene
		$count = 0;
		$parse=$lang;
		while($note = mysql_fetch_array($notes_query)){
			$count++;
			//Colorea el titulo dependiendo de la prioridad
			if($note["priority"] == 0){ $parse['NOTE_COLOR'] = "lime";}//Importante
			elseif($note["priority"] == 1){ $parse['NOTE_COLOR'] = "yellow";}//Normal
			elseif($note["priority"] == 2){ $parse['NOTE_COLOR'] = "red";}//Sin importancia

			//fragmento de template
			$parse['NOTE_ID'] = $note['id'];
			$parse['NOTE_TIME'] = date("Y-m-d h:i:s",$note["time"]);
			$parse['NOTE_TITLE'] = $note['title'];
			$parse['NOTE_TEXT'] = strlen($note['text']);

			$list .= parsetemplate(gettemplate('notes_body_entry'), $parse);

		}

		if($count == 0){
			$list .= "<tr><th colspan=4>{$lang['ThereIsNoNote']}</th>\n";
		}

		$parse = $lang;
		$parse['BODY_LIST'] = $list;
		//fragmento de template
		$parse['page'] .= parsetemplate(gettemplate('notes_body'), $parse);

		$display['page'] = $parse['page'];
		
		displaypage(parsetemplate(gettemplate('networkmnotice'), $parse),$lang['Title']);
	}
}
?>
