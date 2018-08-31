$(function() {
    // bs layout
    var x = new btLayoutJS(xl, lg, md, sm, xs);

    // services part
    $(".m-sec-service-details .m-item").hide();
    $(".m-sec-service-details .m-item:first-of-type").show();
    $(".m-sec-service-details").removeClass("d-none");
    // set the initial height of the details div
    $(".m-sec-service-details").height($(".m-sec-service-details .m-item:first-of-type").outerHeight(true));
    $(".m-sec-services .m-item").hover(function(){
        var currentSize = $(".m-sec-service-details").attr("data-size");
        var lSizes = ["lg", "xl"];

        target = $(this).attr("m-service-name");
        $(".m-sec-service-details .m-item").hide();
        $(".m-sec-service-details .m-item[m-target='"+target+"']").show();
        if (lSizes.includes(currentSize)) {
            h = $(".m-sec-service-details .m-item[m-target='"+target+"']").outerHeight(true);
            $(".m-sec-service-details").height(h);
        } else {
            $(".m-sec-service-details").css("height", "");
        }
        
    });
    $(".m-sec-services .m-item").click(function(){
        var currentSize = $(".m-sec-service-details").attr("data-size");
        var sSizes = ["xs", "sm", "md"];
        if (sSizes.includes(currentSize)) {
            // we are in small size
            $(".m-sec-service-details").show();
            $(".m-sec-service-details").addClass("d-flex");
            $("body").addClass("body-disable");
            blurEE(true, ".m-sec-service-details");
        }

    });
    $(".m-sec-service-details").click(function(){

        var currentSize = $(".m-sec-service-details").attr("data-size");
        var sSizes = ["xs", "sm", "md"];

        if (sSizes.includes(currentSize)) {
            // we are in small size
            $(".m-sec-service-details").removeClass("d-flex");
            $(".m-sec-service-details").hide();
            $("body").removeClass("body-disable");
            blurEE(false);
            
        }
    });
    $(".m-sec-service-details .m-item").click(function(e){
        e.stopPropagation();
    });

    // team part
    $(".m-sec-about-team .m-team .m-item").hover(
        function (){
            $(this).siblings().removeClass("d-flex");
            $(this).siblings().hide();
        },
        function () {
            $(this).siblings().addClass("d-flex");
            $(this).siblings().show();

        });
});


function xl (){
    resetServiceDetails();
}
function lg (){
    resetServiceDetails();
}
function md (){
    resetServiceDetails();
}
function sm (){
    resetServiceDetails();
}
function xs (){
    resetServiceDetails();
}

function resetServiceDetails () {
    var sSizes = ["xs", "sm", "md"];
    var lSizes = ["lg", "xl"];
    var newSize = new btLayoutJS();
    newSize = newSize.getSize();
    var that = $(".m-sec-service-details")[0];
    var currentSize = $(that).attr("data-size");
    if (currentSize === undefined) {
        if(sSizes.includes(newSize)) {
            $(that).hide();
            $(".m-sec-service-details").css("height", "");
        } else {
            $(that).show();      
        }
        $(that).removeClass("d-flex");
    } else {
        if(sSizes.includes(currentSize) && sSizes.includes(newSize)) {
            console.log("small to small");
        } else if (sSizes.includes(currentSize) && lSizes.includes(newSize)) {
            console.log("small to large");
            // small size to large size
            $(that).show();
            // set the initial height of the details div
            h = $(".m-sec-service-details .m-item[m-target='"+target+"']").outerHeight(true);
            $(".m-sec-service-details").height(h);
        } else if (lSizes.includes(currentSize) && sSizes.includes(newSize)) {
            console.log("large to small");
            $(that).hide();
            $(that).removeClass("d-flex");
            $(".m-sec-service-details").css("height", "");
        } else if (lSizes.includes(currentSize) && lSizes.includes(newSize)) {
            console.log("large to large");
        }
    }
    $("body").removeClass("body-disable");
    blurEE(false);
    $(that).attr("data-size", newSize);

}

function blurEE(flag, sel = "") {
    if (!flag) {
        $("body > *").removeClass("blur");
    } else {
        $("body > *").addClass("blur");
        $(sel).removeClass("blur");
    }

}