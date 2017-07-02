function cambiarImagen(clase) {
        var elementos = document.getElementsByClassName(clase);
        for(var i = 0; i < elementos.length; i++) {
            elementos[i].src = "images/error.svg";
        }
}
$(document).ready(function() {
    var mover = true;
    $(".boton").click(function(evento) {
        if (mover) {
            $(".menu-cabecera-responsive").animate({
                top: "161px"
            });
            mover = false;
        } else {
            $(".menu-cabecera-responsive ").animate({
                top: "-1000px"
            });
            mover = true;
        }
    });
});