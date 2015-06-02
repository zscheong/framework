function CreateUL(d, n) {
    var ret = '<ul class="' + n + '"' + ">";
    jQuery.each(d, function(i,v) {
        var caption = v.caption || "";
        var link = v.link || "";
        var lclass = v.class || "";
 
        ret += "<li"
        if(lclass !== "") { ret += ' class="' + lclass + '"'; }
        ret += "><a";
        if(link !== "") { ret += ' href="' + link + '"'; }
        ret += ">" + caption + "</a>";

        var data = v.data || "";
        if(data !== "") {
            ret += CreateUL(data, "");
        }
        ret += "</li>"
    });
    ret += "</ul>";
    return ret;
}