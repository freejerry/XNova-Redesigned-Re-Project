function setOpacity(obj, opacity) {
  opacity = (opacity == 100)?99.999:opacity;
  // IE/Win
  obj.style.filter = "alpha(opacity:"+opacity+")";
  // Safari<1.2, Konqueror
  obj.style.KHTMLOpacity = opacity/100;
  // Older Firefox
  obj.style.MozOpacity = opacity/100;
  // Safari 1.2, newer Firefox, Chrome and Maxthon, CSS3
  obj.style.opacity = opacity/100;
  return;
}

function fadeIn(obj,opacity) {
  if (document.getElementById) {
    if (opacity <= 100) {
      setOpacity(document.getElementById(obj), opacity);
      opacity += 5;
      window.setTimeout("fadeIn('"+obj+"',"+opacity+")", 50);
    }
  }
  return;
}

function fadeOut(obj,opacity,hide) {
  if (document.getElementById) {
    if (opacity > 0) {
      setOpacity(document.getElementById(obj), opacity);
      opacity -= 5;
      window.setTimeout("fadeOut('"+obj+"',"+opacity+","+hide+")", 50);
    }else if(hide){
      document.getElementById(obj).style.display = 'none';
    }
  }
  return;
}
