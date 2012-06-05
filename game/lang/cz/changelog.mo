<?php
$lang['Changelog']   = 'Changelog';
$lang['Version']     = 'Version';
$lang['Description'] = 'Description';
$lang['version_no']  = '0.04';
$lang['changelog']   = array(

'0.04' => '- Fixd time format to W-D-M-Y H:m:s. (freejerry)
- Fixd facilities page for moon header image lose. (freejerry)
- Fixd resource production bug. (freejerry)',

'0.03' => '- Fixd bug of \'tear down\' button. (freejerry)
- Fixd overview page header image lose when switch between plant and moon. (freejerry)
- Fixd build link error in building pages. (freejerry)
- Fixd build link error in building pages. (freejerry)
- Fixd improve botton in research page. (freejerry)',

'0.02' => '- Fix storage formula. (freejerry)
- Fixd header image in building pages. (freejerry)
- Fixd icon of resource not found in facilities page. (freejerry)
- Removed extra button in facilities and shipyard page. (freejerry)',

'0.01' => '- Project start.
- Base on Xnova Redesigned V.1 &beta;15. (freejerry)',

'1 &beta;15' => '- Fixed bugs in install. (Anthony)
- Protected install script so that it can\'t be re-run after install. (Anthony)
- Moved paysystem keys to SETUP.PHP. (Anthony)
- Started work on OO modules. (Anthony)
- Sorted user validation. (Anthony)
- Language fixes. (darksoldier)
- Increased max points possible. (heinzel)
- Users online, Players, Last user on login page now works. (Anthony)
- Fixed changelog template. (Anthony)
- Fixed galaxy view. (Anthony)
- Fixed install script. (Anthony)',

'1 &beta;14' => '- UgaSecurity. (shoghicp)
- Fixed Error 404 in Buildings. (shoghicp)
- Fixed Info page. (zoria)
- Fixed switch sender/receiver fleet. (zoria)
- NaN energy error fixed. (shoghicp)
- Changelog fixed. (shoghicp)
- Logout fixed. (shoghicp)
- Fixed division by zero in fleetm. (shoghicp)
- Fixed several minor bugs. (shoghicp)
- UGamelaPlay Pay for buying Darkmatter. (shoghicp)
- Fixed Time/Countdown/FadeIn bug. (zoria)',

'1 &beta;13' => '- Installation now displays the error when an unexpected value is returned. (Anthony)
- Fixed planet delete. (Anthony)
- Fixed bug in planet list where destroyed planets were still shown. (Anthony)
- Removed destroyed status for moons. (Anthony)
- Fleet recall moved into a function. (Anthony)
- Fixed bug with moon images. (Anthony)
- More helpful cookie messages. (Anthony)
- Fixed a bug in CR generation. (Anthony)
- Fleet dispatch from moons now sorted. (Placebo)
- Fixed bug in Facilities page were quick upgrade went to Resources page with Facilities CSS. (Anthony)
- Links to Statistics and Galaxy set up in Overview. (darksoldier)',

'1 &beta;12' => '- Fixed bug in Resources bar where < was comparing values alphabetically, not numerically so \'11\' < \'9\'. (Anthony)
- ^ Fixed same bug in fleet dispatch. (Anthony)
- Officer images bug sorted. (Anthony)
- Fleet Return and Deployment is sorted. (Anthony)
- Fleet Transport is sorted. (Anthony)
- Fixed the tickbox javascript on messages page. (Anthony)
- Espionage missions started, counter espionage attacks not done yet. (Anthony)
- Colinization missions checked - works since beta 5b. (Anthony)
- Update to the fleet ajax. (Anthony)
- Harvest mission sorted. (Anthony)
- Updated useage of depecared ereg_replace() to preg_replace(). (Anthony)
- AJAX only updates fleets when something has changed. Less server load and better results. (Anthony)
- Attack mission sorted. (Anthony)
- Fleet recall sorted. (Anthony)
- Clicking on the fleet mouseover on any page takes you to fleet movement. (Anthony)
- Fixed bug in fleet dispatch where all un-available missions showed as expeiditions. (Anthony)
- Started on achievements system. (Anthony)
- Fixed bug in cleanstring() function. (Anthony)
- Fixed bug in Combat Report generation. (Anthony)
- Fixed moon image in Empire view. (Anthony)
- Expedition missions now code. More scenarios needed though. (Anthony)
- Messages alery moved to ajax, so new messages cleared once you have viewed them and updates when you get a message, not at login. (Anthony)
- Fixed bug in Fleet Info where co-ordinate locations were displayed wrong. (Anthony)
- Fleet Info now shows *:*:(MAX_PLANET_IN_SYSTEM + 1) as Outer Space. (Anthony)
- "Delete Messages" now works. (Anthony)
- "Delete Messages" now use ajax. (Anthony)
- Max user name length increased to 100 characters, and a limit also put on reg to stop any longer names. (Anthony)
- Countdowns now work for servers with -ve time offsets. (Anthony)
- Destroy missions sorted. (Anthony)
- Fixed a few bugs in the Admin menu. (Anthony)',

'1 &beta;11a' => '- Missile Dispatch fixed. (Anthony)
- Missile Dispatch moved to AJAX. (Anthony)
- Missile Dispatch now checks that user has the required amount of missiles. (Anthony)
- Bug in common.php fixed. (Anthony)',

'1 &beta;11' => '- Google Chrome Frame now supported. (Anthony)
- Further language implementation to templates. (Anthony, darksoldier)
- Building handler now manages fields properly. (Anthony)
- Ships built in Shipyard now appear. (Anthony)
- Overview Shipyard countdown fixed. (Anthony)
- Fixed bug in countdown timer on Research page. (Anthony)
- Template bug fixes. (Anthony, op2rules)
- GET data can now be sent via hex to allow all chars. (Anthony)
- Left menu for Admin Panel now works with new menu design. (Anthony)
- Ticket system now has an icon in left menu. (op2rules)',

'1 &beta;10' => '- Getting board of beta versions now. (Anthony)
- Jumpgates programmed. (Anthony)
- Moons now work with OGame theme. (Anthony)
- Updates to planetlist. (Anthony)
- planet_as_moon links on overview. (Anthony)
- Resources page fixed. (Anthony)
- Galaxy now supports phalanxing. (Anthony)
- Fleet mission selection do not skip to top of page when selecting mission. (Anthony)
- You can now send espionage fleets from the galaxy screen. (Anthony)
- Back button on fleet disptach programmed. (Anthony)',

'1 &beta;9' => '- Install script created. (Anthony)
- New login started. (Anthony)
- Registration updated. (Anthony)
- Skin support imporved. (Anthony)
- OGame skin support lost. :( Will be re-introduced for version 1. (Gameforge)
- Fleet Dispatch I sorted with AJAX. (Anthony)
- Fleet Dispatch II sorted with AJAX. (Anthony)
- Fleet Dispatch III sorted with AJAX. (Anthony)
- Finished Fleet Dispatch. (Anthony)
- Fixed bug where a returning fleet removed all fleet on the planet. (Anthony)',

'1 &beta;8' => '- Project developement moved to SVN. (msmith)
- One click build system. (msmith)
- New building queue system. (Anthony)
- New cost/time calculatation scripts. (Anthony)
- Added language support to countdown script. (Anthony)
- Options page submits to an alert box. (Anthony)
- Removed trader bug where the title would always show Crystal. (Anthony)
- More work on fleet dispatch. (Anthony)',

'1 &beta;7' => '- Alliance applications sorted. (Anthony)
- Leave alliance / kick users. (Anthony)
- Disband alliance. (Anthony)
- Tranfer alliance. (Anthony)
- Alliance converted to ajax. (Anthony)
- Javascript able sorting for alliance. (Anthony)
- Theme alert and dialogue boxes moved to javascript control. (Anthony)
- Matter and energy now update via ajax. (Anthony)
- Changed menu from table to list, to maintain skin compatability with OGame. (Anthony)
- New method of selecting planets in empire view. (Anthony)
- Fixed conflicting css in empire view causing the footer text to be 36px below where it should. (Anthony)
- Fixed empire header. (Anthony)
- Updated merchant. (Anthony)
- Fixed mr_box positioning errors with merchant. (Anthony)
- Change mr_box close function to double click when clicking on the background. (Anthony)
- Ajax now only sends a 32 char fleet hash, stopped the fleet info from flickering and speeds up ajax. (Anthony)
- Countdown script now used className to store time rather than a separate span. (Anthony)
- Countdown script now uses unix tiemstamps rather than a value in seconds. (Anthony)
- Updated building queue box. (Anthony)
- Recoded Fleet I javascript. (Anthony)
- Recoded Fleet II javascript. (Anthony)
- Fixed bug in overview where queue box displayed incorectly when nothing being built. (Anthony)
- Revised version numbering. (Anthony)',

'1 &beta;6' => '- Moon support stated. Moons can now be created and used. CSS changed are done via java as nescisery. Moon functions such as Phalanx and Jump Gate still to be done. (Anthony)
- Statistics page support now programmed so you cab view more than just 1 page. (Anthony)
- Statistics shows your page by default and you are highlighted on the list. (Anthony)
- Security bug in alliances page fixed. (Anthony)
- Bad links on overview fixed. (Anthony)
- Highscore link now shows your rank rather than just player count. (Anthony)
- Overview ranking now shows player rank. (Anthony)
- Updates to empire view. (Anthony)
- Fixed bug in Dark matter purchase whereby all attempts gave 100,000. (Anthony)
- Sorted registration page and functions. (Anthony)

- Welcome message bug fixed. (Anthony)
- Validation code generated and sent. (Anthony)
- Validation page sorted. (Anthony)
- Fixed bug in resources production where when 1 overflow was reached, all energy uses cut off. (Anthony)
- Fixed bug in resource production where production was multiplied by production factor twice. (Anthony)
- Added resources to ajax data transfer, this means that changes to resources will be notices before a page load. (Anthony)
- Added server time to ajax data transfer. (Anthony)',

'1 &beta;5b' => '- New mouseover images for all buildings, ships, defence and research. (Anthony)
- AJAX links in left menu are also standard links so that you can open in new tabs. (Anthony)
- New techtree using HTML Canvas or IE equivelent. (Anthony)
- Player status and avatars in galaxy mode. (djbart-kikku)
- Buddylist popup window. (djbart-kikku)
- Colinization mission. (Anthony)
- Fleet AJAX section updated. (Anthony)
- Planetlist count now doesn\'t count moons. (Anthony)
- Fixed bug in fleet dispatch when sending fleets to an unowned position. (Anthony)
- Player / Alliance search. (djbart-kikku)
- Player / Alliance search v2. (Anthony)
- Partial fix for AppleWebKit browsers such as Chrome on galaxy view. (Anthony)
- Changelog moved to popup rather than new page. (Anthony)',

'1 &beta;5a' => '- Edits to reg page, ticks and crosses script now outputs html rather than the pure image, meaning only three images are needed so images don\'t flicker (Anthony).
- Another edit to reg page, the TOS button checker uses .checked rather than .value so will detect when button is deselected too. (Anthony)
- Added a javascript function to submit forms view AXAH (Anthony)
- Fixed bug in javascript submission where checkbox and radio buttons sent the value, weather they were checked or not, added support for &lt;SELECT&gt; (Anthony)
- Added support for hidden values and textarea in ajax form submission, also any inputs without a specified type will not sen the value. (Anthony)
- Fixed send message popup so that scroll bars are not shown unnesciserily. (Anthony)
- Fixed close button on send message popup. (Anthony)
- Updated messages pages and alliance pages, messages mostly axah now, alliance core is axah. (Anthony)
- Updated Officers to axah. (Anthony)
- Upgrade ticket system - admin end to make it more obvious which tickets now need answering. (Anthony)
- Admins can now re-open closed tickets. (Anthony)',

'1 &beta;5' => '- All building pages now use AXAH page loads. (Anthony)
- Fixed image sized in the element info, to avoid distortians when loading. (Anthony)
- Admin centre user and planet management sorted. (Anthony)
- Headers overlay image complete. (Anthony)
- Shipyard changed to use url based submission, not form based. (Anthony)
- Bug where sometimes to build queue doubles the input fixed. (Anthony)
- Icoming fleets uses AJAX so can detect incoming fleets without a page refresh. (Anthony)
- Officers page mouseovers fixed and AXAH started there. (Anthony)
- More updates to the skin. (Anthony)
- Account Validation support started. (Anthony)
- Highscores page well underway including alliances. (Anthony)
- Several new menu icons created. (Anthony)
- New resources header image. (Anthony)
- Many small tweaks and minor updates. (Anthony)
- Messages can now be reported, intergrated into the ticket system. (Anthony)',

'1 &beta;4' => '- Dark Matter is now sorted. (Anthony)
- New page footer, started. (Anthony)
- Continued work on fleet dispatch, new countdowns and ETA. (Anthony and Joel)
- Support for the @ error supression in the error handler. (Anthony)
- Small menu inconsitancy fixed. (Anthony)
- Official beta server started. (Anthony)
- Database pruning started. (Anthony)
- Planet list auto-resizes on page load, depending on browser height. (Anthony)
- Imported the ticket system by Sk3y. (Anthony)
- New footer introduced. (Anthony)
- New menu images. (Anthony)
- Astrophysics technology created. (Anthony)',

'1 &beta;3a' => '- Started programing Dark Matter. (Anthony)
- Lots of work on the skin. (Anthony)
- Finished core of fleet dispatch, still some little tweaks left. (Anthony)
- New login page. (Anthony)
- Improved Changelog page. (Anthony)
- Change images on leftmenu when mouse is over (shoghicp)
- Planetname and title on resources and facilities (shoghicp)
- Logout (shoghicp)
- Starting redesigning of buddies and alliance pages (shoghicp)',

'1 &beta;3' => '- Finished Officers Page. (Anthony)
- Finished options page. (Anthony)
- Started fleet dispatch. (Anthony)
- New ship images started. (ErkaLi)
- Galaxy page finishes. (Anthony)
- Started officers page. (Anthony)
- Started options page. (Anthony)
- Research page, finished. (Anthony)
- Fleet and Defence pages combined and finished. (Anthony)
- Resources page updated and finalised. (Anthony)
- Facilities page updated and finalised. (Anthony)
- Resources page compelted. (Anthony)',

'1 &beta;2' => '- Following pages working as expected in new style:
> Rename/Delete planet. (Anthony)
> Facilities. (Anthony)
> Changelog. (Anthony)
> Trader. (Anthony)
- Skin support added*. (Anthony)
- Overview page working**. (Anthony)
* More choice, Planet and Building images in one skin, layout ect in another. (Anthony)
** Still need to show: Messages, Fleets, Current Research',

'1 &beta;1a' => '- Overview page updated to show planet info. (Anthony)
- Resources show actual resources. (Anthony)
- Resource ticker made to work. (Anthony)
- Left menu "current page" indicator set up. (Anthony)
- HTML Source Code for Overview and Resources set up. (Anthony)
- Most images obtained. (msmith)
- Flash files obtained. (msmith)',

'1 &beta;1' => '- New templates. (Anthony)
- New left menu, OGame style. (Anthony)- Planets list (right). (Anthony)
- Top menu. (msmith)
- New left menu. (Anthony)',

'Start' => '- Base files (DarkEvo Repack v0.9c). (Anthony)',



/*
'KEY' => '<font color="red">*</font> - "Feature has been removed to allow other imporvements"
<font color="blue">*</font> - "Feature has been replaced by a better system."
> - "Sub feature"',
*/

// 'Version' => 'Desc.',
);

?>
