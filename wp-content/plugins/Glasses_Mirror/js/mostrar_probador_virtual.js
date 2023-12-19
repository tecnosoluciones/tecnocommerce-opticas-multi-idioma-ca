jQuery( window ).load(function(){
    if(parseInt(jQuery(".elementor-widget-etheme_product_carousel").length) !== 0){
        probador_virtual_carrusel();
    }else if(parseInt(jQuery("div#featured .etheme-product-grid-item").length) !== 0){
        //probador_virtual_carrusel();
    }
});

function probador_virtual_carrusel(){
    id_product = [];
    jQuery(".elementor-widget-etheme_product_carousel a.button").each(function(e,k){
        id_product.push(jQuery(k).attr("data-product_id"));
    });

    if(parseInt(id_product.length) === 0){
        jQuery("div#featured .etheme-product-grid-item a.button").each(function(e,k){
            id_product.push(jQuery(k).attr("data-product_id"));
        });
    }

    jQuery.ajax({
        url: probador_virtual.ajaxUrl,
        type: 'post',
        data: {
            action: "validar_probador",
            id_product: id_product
        },
        async: true,
        success: function (resultado) {
            let datos = JSON.parse(resultado);
            if(parseInt(datos.length) !== 0){
                jQuery.each(datos, function (i, item) {
                    jQuery("body").append(item.elemento);
                    jQuery('a[data-product_id="'+i+'"]').before(item.boton);
                    jQuery('a[data-original-title="'+item.sku+'"]').click();
                });
                var script = document.createElement("script");
                script.addEventListener("load", function(event) {
                    console.log("Script terminó de cargarse y ejecutarse");
                });
                script.src = "https://opti.com.do/wp-content/plugins/Glasses_Mirror/js/app.js";
                script.async = true;
                document.getElementsByTagName("script")[0].parentNode.appendChild(script);

                var script2 = document.createElement("script");
                script2.addEventListener("load", function(event) {
                    console.log("Script terminó de cargarse y ejecutarse 2");
                });
                script2.src = "https://opti.com.do/wp-content/plugins/Glasses_Mirror/js/webcam_probador_virtual.js";
                script2.async = true;
                document.getElementsByTagName("script")[0].parentNode.appendChild(script2)
            }
        }
    });
}