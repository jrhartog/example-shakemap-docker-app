#	$Id: Makefile 2208 2008-07-03 20:21:27Z klin $	USGS

include ../../../../../../include/macros

FONT_FILES = BLOODY.TTF\
	     Bookworm.ttf\
	     aircondi.ttf

DEST = ../../../permanent/shake/tt_fonts

DEST_FILES = $(FONT_FILES:%=$(DEST)/%)

DIRS = 

all web install : $(DEST_FILES)

clean :

$(DEST)/% : %
	@echo "Installing $<"
	-@mkdir -p $(DEST)
	@$(INSTALL_644) $< $(DEST)
