#	$Id: Makefile 2208 2008-07-03 20:21:27Z klin $

include ../../../../../../../include/macros

GIF_FILES = arrow-loc-yellow.gif\
	    tab-begin-bgray.gif\
	    tab-begin-lav.gif\
	    tab-end-bgray.gif\
	    tab-end-lav.gif\
	    tab-left-lav-bgray.gif\
	    tab-right-bgray-lav.gif\
	    tabs-lav.gif

DEST = ../../../../permanent/shake/icons/header

DEST_FILES = $(GIF_FILES:%=$(DEST)/%)

all web install : $(DEST_FILES)

clean :

$(DEST)/% : %
	@echo "Installing $<"
	-@mkdir -p $(DEST)
	@$(INSTALL_644) $< $(DEST)
