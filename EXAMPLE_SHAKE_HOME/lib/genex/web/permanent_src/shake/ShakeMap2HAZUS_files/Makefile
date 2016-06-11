#	$Id: Makefile 2208 2008-07-03 20:21:27Z klin $	USGS

include ../../../../../../include/macros

JPG_FILES = filelist.xml\
	    image002.jpg\
	    image004.jpg\
	    image006.jpg\
	    image008.jpg\
	    image010.jpg\
	    image012.jpg\
	    image014.jpg\
	    image016.jpg\
	    image018.jpg\
	    image020.jpg\
	    image022.jpg\
	    image024.jpg\
	    image026.jpg\
	    image028.jpg\
	    image030.jpg\
	    image032.jpg\
	    image034.jpg\
	    image036.jpg\
	    image038.jpg

DEST = ../../../permanent/shake/ShakeMap2HAZUS_files

DEST_FILES = $(JPG_FILES:%=$(DEST)/%)

all web install : $(DEST_FILES)

clean :

$(DEST)/% : %
	@echo "Installing $<"
	-@mkdir -p $(DEST)
	@$(INSTALL_644) $< $(DEST)
