<?php

class Simple_BB_Code{
	//General Tags
	var $tags = array(
		'b' => 'strong',
		'i' => 'em',
		'u' => 'span style="text-decoration:underline"',
		'quote' => 'blockquote',
		's' => 'span style="text-decoration: line-through"',
		'list' => 'ul',
		'sup' => 'sup',
		'sub' => 'sub',
		'\*' => 'li'
		);
	//Tags that must be mapped to diffierent parts
	var $mapped = array('url' => array('a','href',true),'img' => array('img','src',false));
	//Tags with atributes
	var $tags_with_att = array('color' => array('font','color'),'size' => array('font','size'),'url' => array('a','href'));
	//Gotta have smilies
	var $smilies = array(':)' => 'smile.gif',':(' => 'frown.gif');
	//Config Variables
	//Convert new line charactes to linebreaks?
	var $convert_newlines = true;
	//Parse For smilies?
	var $parse_smilies = true;
	//auto link urls(http and ftp), and email addresses?
	var $auto_links = true;
	//Internal Storage
	var $_code = '';
	function Simple_BB_Code($new=true,$parse=true,$links=true){
		$this->convert_newlines = $new;
		$this->parse_smilies = $parse;
		$this->auto_links = $links;
	}
	function parse($code){
		$this->_code = $code;
		$this->_strip_html();
		$this->_parse_tags();
		$this->_parse_mapped();
		$this->_parse_tags_with_att();
		$this->_parse_smilies();
		$this->_parse_links();
		$this->_convert_nl();
		return $this->_code;
	}
	function _strip_html(){
		$this->_code = strip_tags($this->_code);
	}
	function _convert_nl(){
		if($this->convert_newlines){
			$this->_code = nl2br($this->_code);
		}
	}
	function _parse_tags(){
		foreach($this->tags as $old=>$new){
			$ex = explode(' ',$new);
			$this->_code = preg_replace('/\['.$old.'\](.+?)\[\/'.$old.'\]/is','<'.$new.'>$1</'.$ex[0].'>',$this->_code);
		}
	}
	function _parse_mapped(){
		foreach($this->mapped as $tag=>$data){
			$reg = '/\['.$tag.'\](.+?)\[\/'.$tag.'\]/is';
			if($data[2]){
				$this->_code = preg_replace($reg,'<'.$data[0].' '.$data[1].'="$1">$1</'.$data[0].'>',$this->_code);
			}
			else{
				$this->_code = preg_replace($reg,'<'.$data[0].' '.$data[1].'="$1">',$this->_code);
			}
		}
	}
	function _parse_tags_with_att(){
		foreach($this->tags_with_att as $tag=>$data){
			$this->_code = preg_replace('/\['.$tag.'=(.+?)\](.+?)\[\/'.$tag.'\]/is','<'.$data[0].' '.$data[1].'="$1">$2</'.$data[0].'>',$this->_code);
		}
	}
	function _parse_smilies(){
		if($this->parse_smilies){
			foreach($this->smilies as $s=>$im){
				$this->_code = str_replace($s,'<img src="'.$im.'">',$this->_code);
			}
		}
	}
	function _parse_links(){
		if($this->auto_links){
			$this->_code = preg_replace('/([^"])(http:\/\/|ftp:\/\/)([^\s,]*)/i','$1<a href="$2$3">$2$3</a>',$this->_code);
			$this->_code = preg_replace('/([^"])([A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4})/i','$1<a href="mailto:$2">$2</a>',$this->_code);
		}
	}
	function addTag($old,$new){
		$this->tags[$old] = $new;
	}
	function addMapped($bb,$html,$att,$end=true){
		$this->mapped[$bb] = array($html,$att,$end);
	}
	function addTagWithAttribute($bb,$html,$att){
		$this->tags_with_att[$bb] = array($html,$att);
	}
	function addSmiley($code,$src){
		$this->smilies[$code] = $src;
	}
}
?>
