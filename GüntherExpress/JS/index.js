
var opacity=0;
var intervalID=0;
var timeoutID=0;




function sliderFadeIn(num){
    var borderId='item_border_'+num;
    var leftButtonId='scroll_left_button_'+num;
    var rightButtonId='scroll_left_button_'+num;
    document.getElementById(borderId).onmouseenter=function (evt){
        console.log("enter");
        intervalID=setInterval(appear,20);
        
    }
}
function appear(){
    
    var div= document.getElementById("scroll_left_button_1");
    opacity=Number(window.getComputedStyle(div).getPropertyValue("opacity"));
    if(opacity<1){
        opacity+=0.1;
        
        div.style.opacity=opacity;
    }else{
        clearInterval(intervalID);
        
    }
    
}

function sliderFadeOut(num){
     var borderId='item_border_'+num;
     var leftButtonId='scroll_left_button_'+num;
     var rightButtonId='scroll_left_button_'+num;
    document.getElementById(borderId).onmouseleave=function (evt){
        
        intervalID=setInterval(hide,20);
        
        
    }
}

function hide(){
   
    var div= document.getElementById("scroll_left_button_1");
    opacity=Number(window.getComputedStyle(div).getPropertyValue("opacity"));
    if(opacity>0){
        opacity-=0.1;
        div.style.opacity=opacity;
    }else{
        clearInterval(intervalID);
        
    }
    
}
sliderFadeIn(1);
sliderFadeOut(1);

$(document).ready(function(){
    function scrollButtonFade(num){
        //wenn du die funktion verwendest vergiss nicht sicher zu gehen, dass diese id's auch in css vorhanden sind
        var borderId='#item_border_'+num;
        var leftButtonId='#scroll_left_button_'+num;
        var rightButtonId='#scroll_right_button_'+num;
        $(borderId).mouseenter(function (){
            
            $(leftButtonId).animate({opacity: '1'},"fast");
            $(rightButtonId).animate({opacity: '1'},"fast");
                    
        });
        $(borderId).mouseleave(function (){
            
            $(leftButtonId).animate({opacity: '0'});
            $(rightButtonId).animate({opacity: '0'});
                    
        });
    }



    //TODO :  Kategorie Titel ausserhalb des karussels platzieren

    var slider_position=0
    var karusselWidth= $(".item_border").width();
    
    var max123= $(".category_item_line").prop('scrollWidth');
    function moveSliderRight(num){
        
        var categoryLineClass=".category_item_line_"+num;
        var scrollLeftID="#scroll_left_button_"+num;
        var scrollRightID="#scroll_right_button_"+num;
        anzahlItems=Math.ceil(karusselWidth/328);
        var differenz=
        
        $(scrollRightID).on('click',function(){
            slider_position+=(anzahlItems-1)*328
            //  $(categoryLineClass).scrollLeft(slider_position+=(anzahlItems-1)*328);
            $(categoryLineClass).animate({scrollLeft:slider_position},500);
            if(slider_position>=max123){ 
                slider_position=max123-(anzahlItems-1)*328;
            }
        });
        
    }
    function moveSliderLeft(num){
        
        var categoryLineClass=".category_item_line_"+num;
        var scrollLeftID="#scroll_left_button_"+num;
        var scrollRightID="#scroll_right_button_"+num;
        anzahlItems=Math.ceil(karusselWidth/328);
        $(scrollLeftID).on('click',function(){
            slider_position-=(anzahlItems)*328
            // $(categoryLineClass).scrollLeft(slider_position-=(anzahlItems-1)*328);
            $(categoryLineClass).animate({scrollLeft:slider_position},500);
            if(slider_position<0){
                slider_position=0;
            }

        });
        
    }
    function sliderLogic(num){
        var anzahlItems=Math.ceil(karusselWidth/328);
        
        scrollButtonFade(num);
        moveSliderRight(num);
        moveSliderLeft(num);
        
        
    }
    sliderLogic(1);
    sliderLogic(2);
});

// Get the input field
var input = document.getElementById("searchbar");

// Execute a function when the user presses a key on the keyboard
input.addEventListener("keypress", function(event) {
  // If the user presses the "Enter" key on the keyboard
  if (event.key === "Enter") {
    var seachValue =document.getElementById("searchbar").value;
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.getElementById("seachbarConfirmID").click();
    console.log(seachValue);
  }
});
// <?php 
