jQuery( window ).load(function() {
    jQuery(".woof_container_inner_shape ul li").each(function () {
        imagen = opticom.siluetas[parseInt(jQuery(this).attr("class").split("_")[2])];
        jQuery(this).children("label").prepend(imagen);
    });

    jQuery(".woof_container_inner_siluetas ul li").each(function () {
        imagen = opticom.siluetas[parseInt(jQuery(this).attr("class").split("_")[2])];
        jQuery(this).children("label").prepend(imagen);
    });
});