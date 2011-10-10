<?php
/**
 *
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// Fonctions deja 'au propre'
require_once(ROOT_PATH . 'includes/functions/SendSimpleMessage.php');
require_once(ROOT_PATH . 'includes/functions/RestoreFleetToPlanet.php');
require_once(ROOT_PATH . 'includes/functions/StoreGoodsToPlanet.php');
require_once(ROOT_PATH . 'includes/functions/CheckPlanetBuildingQueue.php');
require_once(ROOT_PATH . 'includes/functions/CheckPlanetUsedFields.php');
require_once(ROOT_PATH . 'includes/functions/CreateOnePlanetRecord.php');
require_once(ROOT_PATH . 'includes/functions/InsertJavaScriptChronoApplet.php');
require_once(ROOT_PATH . 'includes/functions/IsTechnologieAccessible.php');
require_once(ROOT_PATH . 'includes/functions/GetBuildingTime.php');
require_once(ROOT_PATH . 'includes/functions/GetRestPrice.php');
require_once(ROOT_PATH . 'includes/functions/GetElementPrice.php');
require_once(ROOT_PATH . 'includes/functions/GetBuildingPrice.php');
require_once(ROOT_PATH . 'includes/functions/IsElementBuyable.php');
require_once(ROOT_PATH . 'includes/functions/CheckCookies.php');
require_once(ROOT_PATH . 'includes/functions/ChekUser.php');
require_once(ROOT_PATH . 'includes/functions/InsertGalaxyScripts.php');
require_once(ROOT_PATH . 'includes/functions/GalaxyCheckFunctions.php');
require_once(ROOT_PATH . 'includes/functions/ShowGalaxySelector.php');
require_once(ROOT_PATH . 'includes/functions/ShowGalaxyRows.php');
require_once(ROOT_PATH . 'includes/functions/GetPhalanxRange.php');
require_once(ROOT_PATH . 'includes/functions/GetMissileRange.php');
require_once(ROOT_PATH . 'includes/functions/GetMaxConstructibleElements.php');
require_once(ROOT_PATH . 'includes/functions/GetElementRessources.php');
require_once(ROOT_PATH . 'includes/functions/ElementBuildListBox.php');
require_once(ROOT_PATH . 'includes/functions/ElementBuildListQueue.php');
require_once(ROOT_PATH . 'includes/functions/ResearchBuildingPage.php');
require_once(ROOT_PATH . 'includes/functions/BatimentBuildingPage.php');
require_once(ROOT_PATH . 'includes/functions/CaserneBuildingPage.php');
require_once(ROOT_PATH . 'includes/functions/CheckLabSettingsInQueue.php');
require_once(ROOT_PATH . 'includes/functions/InsertBuildListScript.php');
require_once(ROOT_PATH . 'includes/functions/AddBuildingToQueue.php');
require_once(ROOT_PATH . 'includes/functions/ShowBuildingQueue.php');
require_once(ROOT_PATH . 'includes/functions/HandleTechnologieBuild.php');
require_once(ROOT_PATH . 'includes/functions/BuildingSavePlanetRecord.php');
require_once(ROOT_PATH . 'includes/functions/BuildingSaveUserRecord.php');
require_once(ROOT_PATH . 'includes/functions/RemoveBuildingFromQueue.php');
require_once(ROOT_PATH . 'includes/functions/CancelBuildingFromQueue.php');
require_once(ROOT_PATH . 'includes/functions/SetNextQueueElementOnTop.php');
require_once(ROOT_PATH . 'includes/functions/ShowTopNavigationBar.php');
require_once(ROOT_PATH . 'includes/functions/SetSelectedPlanet.php');
require_once(ROOT_PATH . 'includes/functions/MessageForm.php');
require_once(ROOT_PATH . 'includes/functions/PlanetResourceUpdate.php');
require_once(ROOT_PATH . 'includes/functions/BuildFlyingFleetTable.php');
require_once(ROOT_PATH . 'includes/functions/SendNewPassword.php');
require_once(ROOT_PATH . 'includes/functions/HandleElementBuildingQueue.php');
require_once(ROOT_PATH . 'includes/functions/UpdatePlanetBatimentQueueList.php');
require_once(ROOT_PATH . 'includes/functions/IsOfficierAccessible.php');
require_once(ROOT_PATH . 'includes/functions/CheckInputStrings.php');
require_once(ROOT_PATH . 'includes/functions/MipCombatEngine.php');
require_once(ROOT_PATH . 'includes/functions/DeleteSelectedUser.php');
require_once(ROOT_PATH . 'includes/functions/SortUserPlanets.php');
require_once(ROOT_PATH . 'includes/functions/BuildFleetEventTable.php');
require_once(ROOT_PATH . 'includes/functions/ResetThisFuckingCheater.php');
require_once(ROOT_PATH . 'includes/functions/IsVacationMode.php');
require_once(ROOT_PATH . 'includes/functions/BBcodeFunction.php');
//The flowing two files were added for acs support. There location does not matter but if you move the files you must edit the file path below.
require_once(ROOT_PATH . 'includes/calculateAttack.php');
require_once(ROOT_PATH . 'includes/formatCR.php');
//MadnessRed / DarkEvo includes
require_once(ROOT_PATH . 'includes/relations.php');
require_once(ROOT_PATH . 'includes/madnessred.php');
//New redeisgned files.
require_once(ROOT_PATH . 'includes/formulas.php');
require_once(ROOT_PATH . 'includes/functions/PlanetType.php');
require_once(ROOT_PATH . 'includes/functions/GetFleetInfo.php');
require_once(ROOT_PATH . 'includes/functions/AllowedMissions.php');
require_once(ROOT_PATH . 'includes/functions/StatFunctions.php');
require_once(ROOT_PATH . 'includes/functions/PM.php');
require_once(ROOT_PATH . 'includes/functions/ProductionRates.php');
require_once(ROOT_PATH . 'includes/functions/BinaryDecode.php');
require_once(ROOT_PATH . 'includes/functions/ProtectNoob.php');
require_once(ROOT_PATH . 'includes/functions/AddMoon.php');
require_once(ROOT_PATH . 'includes/functions/AddToPlanet.php');
require_once(ROOT_PATH . 'includes/functions/BuildingQueue.php');
require_once(ROOT_PATH . 'includes/functions/BuildingProperties.php');
require_once(ROOT_PATH . 'includes/functions/DestroyPlanet.php');
require_once(ROOT_PATH . 'includes/functions/RecallFleet.php');
//New fleet engine files
require_once(ROOT_PATH . 'includes/functions/MissileAttack.php');
//New Redesigned Pages (Included when they are needed to save resources)
/*
require_once(ROOT_PATH . 'includes/pages/BuildRessourcePage.php');
require_once(ROOT_PATH . 'includes/pages/ShipyardPage.php');
require_once(ROOT_PATH . 'includes/pages/BuildingPage.php');
require_once(ROOT_PATH . 'includes/pages/ResearchPage.php');
*/
?>
