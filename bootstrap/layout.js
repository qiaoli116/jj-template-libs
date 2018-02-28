// js break point handler for responsive design
// Align with bootstrap layout setting. Tested with bootstrap 4.0
// Version 1.0
// Auther: Qiao Li
// Latest update on: 02/28/2018
// How to use:
//  1) include "layout.js" in html
//  2) define 5 style functions for callbacks
//          function xl (){console.log("func xl")}
//          function lg (){console.log("func lg")}
//          function md (){console.log("func md")}
//          function sm (){console.log("func sm")}
//          function xs (){console.log("func xs")}
//  3) in window.ready callback, create a instance of class btLayoutJS and invoke the toGo() Method. 
//          var x = new btLayoutJS(xl, lg, md, sm, xs);
//          x.toGo();
//  4) resize the web page window to test.
//  Note: the code is coded in jQuery style, because this class is designed for bootstrap layout and jQuery is a default lib for bootstrap. avoid using this code when jQuery is not included.
class btLayoutJS {
    constructor (xl, lg, md, sm, xs){
        this.styleXl = xl;
        this.styleLg = lg;
        this.styleMd = md;
        this.styleSm = sm;
        this.styleDefault = xs;
    }
    // function toGo: launch the main function
    toGo (){
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
                    obj.mBootstrapStyle(s1);
                }

                // update width
                s0 = s1;
            };
        }
        $(window).resize(resizeHandler(this));
    }
    // function mBootstrapDeviceSize: determine the size of current window
    mBootstrapDeviceSize(w){
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
    }
    // function mBootstrapStyle: call the style call backs to style the document
    mBootstrapStyle (bp){
        switch (bp) {
            case "xl":
                // 1200px <= width < infinity
                console.log("xl");
                // style your document here ...
                if(typeof this.styleXl === "function") {
                    this.styleXl();
                }
                break;
            case "lg":
                // 992px <= width < 1200px
                console.log("lg");
                // style your document here ...
                if(typeof this.styleLg === "function") {
                    this.styleLg();
                }
                break;
            case "md":
                // 768px <= width < 992px
                console.log("md");
                // style your document here ...
                if(typeof this.styleMd === "function") {
                    this.styleMd();
                }
                break;
            case "sm":
                // 576px <= width < 768px
                console.log("sm");
                // style your document here ...
                if(typeof this.styleSm === "function") {
                    this.styleSm();
                }
                break;
            default:
                // case "xs"
                // 0 <= width < 576px
                console.log("xs (default)");
                // style your document here ...
                if(typeof this.styleDefault === "function") {
                    this.styleDefault();
                }
                break;

        }
    }
}