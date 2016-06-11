#	$Id: Makefile 2208 2008-07-03 20:21:27Z klin $	USGS

SRC_DIRS = config\
	   template/shake

WSRC_DIRS = permanent_src/shake

SUBDIR_CLEAN = $(patsubst %,%.clean,$(SRC_DIRS) $(WSRC_DIRS))
SUBDIR_WEB = $(patsubst %,%.web,$(WSRC_DIRS))

.PHONY: all install clean web $(SRC_DIRS) $(SUBDIR_CLEAN) $(SUBDIR_WEB)

all install : $(WSRC_DIRS)

web : $(SUBDIR_WEB)

clean : $(SUBDIR_CLEAN)
	-@rm -rf permanent

$(WSRC_DIRS) :
	$(MAKE) -C $@

$(SUBDIR_WEB) :
	$(MAKE) -C $(@:.web=) web

$(SUBDIR_CLEAN) :
	$(MAKE) -C $(@:.clean=) clean

