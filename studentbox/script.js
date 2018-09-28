var slideIndex = 0;
slide();

function slide() {
    var x = document.getElementsByClassName("my_slides");

    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none"; 
    }
    slideIndex++;
    if (slideIndex > x.length) {
    	slideIndex = 1
    }
    console.log(slideIndex);
    console.log(x);
    x[slideIndex].style.display = "block";
    setTimeout(slide(), 2000);
}