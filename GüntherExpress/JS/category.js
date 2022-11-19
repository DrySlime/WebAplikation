
window.onscroll = function(event) {
    var doc = document.documentElement;
    var scrollPos = doc.scrollTop;

    console.log(scrollPos);
    document.getElementById("tmp").style.top = -scrollPos+"px";
}
