#	$Id: Makefile 2208 2008-07-03 20:21:27Z klin $

include ../../../../../../include/macros

GIF_FILES = scale.jpg\
            scale_c.jpg\
            USGS_CIT_CGS.gif\
	    WG_study_region.jpg\
	    USGSlogo.png\
	    shakemap.png 

DEST = ../../../permanent/shake/icons

DEST_FILES = $(GIF_FILES:%=$(DEST)/%)

DIRS = header

all web install : $(DEST_FILES)
	$(MAKE) -C header $@

clean :
	$(MAKE) -C header $@

$(DEST)/% : %
	@echo "Installing $<"
	-@mkdir -p $(DEST)
	@$(INSTALL_644) $< $(DEST)
