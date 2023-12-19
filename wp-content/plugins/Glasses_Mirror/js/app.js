jQuery(document).ready(function (jQuery) {
    let body_t = jQuery('body');
    var screenwidth = jQuery(window).width();
    if ((screenwidth < 780)) {
    }
    else {
        jQuery('#fordrag').draggable();
    }
    if (screenwidth < 780) {
        jQuery(".sizeplus").hide();
        jQuery(".sizeminus").hide();
        jQuery('#fullall').css("width", "95%").css("position", "absolute");
    }

    if (screenwidth > 780) {
        jQuery('#fullall').css("width", "55%");
    }

    var newWindowWidth = jQuery(window).width();
    var mainWellWidth = jQuery("#fullall").width();
    // create an integer based left_offset number
    var left_offset = parseInt((newWindowWidth - mainWellWidth) / 2);
    if (left_offset < 0) {
        left_offset = 0;
    }

    jQuery("#fullall").css("margin-left", left_offset);

    jQuery('#imagesContainer').draggable( {
        drag: function () {
            var myMarginTop = parseInt(jQuery('#imagesContainer').css('Top'), 10);
            var tshirtsheight = parseInt(jQuery('#Backgroundimg').css('height'), 10);
            var tot = myMarginTop * 100 / tshirtsheight;
            jQuery(".sizkoko").text(tot); // update text on slider
            var myleft = parseInt(jQuery('#imagesContainer').css('left'), 10);
            var tshirtwidht = parseInt(jQuery('#Backgroundimg').css('width'), 10);
            var scrapleft = myleft * 100 / tshirtwidht;
            jQuery(".sKRAPPYkoko").text(scrapleft);
        }
    });

    jQuery(document).on('click', '#scrapy', function (e) {
        loader = '<div id="loader_probador">\n' +
            '                <div class="spinner">\n' +
            '                    <div class="loader l1"></div>\n' +
            '                    <div class="loader l2"></div>\n' +
            '                </div>\n' +
            '            </div>';

        jQuery("body").append(loader);
        jQuery('#fullall').show();
        var gottentitle = jQuery(this).attr("value");
        var srcgotten = jQuery(".glasses img[alt='" + gottentitle + "']").attr('src');

        jQuery.ajax({
            url: probador_virtual.ajaxUrl,
            type: 'post',
            data: {
                action: "get_probador",
                sku: gottentitle
            },
            dataType: 'json',
            success: function (resultado) {
                srcgotten = resultado;
                jQuery('#imagesContainer').find('img').attr('src', srcgotten);
                jQuery(".navbardown").hide();
                jQuery(".navbar21").show();
                setTimeout(function () {
                    jQuery('.widget-content').show('blind', {}, 100);
                    jQuery('.imagesx').css('top', '-1px');
                }, 100);

                jQuery('html, body').animate({
                    scrollTop: jQuery("#fullall").offset().top
                }, 1000);
                jQuery("#loader_probador").remove();
            }
        });
    });
    jQuery(document).on('click','.closeplug', function () {
        jQuery('#fullall').hide();
    });

    jQuery(document).on('click','.sizeplus', function () {
        jQuery('#fullall').css("width", "65%");
        jQuery('#imagesContainer').css("width", "383px");
        jQuery('#imagesContainer').css("top", "30%");
        jQuery(".sizeminus").show();
        jQuery(this).hide();
        setTimeout(function () {
            var tshirtsheight = parseInt(jQuery('#Backgroundimg').css('height'), 10);
            var perc = jQuery(".sizkoko").text();
            var scleft = jQuery(".sKRAPPYkoko").text();
            jQuery('#imagesContainer').css("top", perc + "%").css("left", scleft + "%");
        }, 100);
    });

    jQuery(document).on('click','.sizeminus', function () {
        if (screenwidth > 780) {
            jQuery('#fullall').css("width", "55%");
        } else {
            jQuery('#fullall').css("width", "");

        }
        jQuery('#imagesContainer').css("top", "30%");
        jQuery('#imagesContainer').find(".imagesx").css("width", "44%");
        jQuery('#imagesContainer').css("width", "233px");
        jQuery('#fordrag').css("width", "");
        jQuery(".sizeplus").show();
        jQuery(this).hide();
        setTimeout(function () {
            var tshirtsheight = parseInt(jQuery('#Backgroundimg').css('height'), 10);
            var perc = jQuery(".sizkoko").text();
            var scleft = jQuery(".sKRAPPYkoko").text();
            jQuery('#imagesContainer').css("top", perc + "%").css("left", scleft + "%");
        }, 100);
    });

    jQuery(document).on('click','.navbar21', function () {
        jQuery(this).hide();
        jQuery(".navbardown").show();
        setTimeout(function () {
            jQuery('.widget-content').hide('blind', {}, 100)
        }, 0);
    });
    jQuery(document).on('click','.navbardown', function () {
        jQuery(this).hide();
        jQuery(".navbar21").show();
        setTimeout(function () {
            jQuery('.widget-content').show('blind', {}, 100)
        }, 0);
    });

    jQuery("#Backgroundimg").load(function () {
        var srcg = jQuery('#Backgroundimg').attr('src');
        jQuery('#srcimg').html(srcg);
    });
    var gottentitle = jQuery('#varpass').text();
    //font size using Slider based on jquery UI sliders
    jQuery("#slidere").slider({
        range: "max", // set range Type
        min: 0, // set a minimum value
        max: 100, //a max value
        value: 50, // default value
        slide: function (event, ui) { // event onslider
            jQuery(".sizee").text(ui.value + "%"); // update text on slider
            jQuery('.imagesx').css("width", ui.value + "%"); // apply value on text (font-size) using css function (jquery)
        }
    });

    jQuery("#sliderg").slider({
        range: "max", // set range Type
        min: 0, // set a minimum value
        max: 360, //a max value
        value: 0, // default value
        slide: function (event, ui) { // event onslider
            jQuery(".sizeg").text(ui.value + "°"); // update text on slider
            jQuery("#rotation").text(ui.value + "deg"); // update text on slider
            jQuery('.imagesx').css({
                '-webkit-transform': 'rotate(' + ui.value + 'deg)',
                '-moz-transform': 'rotate(' + ui.value + 'deg)',
                '-ms-transform': 'rotate(' + ui.value + 'deg)',
                'transform': 'rotate(' + ui.value + 'deg)'
            });
        }
    });
    // function to get image preview on the template we don't need to upload it on the server using this function
    var countImg = 1;
    function readURL(input) {
        var src = jQuery(this).find('img').attr('src');
        if (input.files && input.files[0]) { // if there is a file from input
            var reader = new FileReader(); // read file
            reader.onload = function (e) { // on load
                jQuery('#Backgroundimg').attr('src', e.target.result);
                countImg++;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    // load imagesx

    jQuery(document).on('change','#imgInp', function () {
        readURL(this); // call our function readURL
    });
    //change Guitar template
    jQuery(document).on('click','.tshirts a', function () {
        var src = jQuery(this).find('img').attr('src');
        jQuery('#Backgroundimg').attr('src', src);
        return false;
    });
    //change glasses

    jQuery(document).on('click','ul.glasses a', function () {
        var src = jQuery(this).find('img').attr('src');
        jQuery('#imagesContainer img').attr('src', src);
        /*   jQuery('ul.glasses a img').removeClass('active');
           jQuery(this).find('img').addClass('active');*/
        return false;
    });
    // apply style on file's input
    jQuery('#imgInp').customFileInput({
        // put button 'browse' on right
        button_position: 'right'
    });
    // Printer call
    // tooltip
    jQuery('.font-tooltip').tooltip();
    jQuery('.tooltip-show').tooltip({
        selector: "a[data-toggle=tooltip]"
    });
    var gottentitle = jQuery('#varpass').text();
    jQuery('.product-titl').text(gottentitle);
    var urlxo = jQuery('#varlink').text();
    if (gottentitle == "") {
        var srcgotten = jQuery('.imgpngulr').text();
        jQuery('#imagesContainer').find('.imagesx').remove();
        jQuery('#imagesContainer').prepend("<div class='imagesx'><img src=" + srcgotten + " ></div>");
        jQuery('#imagesContainer').draggable();
        //    jQuery('#imagesContainer').find('.imagesx').draggable();
        return false;
    } else {
        var srcgotten = jQuery("img[alt='" + gottentitle + "']").attr('src');
        jQuery('#imagesContainer').find('.imagesx').remove();
        jQuery('#imagesContainer').prepend("<div class='imagesx' style='z-index:999" + countImg + "; mix-blend-mode: multiply; mix-blend-mode: multiply; '><img src=" + srcgotten + " ></div>");
        jQuery('#imagesContainer').draggable();
        var ok = gottentitle;
        // Create our XMLHttpRequest object
        var hr = new XMLHttpRequest();
        var hr1 = new XMLHttpRequest();
        var hr2 = new XMLHttpRequest();
        var hr3 = new XMLHttpRequest();
        // Create some variables we need to send to our PHP file
        var url = urlxo + "/Myproduct_links.php";
        var url1 = urlxo + "/Myproduct_description.php";
        var url2 = urlxo + "/Myproduct_price.php";
        var url3 = urlxo + "/Woocommerce_file.php";
        var fn = ok;
        var ln = "";
        var vars = "firstname=" + fn + "&lastname=" + ln;
        hr.open("POST", url, true);
        hr1.open("POST", url1, true);
        hr2.open("POST", url2, true);
        hr3.open("POST", url3, true);
        // Set content type header information for sending url encoded variables in the request
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        // Access the onreadystatechange event for the XMLHttpRequest object
        hr.onreadystatechange = function () {
            if (hr.readyState == 4 && hr.status == 200) {
                var return_data = hr.responseText;
                document.getElementById("status").innerHTML = return_data;
            }
        };
        hr1.onreadystatechange = function () {
            if (hr1.readyState == 4 && hr1.status == 200) {
                var return_data = hr1.responseText;
                document.getElementById("product-description").innerHTML = return_data;
            }
        };
        hr2.onreadystatechange = function () {
            if (hr2.readyState == 4 && hr2.status == 200) {
                var return_data = hr2.responseText;
                document.getElementById("product-price").innerHTML = return_data;
            }
        };
        hr3.onreadystatechange = function () {
            if (hr3.readyState == 4 && hr3.status == 200) {
                var return_data = hr3.responseText;
                document.getElementById("productname").innerHTML = return_data;
            }
        };
        // Send the data to PHP now... and wait for response to update the dressstatus div
        hr.send(vars); // Actually execute the request
        document.getElementById("status").innerHTML = "";
        // Send the data to PHP now... and wait for response to update the dressstatus div
        hr1.send(vars); // Actually execute the request
        document.getElementById("product-description").innerHTML = "";
        // Send the data to PHP now... and wait for response to update the dressstatus div
        hr2.send(vars); // Actually execute the request
        document.getElementById("product-price").innerHTML = "";
        // Send the data to PHP now... and wait for response to update the dressstatus div
        hr3.send(vars); // Actually execute the request
        document.getElementById("productname").innerHTML = "";
    }
    //Set container of image
    setTimeout(function () {
        if (jQuery('#Backgroundimg').length > 0) {
            var h = jQuery('#printable').height();
            var w = jQuery('#printable').width();
            jQuery('.imageContainerLimit').css({
                'width': w,
                'height': h
            });
        }
    }, 2000);
});