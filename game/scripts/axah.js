//object detection to return the correct object depending upon broswer type. Used by the getAXHA(); function.
function getNewHttpObject() {
	 var objType = false;
	 try {
		  objType = new ActiveXObject('Msxml2.XMLHTTP');
	 } catch(e) {
		  try {
				objType = new ActiveXObject('Microsoft.XMLHTTP');
		  } catch(e) {
				objType = new XMLHttpRequest();
		  }
	 }
	 return objType;
}

//Function used to update page content with new xhtml fragments by using a javascript object, the dom, and http.
function getAXAH(url,elementContainer,title,pageid,extra,dofunction){
	if (typeof extra == "undefined") {
		extra = false;
	}
	if (typeof dofunction == "undefined") {
		dofunction = false;
	}

	//document.getElementById(elementContainer).innerHTML = '<blink class="redtxt">Loading...<\/blink>';
	var theHttpRequest = getNewHttpObject();
	theHttpRequest.onreadystatechange = function() {processAXAH(elementContainer,title,pageid,extra,dofunction);};
	theHttpRequest.open("GET", url);
	theHttpRequest.send(false);

		function processAXAH(elementContainer,title,pageid,extra,dofunction){
			if (theHttpRequest.readyState == 4) {
				if (theHttpRequest.status == 200) {
					document.getElementById(elementContainer).innerHTML = theHttpRequest.responseText;
					if(extra){
						update(title,pageid);
						run(pageid);
					}
					if(dofunction){
						setTimeout(dofunction,0);
					}
					//document.getElementById('rechts').style.height = (window.innerHeight-175)+'px';
				} else {
					document.getElementById(elementContainer).innerHTML="<p><span class='redtxt'>Error!<\/span> HTTP request return the following status message:&nbsp;" + theHttpRequest.statusText +"<\/p>";
				}
			}
		}

}


//Some things that should be run when a page is started
function run(page){
	switch(page){
		case "fleet2":
			
			break;
		
	}
}

//Mr box
function mrbox(url,width,margintop,title,method){
	var oldtitle = document.title;
	if (typeof title == "undefined") {
		title = oldtitle;
	}
	document.title = "Loading";
	document.getElementById('mrbox').style.display = 'block';

	if (typeof width != "undefined") {
		document.getElementById('mrbox_content').style.width = width+'px';
	}
	if (typeof margintop != "undefined") {
		document.getElementById('mrbox_content').style.marginTop = margintop+'px';
	}
	if(method == 'div'){
		document.getElementById('mrbox_content').innerHTML = document.getElementById(url).innerHTML;
		document.title = "title";
	}else{
		getAXAH(url,'mrbox_content',title,document.body.id,true);
	}
}
function mrbox_close(title){
	if (typeof title != "undefined") { document.title = title; }
	document.getElementById('mrbox').style.display = 'none';
	document.getElementById('mrbox_content').innerHTML = '';
}

var last_page="";
//Simple laod page function
function loadpage(url,title,pageid,func){
  if((last_page != url) or func)
  {
    document.title = "Loading";
    document.getElementById('cur_page').value = url;
    last_page=url;
    link = url+'&axah=true';
    getAXAH(link,'axah',title,pageid,true,func);
  }
}

//And finaly the bit we've been waiting for, the ajax.
function ajax(url,elementContainer,timeout,dofunction){
	getAXAH(url,elementContainer,'','',false,dofunction);
	t=setTimeout("ajax('"+url+"','"+elementContainer+"',"+timeout+",'"+dofunction+"')",timeout);
}

//For forms
function form2get(formid) {
	//Start the string
	var str = document.getElementById(formid).action;
	//Get elements int he form
	var elem = document.getElementById(formid).elements;
	//Foreach item in the form
	for(var i = 0; i < elem.length; i++){
		//if the item has a name and vlue andit not prefixed js_
		if(elem[i].name && elem[i].value && elem[i].name.substr(0,3) != 'js_'){
			//For input items
			if(elem[i].tagName.toLowerCase() == "input"){
				//If its a text item then we can jsut say the name-value
				if (elem[i].type.toLowerCase() == "text" || elem[i].type.toLowerCase() == "password" || elem[i].type.toLowerCase() == "hidden") {
					str += "&" + elem[i].name + "=" + elem[i].value;
				}
				//If its a checkbox or radio, it should only have that value if its checked.
				else if (elem[i].type.toLowerCase() == "checkbox" || elem[i].type.toLowerCase() == "radio") {
					if(elem[i].checked){
						str += "&" + elem[i].name + "=" + elem[i].value;
					}
				}
				//Otherwise just send its value
				else {
					str += "&" + elem[i].name + "=" + elem[i].value;
				}
			}
			//For select options
			else if(elem[i].tagName.toLowerCase() == "select"){
				//We need to get the value of the selected item
				str += "&" + elem[i].name + "=" + elem[i].options[elem[i].options.selectedIndex].value;
			}
			//For text boxes
			else if(elem[i].tagName.toLowerCase() == "textarea"){
				//We need to get the value of the selected item
				str += "&" + elem[i].name + "=" + elem[i].value;
			}
			
		}
	}
	return str;
}

//Sombit a form using form2get and loadpage
function submitform(formid,title,pageid,func){
	loadpage(form2get(formid),title,pageid,func);
}

//Make an alery box
function mr_alert(text,title,link){
	if (typeof title == "undefined") { title = "Alert"; }
	
	if (typeof link == "undefined") {
		link = "document.getElementById('notifyTB').style.display = 'none';";
	}else{
		link = "document.getElementById('notifyTB').style.display = 'none'; loadpage("+link+");";
	}
	
	document.getElementById('notifyTB_button').href = '#';
	document.getElementById('notifyTB_button').onclick = function(){ eval(link); };
	document.getElementById('errorBoxNotifyHead').innerHTML = title;
	document.getElementById('errorBoxNotifyContent').innerHTML = text;
	document.getElementById('notifyTB').style.display = 'block';
}

//Question box
function mr_qu(text,title,link1,link2,href){
	if (typeof title == "undefined") { title = "Alert"; }
	
	if (typeof link1 == "undefined") {
		link1 = "document.getElementById('decisionTB').style.display = 'none';";
	}else{
		link1 = "document.getElementById('decisionTB').style.display = 'none'; loadpage("+link1+");";
	}
	if (typeof link2 == "undefined") {
		link2 = "document.getElementById('decisionTB').style.display = 'none';";
	}else{
		link2 = "document.getElementById('decisionTB').style.display = 'none'; loadpage("+link2+");";
	}
	
	document.getElementById('decisionTB_button1').href = '#';
	document.getElementById('decisionTB_button1').onclick = function(){ eval(link1); };
	document.getElementById('decisionTB_button2').href = '#';
	document.getElementById('decisionTB_button2').onclick = function(){ eval(link2); };
	document.getElementById('errorBoxDecisionHead').innerHTML = title;
	document.getElementById('errorBoxDecisionContent').innerHTML = text;
	document.getElementById('decisionTB').style.display = 'block';
}

//Question box
function mr_qu_link(text,title,link1){
	if (typeof title == "undefined") { title = "Alert"; }
	
	link2 = "document.getElementById('decisionTB').style.display = 'none';";
	
	document.getElementById('decisionTB_button1').href = link1;
	document.getElementById('decisionTB_button2').href = '#';
	document.getElementById('decisionTB_button2').onclick = function(){ eval(link2); };
	document.getElementById('errorBoxDecisionHead').innerHTML = title;
	document.getElementById('errorBoxDecisionContent').innerHTML = text;
	document.getElementById('decisionTB').style.display = 'block';
}
