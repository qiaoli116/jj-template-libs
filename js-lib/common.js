/** function: getBrowserTypeVersion
 *  description: this function will return the type of browser and its version
 *               browser types are in a list of: Opera, Chrome, Safari, Firefox, Msie, Trident, IE, Edge
 */
function getBrowserTypeVersion(){
    var ua= navigator.userAgent, tem,
    M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if(/trident/i.test(M[1])){
        tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
        return 'IE/'+(tem[1] || '');
    }
    if(M[1]=== 'Chrome'){
        tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
        if(tem!= null) return tem.slice(1).join('/').replace('OPR', 'Opera');
    }
    M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
    return M.join('/');
}

/** function: getBrowserTypeVersion
 *  argument:
 *      t: type of browser
 *  description: this function will return the url of different browsers.
 *               supported browser: Chrome, Firefox, IE, Edge
 *               for unsupported browser, this function will return false
 *                   > ie / firefox / edge: about:home
 *                   > chrome: chrome://newtab
 *  note: chrome does not allow accessing "chrome://newtab" from within js or html
 */
function getBrowserHomePageUrl(t){
    var type = t.toUpperCase();
    var url;
    switch(type){
        case "CHROME":
            url = "chrome:newTab";
            break;
        case "IE":
        case "FIREFOX":
        case "EDGE":
            url = "about:home";
            break;
        default:
            url = false;
    }
    return url;
}


Number.prototype.pad = function(size) {
    var s = String(this);
    while (s.length < (size || 2)) {s = "0" + s;}
    return s;
}


