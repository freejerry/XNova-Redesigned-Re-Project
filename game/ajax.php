
<!-- Resources -->
<input type="hidden" id="ajax_metal" value="<?php echo $planetrow['metal']; ?>" />
<input type="hidden" id="ajax_crystal" value="<?php echo $planetrow['crystal']; ?>" />
<input type="hidden" id="ajax_deuterium" value="<?php echo $planetrow['deuterium']; ?>" />

<input type="hidden" id="ajax_energy_max" value="<?php echo $planetrow['energy_max']; ?>" />
<input type="hidden" id="ajax_energy_used" value="<?php echo $planetrow['energy_used']; ?>" />

<input type="hidden" id="ajax_matter" value="<?php echo ($user['matter'] * DARK_MATTER_FACTOR); ?>" />

<input type="hidden" id="ajax_metal_max" value="<?php echo $planetrow['metal_max']; ?>" />
<input type="hidden" id="ajax_crystal_max" value="<?php echo $planetrow['crystal_max']; ?>" />
<input type="hidden" id="ajax_deuterium_max" value="<?php echo $planetrow['deuterium_max']; ?>" />

<!-- Time -->
<input type="hidden" id="ajax_time" value="<?php echo time(); ?>" />

<!-- Menus update? -->
<input type="hidden" id="ajax_menus_update" value="<?php echo $user['menus_update']; ?>" />

<!-- Request time -->
<input type="hidden" id="ajax_request_time" value="<?php echo ($loadstart - microtime(true)); ?>" />

