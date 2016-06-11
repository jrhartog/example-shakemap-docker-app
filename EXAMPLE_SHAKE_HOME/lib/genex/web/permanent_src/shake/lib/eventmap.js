var gStaWin = null;

function station(anItem) {
  if (gStaWin == null || gStaWin.closed) {
    gStaWin = window.open("","stationlist",
                          "width=100,height=100,location=no," +
                          "scrollbars=yes,resizable=yes," +
                          "offscreenBuffering=true");
    gStaWin.moveTo(0,0);
  }
  gStaWin.resizeTo(750,250);
  gStaWin.document.location.href = "stationlist.html#" + anItem;
  gStaWin.focus();
}

function quake() {
  if (gStaWin == null || gStaWin.closed) {
    gStaWin = window.open("","stationlist",
                          "width=100,height=100,location=no," +
                          "scrollbars=yes,resizable=yes," +
                          "offscreenBuffering=true");
    gStaWin.moveTo(0,0);
  }
  gStaWin.resizeTo(750,250);
  gStaWin.document.location.href = "stationlist.html#quake";
  gStaWin.focus();
}

function cleanup() {
  if (gStaWin != null) {
    gStaWin.close();
  }
}
