import types, string

"""
Serialize class for the PHP serialization format.

@version v0.4 BETA
@author Scott Hurring; scott at hurring dot com
@copyright Copyright (c) 2005 Scott Hurring
@license http://opensource.org/licenses/gpl-license.php GNU Public License
$Id: PHPSerialize.py,v 1.1 2006/01/08 21:53:19 shurring Exp $

Most recent version can be found at:
http://hurring.com/code/python/phpserialize/

Usage:
# Create an instance of the serialize engine
s = PHPSerialize()
# serialize some python data into a string
serialized_string = s.serialize(string)
# encode a session list (php's session_encode) 
serialized_string = s.session_encode(list)

See README.txt for more information.
"""

class PHPSerialize(object):
	"""
	Class to serialize data using the PHP Serialize format.

	Usage:
	serialized_string = PHPSerialize().serialize(data)
	serialized_string = PHPSerialize().session_encode(list)
	"""
	
	def __init__(self):
		pass

	def session_encode(self, session):
		"""Thanks to Ken Restivo for suggesting the addition
		of session_encode
		"""
		out = ""
		for (k,v) in session.items():
			out = out + "%s|%s" % (k, self.serialize(v))
		return out
		
	def serialize(self, data):
		return self.serialize_value(data)

	def is_int(self, data):
		"""
		Determine if a string var looks like an integer
		TODO: Make this do what PHP does, instead of a hack
		"""
		try: 
			int(data)
			return True
		except:
			return False
		
	def serialize_key(self, data):
		"""
		Serialize a key, which follows different rules than when 
		serializing values.  Many thanks to Todd DeLuca for pointing 
		out that keys are serialized differently than values!
		
		From http://us2.php.net/manual/en/language.types.array.php
		A key may be either an integer or a string. 
		If a key is the standard representation of an integer, it will be
		interpreted as such (i.e. "8" will be interpreted as int 8,
		while "08" will be interpreted as "08"). 
		Floats in key are truncated to integer. 
		"""
		# Integer, Long, Float, Boolean => integer
		if type(data) is types.IntType or type(data) is types.LongType \
		or type(data) is types.FloatType or type(data) is types.BooleanType:
			return "i:%s;" % int(data)
			
		# String => string or String => int (if string looks like int)
		elif type(data) is types.StringType:
			if self.is_int(data):
				return "i:%s;" % int(data)
			else:
				return "s:%i:\"%s\";" % (len(data),  data);
		
		# None / NULL => empty string
		elif type(data) is types.NoneType:
			return "s:0:\"\";"
		
		# I dont know how to serialize this
		else:
			raise Exception("Unknown / Unhandled key  type (%s)!" % type(data))


	def serialize_value(self, data):
		"""
		Serialize a value.
		"""

		# Integer => integer
		if type(data) is types.IntType:
			return "i:%s;" % data

		# Float, Long => double
		elif type(data) is types.FloatType or type(data) is types.LongType:
			return "d:%s;" % data

		# String => string or String => int (if string looks like int)
		# Thanks to Todd DeLuca for noticing that PHP strings that
		# look like integers are serialized as ints by PHP 
		elif type(data) is types.StringType:
			if self.is_int(data):
				return "i:%s;" % int(data)
			else:
				return "s:%i:\"%s\";" % (len(data), data);

		# None / NULL
		elif type(data) is types.NoneType:
			return "N;";

		# Tuple and List => array
		# The 'a' array type is the only kind of list supported by PHP.
		# array keys are automagically numbered up from 0
		elif type(data) is types.ListType or type(data) is types.TupleType:
			i = 0
			out = []
			# All arrays must have keys
			for k in data:
				out.append(self.serialize_key(i))
				out.append(self.serialize_value(k))
				i += 1
			return "a:%i:{%s}" % (len(data), "".join(out))

		# Dict => array
		# Dict is the Python analogy of a PHP array
		elif type(data) is types.DictType:
			out = []
			for k in data:
				out.append(self.serialize_key(k))
				out.append(self.serialize_value(data[k]))
			return "a:%i:{%s}" % (len(data), "".join(out))

		# Boolean => bool
		elif type(data) is types.BooleanType:
			return "b:%i;" % (data == 1)

		# I dont know how to serialize this
		else:
			raise Exception("Unknown / Unhandled data type (%s)!" % type(data))
