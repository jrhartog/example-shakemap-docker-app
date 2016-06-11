#	$Id: Makefile 2208 2008-07-03 20:21:27Z klin $	USGS

include ../../../../../include/macros

FILES = about.html\
	captchaRoutines.php\
        comment_form.html\
        comment_form.php\
        disclaimer.html\
        links.html\
	ShakeMap2HAZUS.html\
	wp_tt.php\
	wp_tt_make.php

DEST = ../../permanent/shake

DEST_FILES = $(FILES:%=$(DEST)/%)

DIRS = cgi-bin\
       icons\
       lib\
       ShakeMap2HAZUS_files\
       tt_fonts

SUBDIR_CLEAN = $(patsubst %,%.clean,$(DIRS))
SUBDIR_WEB = $(patsubst %,%.web,$(DIRS))

.PHONY: all install web clean $(DIRS) $(SUBDIR_CLEAN) $(SUBDIR_WEB)

all install : $(DIRS)

web : $(SUBDIR_WEB)

clean : $(SUBDIR_CLEAN)

$(DIRS) :
	$(MAKE) -C $@

$(SUBDIR_WEB) :
	$(MAKE) -C $(@:.web=) web

$(SUBDIR_CLEAN) :
	$(MAKE) -C $(@:.clean=) clean

$(DEST)/% : % ../../../../../config/web.conf
	@echo "Installing $<"
	-@mkdir -p $(DEST)
	@../../../../../bin/web -file $< -srcdir . -dstdir $(DEST)

