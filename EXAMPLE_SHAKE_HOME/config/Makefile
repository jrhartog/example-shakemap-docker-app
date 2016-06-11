#	$Id: Makefile 739 2013-12-19 21:11:03Z cbworden $	USGS

all install : 
	-@mkdir -p ../../config
	-@mkdir -p ../../config/zone
	-@mkdir -p ../../config/zone2
	( cd ../../config; ../bin/configconfig2 -shake)
	( cd ../../config; ../bin/configconfig2 -zone)

clean:
