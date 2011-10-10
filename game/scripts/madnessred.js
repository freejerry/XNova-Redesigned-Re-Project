//This function will change the display properties of an element
function change_display(elementID,mode) {
	document.getElementById(elementID).style.display = mode;
}

//Char by Char function
function cbyc(id,string,timeout){
	var t;
	document.getElementById(id).innerHTML = document.getElementById(id).innerHTML + string[document.getElementById(id).innerHTML.length];
	if(document.getElementById(id).innerHTML.length < string.length){ t=setTimeout("cbyc('"+id+"','"+string+"',"+timeout+")",timeout); }
}
function cbycp(id){
	var str = document.getElementById('text').innerHTML;
	document.getElementById('text').innerHTML = '';
	document.getElementById('text').style.display = 'inline';
	return str;
}