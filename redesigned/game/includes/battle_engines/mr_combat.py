#Import modules
import sys,random
import vars

#To interact with PHP in array, we can just serialize them, with thanks to http://hurring.com/scott/code/python/serialize/
from PHPUnserialize import *
from PHPSerialize import *

#Now let us begin
beg = 3
mid = beg+int(sys.argv[1]);
end = mid+int(sys.argv[2]);

#Get the fleets from the system arguments
attack_fleets = sys.argv[beg:mid];
defend_fleets = sys.argv[mid:end];

#Battle stuff, sort out some data for the battle
maxrounds = 8
debris_pc = 0.3 #30%
shipsend = 299 #ships are less than
def2deb = False #Defence counts toward debrisfield.

#Get attackersinto the array
attackers = {}
for fleet in attack_fleets:
	fleet = fleet.split(":")
	
	ships = {}
	for pair in fleet[2].split(";"):
		if len(pair) > 0:
			ship = pair.split(",")
			if int(ship[0]) <= shipsend or def2deb:
				is_ship = 1
			else:
				is_ship = 0
			ships[int(ship[0])] = {
				'count' : int(ship[1]),
				'shields' : vars.CombatCaps[int(ship[0])]['shield'] * (int(fleet[1].split(",")[1]) / 10.0),
				'weaps' : vars.CombatCaps[int(ship[0])]['attack'] * (int(fleet[1].split(",")[0]) / 10.0),
				'hull' : (vars.pricelist[int(ship[0])]['metal'] + vars.pricelist[int(ship[0])]['crystal']) * (int(fleet[1].split(",")[2]) / 10.0),
				'cost' : (vars.pricelist[int(ship[0])]['metal'] + vars.pricelist[int(ship[0])]['crystal'] + vars.pricelist[int(ship[0])]['deuterium']),
				'debm' : (vars.pricelist[int(ship[0])]['metal'] * debris_pc * is_ship),
				'debc' : (vars.pricelist[int(ship[0])]['crystal'] * debris_pc * is_ship),
				'shield_damage' : 0,
				'hull_damage' : 0,
				'damaged_s' : 0,
				'damaged_h' : 0
			}

	attackers[fleet[0]] = ships

#Get defenders into the array
defenders = {}
for fleet in defend_fleets:
	fleet = fleet.split(":")
	
	ships = {}
	for pair in fleet[2].split(";"):
		if len(pair) > 0:
			ship = pair.split(",")
			if int(ship[0]) <= shipsend or def2deb:
				is_ship = 1
			else:
				is_ship = 0
			ships[int(ship[0])] = {
				'count' : int(ship[1]),
				'shields' : vars.CombatCaps[int(ship[0])]['shield'] * (int(fleet[1].split(",")[1]) / 10.0),
				'weaps' : vars.CombatCaps[int(ship[0])]['attack'] * (int(fleet[1].split(",")[0]) / 10.0),
				'hull' : (vars.pricelist[int(ship[0])]['metal'] + vars.pricelist[int(ship[0])]['crystal']) * (int(fleet[1].split(",")[2]) / 10.0),
				'cost' : (vars.pricelist[int(ship[0])]['metal'] + vars.pricelist[int(ship[0])]['crystal'] + vars.pricelist[int(ship[0])]['deuterium']),
				'debm' : (vars.pricelist[int(ship[0])]['metal'] * debris_pc * is_ship),
				'debc' : (vars.pricelist[int(ship[0])]['crystal'] * debris_pc * is_ship),
				'shield_damage' : 0,
				'hull_damage' : 0,
				'damaged_s' : 0,
				'damaged_h' : 0
			}

	defenders[fleet[0]] = ships

#print attackers
#print defenders

#Start the results array, so far noone has won
results = {
	'won':'d',
	'attlost' : 0,
	'deflost' : 0,
	'debrmet' : 0,
	'debrcry' : 0
};

#Start the rounds
rounddata = {}
rounddata[0] = {
	'attfires':0,
	'deffires':0,
	
	'attpower':0,
	'defpower':0,
	
	'defblock':0,
	'attblock':0,
	
	'attack_fleets':PHPSerialize().serialize(attackers),
	'defend_fleets':PHPSerialize().serialize(defenders),
}

