
<!-- Resources -->
<input type="hidden" id="ajax_metal" value="<? echo $planetrow['metal']; ?>" />
<input type="hidden" id="ajax_crystal" value="<? echo $planetrow['crystal']; ?>" />
<input type="hidden" id="ajax_deuterium" value="<? echo $planetrow['deuterium']; ?>" />

<input type="hidden" id="ajax_energy_max" value="<? echo $planetrow['energy_max']; ?>" />
<input type="hidden" id="ajax_energy_used" value="<? echo $planetrow['energy_used']; ?>" />

<input type="hidden" id="ajax_matter" value="<? echo ($user['matter'] * DARK_MATTER_FACTOR); ?>" />

<input type="hidden" id="ajax_metal_max" value="<? echo $planetrow['metal_max']; ?>" />
<input type="hidden" id="ajax_crystal_max" value="<? echo $planetrow['crystal_max']; ?>" />
<input type="hidden" id="ajax_deuterium_max" value="<? echo $planetrow['deuterium_max']; ?>" />

<!-- Time -->
<input type="hidden" id="ajax_time" value="<? echo time(); ?>" />

<!-- Menus update? -->
<input type="hidden" id="ajax_menus_update" value="<? echo $user['menus_update']; ?>" />

<!-- Request time -->
<input type="hidden" id="ajax_request_time" value="<? echo ($loadstart - microtime(true)); ?>" />

