/*
This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 3 of the License, or any later version. See the GNU
Lesser General Public License for more details.
*/
/*
fadeUp:
istenen nesnenin renk geçiþi
*/
 function fadeUp (element,red,green,blue,r2,g2,b2) {
  if (element.fade) {
   clearTimeout(element.fade);
  }
  element.style.backgroundColor = "rgb("+red+","+green+","+blue+")";
  if (red == r2 && green == g2 && blue == b2) {
   return;
  }  
  var newred = red + Math.ceil((255 - red)/10);
  var newgreen = green + Math.ceil((255 - green)/10);
  var newblue = blue + Math.ceil((255 - blue)/10);
  var repeatFade = function() {
   fadeUp(element,newred,newgreen,newblue,r2,g2,b2)
  };
  element.fade = setTimeout(repeatFade,100);
 };