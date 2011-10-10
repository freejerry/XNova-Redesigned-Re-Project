import types, string, re

"""
Unserialize class for the PHP serialization format.

@version v0.4 BETA
@author Scott Hurring; scott at hurring dot com
@copyright Copyright (c) 2005 Scott Hurring
@license http://opensource.org/licenses/gpl-license.php GNU Public License
$Id: PHPUnserialize.py,v 1.1 2006/01/08 21:53:19 shurring Exp $

Most recent version can be found at:
http://hurring.com/code/python/phpserialize/

Usage:
# Create an instance of the unserialize engine
u = PHPUnserialize()
# unserialize some string into python data
data = u.unserialize(serialized_string)

Please see README.txt for more information.
"""

class PHPUnserialize(object):
	"""
	Class to unserialize something from the PHP Serialize format.

	Usage:
	u = PHPUnserialize()
	data = u.unserialize(serialized_string)
	"""

	def __init__(self):
		pass

	def session_decode(self, data):
		"""Thanks to Ken Restivo for suggesting the addition
		of session_encode
		"""
		session = {}
		while len(data) > 0:
			m = re.match('^(\w+)\|', data)
			if m:
				key = m.group(1)
				offset = len(key)+1
				(dtype, dataoffset, value) = self._unserialize(data, offset)
				offset = offset + dataoffset
				data = data[offset:]
				session[key] = value
			else:
				# No more stuff to decode 
				return session
		
		return session
		
	def unserialize(self, data):
		return self._unserialize(data, 0)[2]

	def _unserialize(self, data, offset=0):
		"""
		Find the next token and unserialize it.
		Recurse on array.

		offset = raw offset from start of data
		
		return (type, offset, value)
		"""

		buf = []
		dtype = string.lower(data[offset:offset+1])

		#print "# dtype =", dtype

		# 't:' = 2 chars
		dataoffset = offset + 2
		typeconvert = lambda x : x
		chars = datalength = 0

 		# int => Integer
		if dtype == 'i':
			typeconvert = lambda x : int(x)
			(chars, readdata) = self.read_until(data, dataoffset, ';')
			# +1 for end semicolon
			dataoffset += chars + 1

 		# bool => Boolean
		elif dtype == 'b':
			typeconvert = lambda x : (int(x) == 1)
			(chars, readdata) = self.read_until(data, dataoffset, ';')
			# +1 for end semicolon
			dataoffset += chars + 1

		# double => Floating Point
		elif dtype == 'd':
			typeconvert = lambda x : float(x)
			(chars, readdata) = self.read_until(data, dataoffset, ';')
			# +1 for end semicolon
			dataoffset += chars + 1

		# n => None
		elif dtype == 'n':
			readdata = None

		# s => String
		elif dtype == 's':
			(chars, stringlength) = self.read_until(data, dataoffset, ':')
			# +2 for colons around length field
			dataoffset += chars + 2

			# +1 for start quote
			(chars, readdata) = self.read_chars(data, dataoffset+1, int(stringlength))
			# +2 for endquote semicolon
			dataoffset += chars + 2

			if chars != int(stringlength) != int(readdata):
				raise Exception("String length mismatch")

		# array => Dict
		# If you originally serialized a Tuple or List, it will
		# be unserialized as a Dict.  PHP doesn't have tuples or lists,
		# only arrays - so everything has to get converted into an array
		# when serializing and the original type of the array is lost
		elif dtype == 'a':
			readdata = {}

			# How many keys does this list have?
			(chars, keys) = self.read_until(data, dataoffset, ':')
			# +2 for colons around length field
			dataoffset += chars + 2

			# Loop through and fetch this number of key/value pairs
			for i in range(0, int(keys)):
				# Read the key
				(ktype, kchars, key) = self._unserialize(data, dataoffset)
				dataoffset += kchars
				#print "Key(%i) = (%s, %i, %s) %i" % (i, ktype, kchars, key, dataoffset)

				# Read value of the key
				(vtype, vchars, value) = self._unserialize(data, dataoffset)
				dataoffset += vchars
				#print "Value(%i) = (%s, %i, %s) %i" % (i, vtype, vchars, value, dataoffset)

				# Set the list element
				readdata[key] = value

				# +1 for end semicolon
			dataoffset += 1
			#chars = int(dataoffset) - start

		# I don't know how to unserialize this
		else:
			raise Exception("Unknown / Unhandled data type (%s)!" % dtype)


		return (dtype, dataoffset-offset, typeconvert(readdata))

	def read_until(self, data, offset, stopchar):
		"""
		Read from data[offset] until you encounter some char 'stopchar'.
		"""
		buf = []
		char = data[offset:offset+1]
		i = 2
		while char != stopchar:
			# Consumed all the characters and havent found ';'
			if i+offset > len(data):
				raise Exception("Invalid")
			buf.append(char)
			char = data[offset+(i-1):offset+i]
			i += 1

		# (chars_read, data)
		return (len(buf), "".join(buf))

	def read_chars(self, data, offset, length):
		"""
		Read 'length' number of chars from data[offset].
		"""
		buf = []
		# Account for the starting quote char
		#offset += 1
		for i in range(0, length):
			char = data[offset+(i-1):offset+i]
			buf.append(char)

		# (chars_read, data)
		return (len(buf), "".join(buf))


