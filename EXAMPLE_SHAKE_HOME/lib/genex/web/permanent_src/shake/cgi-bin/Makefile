#	$Id: Makefile 2208 2008-07-03 20:21:27Z klin $

include ../../../../../../include/macros

CGI_FILES = comments.pl

DEST = ../../../permanent/shake/cgi-bin

DEST_FILES = $(CGI_FILES:%=$(DEST)/%)

all web install : $(DEST_FILES)

clean :

$(DEST)/% : % ../../../../../../config/web.conf
	@echo "Installing $<"
	-@mkdir -p $(DEST)
	@../../../../../../bin/web -file $< -srcdir . -dstdir $(DEST)
	@chmod +x $(DEST)/$<