#For each round...
for round in range(1,(maxrounds+1)):
	#Backup the defending fleet first
	backup = PHPSerialize().serialize(defenders)	
	
	#Total ships
	fleet_totals = {}
	attacker_total = 0
	todel = []
	for fleetid,info in attackers.iteritems():
		fleet_totals[fleetid] = 0
		for id,info in attackers[fleetid].iteritems():
			attacker_total += info['count']
			fleet_totals[fleetid] += info['count']
		#Is fleet empty?
		if fleet_totals[fleetid] == 0:
			todel.append(fleetid)
	for fid in todel:
		del attackers[fid]
	
	defender_total = 0
	todel = []
	for fleetid,info in defenders.iteritems():
		fleet_totals[fleetid] = 0
		for id,info in defenders[fleetid].iteritems():
			defender_total += info['count']
			fleet_totals[fleetid] += info['count']
		#Is fleet empty?
		if fleet_totals[fleetid] == 0:
			todel.append(fleetid)
	for fid in todel:
		del defenders[fid]
	
	#now we see if any of them are dead
	if attacker_total == 0:
		results['won'] = 'v'
		break
	elif defender_total == 0:
		results['won'] = 'a'
		break
	else:
		
		#print "Round "+str(round)
	
		#Start round info.
		rounddata[round] = {
			'attfires':0,
			'deffires':0,
		
			'attpower':0,
			'defpower':0,
		
			'defblock':0,
			'attblock':0,
		
			'attack_fleets':'',
			'defend_fleets':'',
		}
		
		#First attacker fires, so, for each attacker.
		for fleetid,info in attackers.iteritems():
		
			#For each of this attackers ships
			for type,info in attackers[fleetid].iteritems():
				
				#For each of this type of ship
				for n in range (0,info['count']):
					
					stopfireing = False
					while stopfireing == False:
						
						#Unless rapidfire, this is the last shot
						stopfireing = True
						
						#If ships are still left
						if defender_total > 0:
						
							#now pick a random defender
							defid, temp = random.choice(defenders.items())
						
							#Now pick a random ship from that defender
							deftype, definfo = random.choice(defenders[defid].items())
						
							#Debug
							#print str(type) + ' fired up on ' + str(deftype)
						
							#Add 1 to fires count
							rounddata[round]['attfires'] += 1
							rounddata[round]['attpower'] += info['weaps']
					
							#Current attack power
							curattack = info['weaps']
						
							#Now did we find a damaged one?
							#chance for damaged hull = 
							if random.random() <= float(defenders[defid][deftype]['damaged_h']) / float(defenders[defid][deftype]['count']):
								curhull = defenders[defid][deftype]['hull'] - (float(defenders[defid][deftype]['hull_damage']) / float(defenders[defid][deftype]['damaged_h']))
							else:
								curhull = defenders[defid][deftype]['hull']

							#chance for damaged shields
							if random.random() <= float(defenders[defid][deftype]['damaged_s']) / float(defenders[defid][deftype]['count']):
								curshields = defenders[defid][deftype]['shields'] - (float(defenders[defid][deftype]['shield_damage']) / float(defenders[defid][deftype]['damaged_s']))
							else:
								curshields = defenders[defid][deftype]['shields']
							
					
							#Attack the shields - were they destroyed?
							if curshields <= curattack:					
						
								#Shields blocked some attack power
								curattack -= curshields
								
								#How much blocked?
								rounddata[round]['defblock'] += curshields
						
								#But were destroyed
								if curshields == defenders[defid][deftype]['shields']:
									defenders[defid][deftype]['damaged_s'] += 1
								defenders[defid][deftype]['shield_damage'] += curshields
								curshields = 0
						
						
								#Shields destroyed, damage the hull, - is hull destroyed?
								if curhull <= curattack:
							
									#and the damage can be removed
									defenders[defid][deftype]['hull_damage'] -= (defenders[defid][deftype]['hull'] - curhull)
									defenders[defid][deftype]['shield_damage'] -= (defenders[defid][deftype]['shields'] - curshields)
									
									#Add the cost to the defenders losses and debris
									results['deflost'] += defenders[defid][deftype]['cost']
									results['debrmet'] += defenders[defid][deftype]['debm']
									results['debrcry'] += defenders[defid][deftype]['debc']
																
									#was this ship damages?
									if curhull < defenders[defid][deftype]['hull']:
										defenders[defid][deftype]['damaged_h'] -= 1
								
									#We already know that shields were destroyed
									defenders[defid][deftype]['damaged_s'] -= 1	
													
									#Take 1 off the ship count
									defender_total -= 1
									defenders[defid][deftype]['count'] -= 1
									fleet_totals[defid] -= 1
									if defenders[defid][deftype]['count'] == 0:
										del defenders[defid][deftype]
									if fleet_totals[defid] == 0:
										del defenders[defid]
										#defenders[defid] = {}
										
									#howabout rapidfire?
									stopfiring = True #we are ignoring it
								else:
									#ship not destroyed
									defenders[defid][deftype]['hull_damage'] += curattack
									if curhull == defenders[defid][deftype]['hull']:
										defenders[defid][deftype]['damaged_h'] += 1
									curhull -= curattack
							
									#chance of it exploding,
									exp_ch = 1 - (float(curhull) / defenders[defid][deftype]['hull'])
							
									#does it explode
									if random.random() <= exp_ch:
										#Well it survived the shot but blew up anyway
									
										#Add the cost to the defenders losses and debris
										results['deflost'] += defenders[defid][deftype]['cost']
										results['debrmet'] += defenders[defid][deftype]['debm']
										results['debrcry'] += defenders[defid][deftype]['debc']
								
										#remove from damage
										defenders[defid][deftype]['damaged_h'] -= 1
										defenders[defid][deftype]['damaged_s'] -= 1
							
										#and the damage can be removed
										defenders[defid][deftype]['hull_damage'] -= (definfo['hull'] - curhull)
										defenders[defid][deftype]['shield_damage'] -= (definfo['shields'] - curshields)
													
										#Take 1 off the ship count
										defender_total -= 1
										defenders[defid][deftype]['count'] -= 1
										fleet_totals[defid] -= 1
										if defenders[defid][deftype]['count'] == 0:
											del defenders[defid][deftype]
										if fleet_totals[defid] == 0:
											del defenders[defid]
											#defenders[defid] = {}
										
										#how about rapidfire?
										stopfiring = True #we are ignoring it
							else:
								#shields not destroyed	
								defenders[defid][deftype]['shield_damage'] += curattack
								if curshields == definfo['shields']:
									defenders[defid][deftype]['damaged_s'] += 1
								
								#How much blocked?
								rounddata[round]['defblock'] += curattack
						
								#chance of it exploding,
								exp_ch = 1 - (float(curhull) / defenders[defid][deftype]['hull'])
							
								#does it explode
								if random.random() <= exp_ch:
									#Well it survived the shot but blew up anyway
									
									#Add the cost to the defenders losses and debris
									results['deflost'] += defenders[defid][deftype]['cost']
									results['debrmet'] += defenders[defid][deftype]['debm']
									results['debrcry'] += defenders[defid][deftype]['debc']
							
									#ship can be removes 
									defenders[defid][deftype]['count'] -= 1
							
									#remove from damage
									defenders[defid][deftype]['damaged_h'] -= 1
									defenders[defid][deftype]['damaged_s'] -= 1
							
									#and the damage can be removed
									defenders[defid][deftype]['hull_damage'] -= (definfo['hull'] - curhull)
									defenders[defid][deftype]['shield_damage'] -= (definfo['shields'] - curshields)
													
									#Take 1 off the ship count
									defender_total -= 1
									defenders[defid][deftype]['count'] -= 1
									fleet_totals[defid] -= 1
									if defenders[defid][deftype]['count'] == 0:
										del defenders[defid][deftype]
									if fleet_totals[defid] == 0:
										del defenders[defid]
										#defenders[defid] = {}
							
									#how about rapidfire?
									stopfiring = True #we are ignoring it

		#print "-"
		defenders_before = PHPUnserialize().unserialize(backup)
		
		#Next defender fires, so, for each defender.
		for fleetid,info in defenders_before.iteritems():
		
			#For each of this defenders ships
			for type,info in defenders_before[fleetid].iteritems():
				
				#For each of this type of ship
				for n in range (0,info['count']):
					
					stopfireing = False
					while stopfireing == False:
					
						#Unless rapidfire, this is the last shot
						stopfireing = True
						
						#If ships are still left
						if attacker_total > 0:
						
							#now pick a random attacker
							defid, temp = random.choice(attackers.items())
						
							#Now pick a random ship from that attacker
							deftype, definfo = random.choice(attackers[defid].items())
						
							#Debug
							#print str(type) + ' fired up on ' + str(deftype)
						
							#Add 1 to fires count
							rounddata[round]['deffires'] += 1
							rounddata[round]['defpower'] += info['weaps']
					
							#Current defend power
							curattack = info['weaps']
						
							#Now did we find a damaged one?
							#chance for damaged hull = 
							if random.random() <= float(attackers[defid][deftype]['damaged_h']) / float(attackers[defid][deftype]['count']):
								curhull = attackers[defid][deftype]['hull'] - (float(attackers[defid][deftype]['hull_damage']) / float(attackers[defid][deftype]['damaged_h']))
							else:
								curhull = attackers[defid][deftype]['hull']

							#chance for damaged shields
							if random.random() <= float(attackers[defid][deftype]['damaged_s']) / float(attackers[defid][deftype]['count']):
								curshields = attackers[defid][deftype]['shields'] - (float(attackers[defid][deftype]['shield_damage']) / float(attackers[defid][deftype]['damaged_s']))
							else:
								curshields = attackers[defid][deftype]['shields']
							
					
							#defend the shields - were they destroyed?
							if curshields <= curattack:					
						
								#Shields blocked some defend power
								curattack -= curshields
								
								#How much blocked?
								rounddata[round]['attblock'] += curshields
						
								#But were destroyed
								if curshields == attackers[defid][deftype]['shields']:
									attackers[defid][deftype]['damaged_s'] += 1
								attackers[defid][deftype]['shield_damage'] += curshields
								curshields = 0
						
						
								#Shields destroyed, damage the hull, - is hull destroyed?
								if curhull <= curattack:
							
									#and the damage can be removed
									attackers[defid][deftype]['hull_damage'] -= (attackers[defid][deftype]['hull'] - curhull)
									attackers[defid][deftype]['shield_damage'] -= (attackers[defid][deftype]['shields'] - curshields)
									
									#Add the cost to the defenders losses and debris
									results['attlost'] += attackers[defid][deftype]['cost']
									results['debrmet'] += attackers[defid][deftype]['debm']
									results['debrcry'] += attackers[defid][deftype]['debc']
							
									#was this ship damages?
									if curhull < attackers[defid][deftype]['hull']:
										attackers[defid][deftype]['damaged_h'] -= 1
								
									#We already know that shields were destroyed
									attackers[defid][deftype]['damaged_s'] -= 1	
													
									#Take 1 off the ship count
									attacker_total -= 1
									attackers[defid][deftype]['count'] -= 1
									fleet_totals[defid] -= 1
									if attackers[defid][deftype]['count'] == 0:
										del attackers[defid][deftype]
									if fleet_totals[defid] == 0:
										del attackers[defid]
										#attackers[defid] = {}
								
									#howabout rapidfire?
									stopfiring = True #we are ignoring it
								else:
									#ship not destroyed
									attackers[defid][deftype]['hull_damage'] += curattack
									if curhull == attackers[defid][deftype]['hull']:
										attackers[defid][deftype]['damaged_h'] += 1
									curhull -= curattack
							
									#chance of it exploding,
									exp_ch = 1 - (float(curhull) / attackers[defid][deftype]['hull'])
							
									#does it explode
									if random.random() <= exp_ch:
										#Well it survived the shot but blew up anyway
									
										#Add the cost to the defenders losses and debris
										results['attlost'] += attackers[defid][deftype]['cost']
										results['debrmet'] += attackers[defid][deftype]['debm']
										results['debrcry'] += attackers[defid][deftype]['debc']
								
										#remove from damage
										attackers[defid][deftype]['damaged_h'] -= 1
										attackers[defid][deftype]['damaged_s'] -= 1
							
										#and the damage can be removed
										attackers[defid][deftype]['hull_damage'] -= (definfo['hull'] - curhull)
										attackers[defid][deftype]['shield_damage'] -= (definfo['shields'] - curshields)
													
										#Take 1 off the ship count
										attacker_total -= 1
										attackers[defid][deftype]['count'] -= 1
										fleet_totals[defid] -= 1
										if attackers[defid][deftype]['count'] == 0:
											del attackers[defid][deftype]
										if fleet_totals[defid] == 0:
											del attackers[defid]
											#attackers[defid] = {}
						
										#how about rapidfire?
										stopfiring = True #we are ignoring it
							else:
								#shields not destroyed	
								attackers[defid][deftype]['shield_damage'] += curattack
								if curshields == definfo['shields']:
									attackers[defid][deftype]['damaged_s'] += 1
								
								#How much blocked?
								rounddata[round]['attblock'] += curattack
						
								#chance of it exploding,
								exp_ch = 1 - (float(curhull) / attackers[defid][deftype]['hull'])
							
								#does it explode
								if random.random() <= exp_ch:
									#Well it survived the shot but blew up anyway
									
									#Add the cost to the defenders losses and debris
									results['attlost'] += attackers[defid][deftype]['cost']
									results['debrmet'] += attackers[defid][deftype]['debm']
									results['debrcry'] += attackers[defid][deftype]['debc']
							
									#ship can be removes 
									attackers[defid][deftype]['count'] -= 1
							
									#remove from damage
									attackers[defid][deftype]['damaged_h'] -= 1
									attackers[defid][deftype]['damaged_s'] -= 1
							
									#and the damage can be removed
									attackers[defid][deftype]['hull_damage'] -= (definfo['hull'] - curhull)
									attackers[defid][deftype]['shield_damage'] -= (definfo['shields'] - curshields)
													
									#Take 1 off the ship count
									attacker_total -= 1
									attackers[defid][deftype]['count'] -= 1
									fleet_totals[defid] -= 1
									if attackers[defid][deftype]['count'] == 0:
										del attackers[defid][deftype]
									if fleet_totals[defid] == 0:
										del attackers[defid]
										#attackers[defid] = {}
							
									#How about rapidfire?
									stopfiring = True #we are ignoring it
		
		#Now for the attacker and defender fleets after the round
		rounddata[round]['attack_fleets'] = PHPSerialize().serialize(attackers)
		rounddata[round]['defend_fleets'] = PHPSerialize().serialize(defenders)

#Send back the data in php language
results['data'] = rounddata
print PHPSerialize().serialize(results)
