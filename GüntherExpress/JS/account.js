window.onscroll = function(event) {
    var doc = document.documentElement;
    var scrollPos = doc.scrollTop;

    console.log(scrollPos);
    document.getElementById("tmp123").style.top = -2*scrollPos+"px";
    if(scrollPos>350){
        doc.scrollTop=350;
    }
}