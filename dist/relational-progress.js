/* jQuery dependant - relational progress bar */
 
$(document).ready(() => {
  //add a listener for scroll
  $(window).scroll(() => {

    //get article's height
    let docHeight = $(".container-main").height();

    //get window height
    let winHeight = $(window).height();

    //calculate the view port
    let viewport = docHeight - winHeight;

    //get current scroll position
    let scrollPos = $(window).scrollTop();

    //get current scroll percent
    let scrollPercent = (scrollPos / viewport) * 97.48;

    //add the percent to the top progress bar
    $(".indicator").css("width", scrollPercent + "%");
    $(".indicator").attr("title", parseFloat(scrollPercent).toFixed() + "%");
	$(".indicator").attr("aria-label", $(".indicator").attr("title") + " read length");
  });
});
