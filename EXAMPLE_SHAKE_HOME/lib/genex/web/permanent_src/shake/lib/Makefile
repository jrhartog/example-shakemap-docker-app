#	$Id: Makefile 2208 2008-07-03 20:21:27Z klin $

include ../../../../../../include/macros

FILES = eventmap.css\
	eventmap.js\
	style.css

DEST = ../../../permanent/shake/lib

DEST_FILES = $(FILES:%=$(DEST)/%)

all web install : $(DEST_FILES)

clean :

$(DEST)/% : %
	@echo "Installing $<"
	-@mkdir -p $(DEST)
	@$(INSTALL_644) $< $(DEST)
