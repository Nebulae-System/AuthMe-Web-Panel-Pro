document.addEventListener("mousemove", parallax);
function parallax(e) {
  document.querySelectorAll(".minecraft-nickname").forEach(function(move){

    var obj = move.getBoundingClientRect();

    var Xdeg = (((obj.x + 64) - e.clientX) / 4) * -1;
    if (Xdeg > 40){
      Xdeg = 40;
    }else if(Xdeg < -40){
      Xdeg = -40;
    }

    var Ydeg = ((obj.y + 12) - e.clientY) / 2;
    if (Ydeg > 40){
      Ydeg = 40;
    }else if(Ydeg < -40){
      Ydeg = -40;
    }

    if(screen.width > 1180){
      move.style.transform = "translate(-50%, -50%)  perspective(400px) rotateY("+ Xdeg +"deg) rotateX("+ Ydeg + "deg)";
    }
  });
}