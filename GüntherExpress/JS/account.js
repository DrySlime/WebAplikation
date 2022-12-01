window.onscroll = function(event) {
    var doc = document.documentElement;
    var scrollPos = doc.scrollTop;

    console.log(scrollPos);
    document.getElementById("tmp123").style.top = -1.5*scrollPos+"px";
    if(scrollPos>375){
        doc.scrollTop=375;
    }
}