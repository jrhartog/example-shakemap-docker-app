#!/usr/bin/perl

# COMMENTS CGI SCRIPT

$date = scalar(localtime);
#open STDERR, ">>./log/comments.log";
#print STDERR "Running comments.pl, $date.\n";

@listkeys = qw(email application name inst phone text);
&parse_form_data (*form_data);
foreach $key (@listkeys) {
  $$key = $form_data{$key};
  $data =~ s/\s/ /g;
}
$app = uc $application;
$name =~ s/[^\w\s]//g;
$name =~ s/\n//g;

print "Content-type: text/html", "\n\n";

print "<html>\n";
print "  <head>\n";
print "  <title>Your feedback is appreciated</title>\n";
print "  </head>\n";
print "<BODY bgcolor='#ccffff'>\n";

if ($text =~ /a href\s*=/i or $text =~ /https*:/i) {
  print "Your comment has been rejected.  We do not accept comments "
    . "with HTML tags or links. Please reformat and try again.<p>";
  exit;
}

print "<CENTER><H1>Thanks! We got your input.</h1></center>\n";
print "Your comments have been saved and will be reviewed by the maintainer "
    . "of this page.<p>Please click on the <b>Back</b> to return.<p>";

my $recipient='<!-- tmpl_var name="comment-addr" -->';

my $mailer = '/usr/sbin/sendmail';

open (MAIL, "| $mailer -f $email $recipient") || die "Can't open mailer!\n";
print MAIL "From: $email\n";
print MAIL "To: $recipient\n";
print MAIL "Subject: $app comment from $name\n";
print MAIL "\n";
print MAIL "Date: $date\n";
print MAIL "Region: <!-- tmpl_var name="region" -->\n";
print MAIL "Sender's email,institution,phone: $email $inst $phone\n";
print MAIL "\n";
print MAIL "Comment: $text\n";
print MAIL "\n";
close (MAIL);

sub parse_form_data
{
    local (*FORM_DATA) = @_;

    local ( $request_method, $query_string, @key_value_pairs,
           $key_value, $key, $value);

    $request_method = $ENV{'REQUEST_METHOD'};

    if ($request_method eq "GET") {
        $query_string = $ENV{'QUERY_STRING'};
    } elsif ($request_method eq "POST") {
        read (STDIN, $query_string, $ENV{'CONTENT_LENGTH'});
    } else {
      print "<h1>ERROR</h1>Server uses unsupported method.\n";
      print "Assuming POST. Enter data:\n";
      @query_string = <STDIN>;
      $query_string = join '\n',@query_string;
    }
    @key_value_pairs = split (/&/, $query_string);

    foreach $key_value (@key_value_pairs) {
        ($key, $value) = split (/=/, $key_value);
        $value =~ tr/+/ /;
        $value =~ s/%([\dA-Fa-f][\dA-Fa-f])/pack ("C", hex ($1))/eg;
        if (defined($FORM_DATA{$key})) {
            $FORM_DATA{$key} = join (" ", $FORM_DATA{$key}, $value);
        } else {
            $FORM_DATA{$key} = $value;
	  }
    }
}

