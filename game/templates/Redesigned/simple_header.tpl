<html>
<head>
<title>{title}</title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="{dpath}default.css" />
<link rel="stylesheet" type="text/css" href="{dpath}formate.css" />
<meta http-equiv="content-type" content="text/html; charset={ENCODING}" />
{-meta-}
<script type="text/javascript" src="scripts/overlib.js"></script>
<!-- TinyMCE -->
<script type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,|,insertdate,inserttime,|,forecolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,media,advhr",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "{dpath}formate.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "editor/lists/template_list.js",
		external_link_list_url : "editor/lists/link_list.js",
		external_image_list_url : "editor/lists/image_list.js",
		media_external_list_url : "editor/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
</head>
{-body-}

<!-- v Old File v -->

<!--
<html>
<head>
<title>{title}</title>
<link rel="shortcut icon" href="favicon.ico">
{-style-}
<meta http-equiv="content-type" content="text/html; charset={ENCODING}" />
{-meta-}
<script type="text/javascript" src="scripts/overlib.js"></script>
</head>
{-body-}-->
