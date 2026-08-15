<div id="header_top">
<img src="../graphics/resbar2.png" alt="Resources" />
<table class="header" class="header" align="center" width="281" id="resources">
	<tr>
		<td class="header" align="center" width="20%"><font size="1" color="#A5C7E3"><div id="metal"></div></font></td>
		<td class="header" align="center" width="20%"><font size="1" color="#A5C7E3"><div id="crystal"></div></font></td>
		<td class="header" align="center" width="20%"><font size="1" color="#A5C7E3"><div id="deut"></div></font></td>
		<td class="header" align="center" width="20%"><font size="1" color="#A5C7E3">{energy}</font></td>
		<td class="header" align="center" width="20%"><font size="1" color="#A5C7E3">{message}</font></td>
	</tr>
	<tr>
		<!--
		<td class="header" align="center">{metal_max}</td>
		<td class="header" align="center">{crystal_max}</td>
		<td class="header" align="center">{deuterium_max}</td>
		<td class="header" align="center"></td>
		<td class="header" align="center"><font></font></td>
		-->
	</tr>
</table>
</div>

<script LANGUAGE='JavaScript'>
<!--
var now = new Date();
var event = new Date();
var seconds = (Date.parse(now) - Date.parse(event)) / 1000;
var val = 0;
var val2 = 0;
var val3 = 0;

update();

function update() {
  now = new Date();
  seconds = (Date.parse(now) - Date.parse(event)) / 1000;

  val = (( {metal_perhour} / 3600) * seconds) + {metalh};
  full = 0;
  if( val >= {metal_mmax} ){ val = {metalh}; full = 1; }
  document.getElementById('metal').innerHTML = number_format( val ,0 , full);

  val = ( {crystal_perhour} / 3600) * seconds + {crystalh};
  full = 0;
  if( val >= {crystal_mmax} ){ val = {crystalh}; full = 1; }
  document.getElementById('crystal').innerHTML = number_format( val ,0 , full);

  val = ( {deuterium_perhour} / 3600) * seconds + {deuteriumh};
  full = 0;
  if( val >= {deuterium_mmax} ){ val = {deuteriumh}; full = 1; }
  document.getElementById('deut').innerHTML = number_format( val ,0 , full);


  ID=window.setTimeout('update();',1000);
}

function number_format(number,laenge,full) {
  number = Math.round( number * Math.pow(10, laenge) ) / Math.pow(10, laenge);
  str_number = number+'';
  arr_int = str_number.split('.');
  if(!arr_int[0]) arr_int[0] = '0';
  if(!arr_int[1]) arr_int[1] = '';
  if(arr_int[1].length < laenge){
    nachkomma = arr_int[1];
    for(i=arr_int[1].length+1; i <= laenge; i++){  nachkomma += '0';  }
    arr_int[1] = nachkomma;
  }
  if(arr_int[0].length > 3){
    Begriff = arr_int[0];
    arr_int[0] = '';
    for(j = 3; j < Begriff.length ; j+=3){
      Extrakt = Begriff.slice(Begriff.length - j, Begriff.length - j + 3);
      arr_int[0] = '.' + Extrakt +  arr_int[0] + '';
    }
    str_first = Begriff.substr(0, (Begriff.length % 3 == 0)?3:(Begriff.length % 3));
    arr_int[0] = str_first + arr_int[0];
  }
  returnv = arr_int[0]+''+arr_int[1];
  if(full == 1){
  	return '<font>'+returnv+'</font>';
  }else{
  	return returnv;
  }
}
// --></script>