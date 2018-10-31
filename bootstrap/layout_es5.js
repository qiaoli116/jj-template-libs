// js break point handler for responsive design
// Align with bootstrap layout setting. Tested with bootstrap 4.0
// Version 1.0
// Auther: Qiao Li
// Latest update on: 02/28/2018
// This version is written in "function" instead of "class" to support ES5
// How to use:
//  1) include "layout.js" in html
//  2) define 5 style functions for callbacks
//          function xl (s0){console.log("func xl");}
//          function lg (s0){console.log("func lg");}
//          function md (s0){console.log("func md");}
//          function sm (s0){console.log("func sm");}
//          function xs (s0){console.log("func xs");}
//  3) in window.ready callback, create a instance of class btLayoutJS and invoke the toGo() Method. 
//          var x = new btLayoutJS(xl, lg, md, sm, xs);
//          x.toGo();
//  4) resize the web page window to test.
//  Note: the code is coded in jQuery style, because this class is designed for bootstrap layout and jQuery is a default lib for bootstrap. avoid using this code when jQuery is not included.
/*
var supportsES6 = function() {
    try {
      new Function("(a = 0) => a");
      return true;
    }
    catch (err) {
      return false;
    }
}();
*/

function btLayoutJS (xl, lg, md, sm, xs) {
    this.styleXl = xl;
    this.styleLg = lg;
    this.styleMd = md;
    this.styleSm = sm;
    this.styleDefault = xs;
};

// function toGo: launch the main function
btLayoutJS.prototype.toGo = function (){
    var w0 = window.innerWidth;
    var s0 = this.mBootstrapDeviceSize(w0);
    this.mBootstrapStyle(s0);

    // on resize handler
    function resizeHandler (obj) {
        return function (){
            // new width
            var w1 = window.innerWidth;
            var s1 = obj.mBootstrapDeviceSize(w1);

            if(s1 !== s0){
                // new setting
                obj.mBootstrapStyle(s1, s0);
            }

            // update width
            s0 = s1;
        };
    }
    $(window).resize(resizeHandler(this));
};

// function mBootstrapDeviceSize: determine the size of current window
btLayoutJS.prototype.mBootstrapDeviceSize = function(w) {
    var s;
    if(w>=1200){
        s = "xl";
    }else if(w>=992 && w<1200){
        s = "lg";
    }else if(w>=768 && w<992){
        s = "md";
    }else if(w>=576 && w<768) {
        s = "sm";
    }else{
        s = "xs";
    }
    return s;
};

btLayoutJS.prototype.getSize = function() {
    return this.mBootstrapDeviceSize(window.innerWidth);
};
// function mBootstrapStyle: call the style call backs to style the document
btLayoutJS.prototype.mBootstrapStyle = function(s1, s0){
    switch (s1) {
        case "xl":
            // 1200px <= width < infinity

            // style your document here ...
            if(typeof this.styleXl === "function") {
                this.styleXl(s0);
            }
            break;
        case "lg":
            // 992px <= width < 1200px

            // style your document here ...
            if(typeof this.styleLg === "function") {
                this.styleLg(s0);
            }
            break;
        case "md":
            // 768px <= width < 992px

            // style your document here ...
            if(typeof this.styleMd === "function") {
                this.styleMd(s0);
            }
            break;
        case "sm":
            // 576px <= width < 768px

            // style your document here ...
            if(typeof this.styleSm === "function") {
                this.styleSm(s0);
            }
            break;
        default:
            // case "xs"
            // 0 <= width < 576px

            // style your document here ...
            if(typeof this.styleDefault === "function") {
                this.styleDefault(s0);
            }
            break;
    }
}

