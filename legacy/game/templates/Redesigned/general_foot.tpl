<br class="clearfloat"/>
        
<!-- JAVASCRIPT -->
<script type='text/javascript' src='../scripts//redesign-0-9-9_jquery-1.2.6.min.js'></script>

<script type='text/javascript' src='../scripts//redesign-0-9-9_jquery.dimensions.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_jquery.hoverIntent.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_jquery.cluetip.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_jquery.configcluetip.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_jquery-ui.packed.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_thickbox.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_tools.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_slider.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_helpers.js'></script>

<script type='text/javascript' src='../scripts//redesign-0-9-9_tooltip.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_countdown.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_resourceTicker.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_utilities.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_errorBox.js'></script>
<script type='text/javascript' src='../scripts//redesign-0-9-9_messageSlider.js'></script>

<script type="text/javascript">
var timeDelta=1226238683000-(new Date()).getTime();LocalizationStrings=new Array();LocalizationStrings.timeunits=new Array();LocalizationStrings.timeunits.short=new Array();LocalizationStrings.timeunits['short'].day='d';LocalizationStrings.timeunits['short'].hour='h';LocalizationStrings.timeunits['short'].minute='m';LocalizationStrings.timeunits['short'].second='s';LocalizationStrings.status=new Array();LocalizationStrings.status.ready='done';LocalizationStrings['decimalPoint']=',';LocalizationStrings['thousandSeperator']='.';LocalizationStrings['unitMega']='M';LocalizationStrings['unitKilo']='K';OGConfig=new Array();OGConfig.sliderOn=1;function initTooltips(){var allChildNodes=getChildNodesWithClassName(document.getElementsByTagName('body')[0],'tooltip_plain');for(i in allChildNodes){if(typeof(allChildNodes[i])!='object')continue;var eventNode=allChildNodes[i];var temp=new tooltip(eventNode);}
var allChildNodes=getChildNodesWithClassName(document.getElementsByTagName('body')[0],'tooltip_sticky');for(i in allChildNodes){if(typeof(allChildNodes[i])!='object')continue;var eventNode=allChildNodes[i];var temp=new tooltip(eventNode);}}
var mySlider=new MessageSlider(document.getElementById('messagebox'));addListener(window,'load',function(){if(document.getElementById('messages_container')){var inhalt=document.getElementById('messages_container');var windowHeight=document.documentElement.clientHeight;var contentHeight=inhalt.offsetHeight;inhalt.style.height=Math.min((windowHeight-160),(contentHeight))+'px';}});var resourceTickerMetal={available:457.172222222,limit:[0,100000],production:0.00555555555556,valueElem:"resources_metal"};var resourceTickerCrystal={available:493.586111111,limit:[0,100000],production:0.00277777777778,valueElem:"resources_crystal"};var resourceTickerDeuterium={available:0,limit:[0,100000],production:0,valueElem:"resources_deuterium"};new resourceTicker(resourceTickerMetal);new resourceTicker(resourceTickerCrystal);new resourceTicker(resourceTickerDeuterium);function getFormatedDate(timestamp,format){var currTime=new Date();currTime.setTime(timestamp);str=format;str=str.replace('[d]',dezInt(currTime.getDate(),2));str=str.replace('[D]',days[currTime.getDay()]);str=str.replace('[m]',dezInt(currTime.getMonth()+1,2));str=str.replace('[M]',months[currTime.getMonth()]);str=str.replace('[j]',parseInt(currTime.getDate()));str=str.replace('[Y]',currTime.getFullYear());str=str.replace('[y]',currTime.getFullYear().toString().substr(2,4));str=str.replace('[G]',currTime.getHours());str=str.replace('[H]',dezInt(currTime.getHours(),2));str=str.replace('[i]',dezInt(currTime.getMinutes(),2));str=str.replace('[s]',dezInt(currTime.getSeconds(),2));return str;}
function dezInt(num,size,prefix){prefix=(prefix)?prefix:"0";var minus=(num<0)?"-":"",result=(prefix=="0")?minus:"";num=Math.abs(parseInt(num,10));size-=(""+num).length;for(var i=1;i<=size;i++){result+=""+prefix;}
result+=((prefix!="0")?minus:"")+num;return result;}
var currTime=new Date(1226238683000);var ev_updateServerTime;var days=new Array('Su','Mo','Tu','We','Th','Fr','Sa');var months=new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");function updateServerTime(){var currTime=new Date();currTime.setTime(currTime.getTime()+timeDelta);str=getFormatedDate(currTime.getTime(),'[D] [M] [j] [G]:[i]:[s]');document.getElementById('dateField').innerHTML=str;}
var textContent=new Array();textContent[0]=getFormatedDate(1226238683000,'[D] [M] [j] [G]:[i]:[s]');textContent[1]="Diameter:";textContent[2]="12.800km  (<span title=\"Used fields\">0</span>/<span title=\"Total fields\">163</span>)";textContent[3]="Temperature";textContent[4]="about -29 °C to 11°C";textContent[5]="Position:";textContent[6]="<a title=\'Galaxy view\'  href=\"index.php?page=galaxy&galaxy=1&system=67&position=11&session=415ef0c90c0f\" >[1:67:11]</a>";textContent[7]="Points:";textContent[8]="<a href='index.php?page=statistics&session=415ef0c90c0f&start=401' title='Statistic'>0 (Place 416 of 463)</a>";textContent[9]="Options:";textContent[10]="<a class='thickbox' onClick='tb_open(\"#TB_inline?height=380&width=669&inlineId=zeuch666&modal=true\");'>abandon/rename Planet</a>";var textDestination=new Array();textDestination[0]="dateField";textDestination[1]="diameterField";textDestination[2]="diameterContentField";textDestination[3]="temperatureField";textDestination[4]="temperatureContentField";textDestination[5]="positionField";textDestination[6]="positionContentField";textDestination[7]="scoreField";textDestination[8]="scoreContentField";textDestination[9]="optionsField";textDestination[10]="optionsContentField";var currentIndex=0;var currentChar=0;var linetwo=0;function type()
{var destination=document.getElementById(textDestination[currentIndex]);if(destination)
{if(textContent[currentIndex].substr(currentChar,1)=="<"&&linetwo!=1)
{while(textContent[currentIndex].substr(currentChar,1)!=">")
{currentChar++;}}
if(linetwo==1){destination.innerHTML=textContent[currentIndex];currentChar=destination.innerHTML=textContent[currentIndex].length+1;}else{destination.innerHTML=textContent[currentIndex].substr(0,currentChar)+"_";currentChar++;}
if(currentChar>textContent[currentIndex].length)
{destination.innerHTML=textContent[currentIndex];currentIndex++;currentChar=0;if(linetwo!=1){linetwo=1;ev_updateServerTime=setInterval("updateServerTime()",500);}
if(currentIndex<textContent.length)
{setTimeout("type()",50);}}
else
{setTimeout("type()",25);}}}
var defaultName='New planet name';function clearField()
{currentValue=document.planetMaintenance.newPlanetName.value;if(defaultName==currentValue)
{document.planetMaintenance.newPlanetName.value="";}}
function fillField()
{currentValue=document.planetMaintenance.newPlanetName.value;if(""==currentValue)
{document.planetMaintenance.newPlanetName.value=defaultName;}}
function abandonPlanet()
{document.planetMaintenanceDelete.submit();}
var cancelProduction_id;var production_listid;function cancelProduction(id,listid,question)
{cancelProduction_id=id;production_listid=listid;errorBoxDecision("Caution",""+question+"","yes","No",cancelProductionStart);}
function cancelProductionStart()
{window.location.replace("index.php?page=overview&session=415ef0c90c0f&modus=2&techid="+cancelProduction_id+"&listid="+production_listid);closeErrorBox();}
new baulisteCountdown(getElementByIdWithCache('Countdown'),50);var cancelResearch_id;function cancelResearch(id,question)
{cancelResearch_id=id;errorBoxDecision("Caution",""+question+"","yes","No",cancelResearchStart);}
function cancelResearchStart()
{window.location.replace("index.php?page=overview&session=415ef0c90c0f&modus=2"+"&techid="+cancelResearch_id);closeErrorBox();}
function initType(){type();}
$(document).ready(function(){initTooltips();initType();initCluetip();});</script><!-- END JAVASCRIPT -->

    </body>

</html>