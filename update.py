#!/usr/bin/python

#Import the os commands
import os
import subprocess

#Update status
status = open('./redesigned/status','w')
status.write('NOTINSTALLED')
status.close()

#Update config
config = open('./redesigned/game/config1.php','r')
configold = config.read()
config.close()
config = open('./redesigned/game/config1.php','w')
config.write('<?php die("NOT SETUP"); ?>')
config.close()

#Let them know we are starting
print "Starting update ..."
print 

#Now update
r = subprocess.call(['svn','update'])

#Update status
status = open('./redesigned/status','w')
status.write('INSTALLED')
status.close()

#Update config
config = open('./redesigned/game/config1.php','w')
config.write(configold)
config.close()

#Its done
print " "
print "... Done"

#Wait to quit
t = raw_input("Press enter to exit.")
