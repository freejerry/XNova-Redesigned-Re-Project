function trader_update(resa,resb,resc,tradea,tradeb,tradec,input){
	
	//Call function liek this
	// trader_update('{resa}','{resb}','{resc}','{tradea}','{tradeb}','{tradec}','b/c');
	
	//What was editing?
	if(input == 'b'){
		input = resb;
		trade = tradeb;
	}else{
		input = resc;
		trade = tradec;
	}
	
	//Work out how much that is.
	document.getElementById('trad_'+resa+'_raw').value = tradea * ((document.getElementById('trad_'+resb).value / tradeb) + (document.getElementById('trad_'+resc).value / tradec));
	
	//Do we have that much?
	if(document.getElementById('trad_'+resa+'_raw').value * 1 > document.getElementById('ajax_'+resa).value * 1){

		//How much over are we?
		tomuch = document.getElementById('trad_'+resa+'_raw').value - document.getElementById('ajax_'+resa).value;
		
		//Set it to the max
		document.getElementById('trad_'+resa+'_raw').value = document.getElementById('ajax_'+resa).value;
		
		//How much do we have to reduce by
		tomuch = tomuch * trade / tradea;
		
		//Well do it then
		document.getElementById('trad_'+input).value = document.getElementById('trad_'+input).value - tomuch;
		
		//And round it
		document.getElementById('trad_'+input).value = Math.round(document.getElementById('trad_'+input).value - 0.5);
		
		//Work out how much that is again... deja vu
		document.getElementById('trad_'+resa+'_raw').value = tradea * ((document.getElementById('trad_'+resb).value / tradeb) + (document.getElementById('trad_'+resc).value / tradec));
	}
	
	//make it look nice
	document.getElementById('trad_'+resa).innerHTML = pretty_number(Math.round(document.getElementById('trad_'+resa+'_raw').value * 10) / 10);
	
	
}