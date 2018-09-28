<footer>
	footer
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		var slideIndex = 0;
		slide(slideIndex);

		function slide(slideIndex) {
		    var x = $(".image_slider > img");
		    x.hide();
		    slideIndex++;
		    if (slideIndex > x.length) {
		    	slideIndex = 1
		    }
		    console.log(x.length);
		    console.log(x[slideIndex]);
		    var target = ".image_slider > img:nth-child(" + slideIndex + ")";
		    $(target).show();
		    setTimeout(function(){slide(slideIndex)}, 5000);
		}
		$("#order input[type=radio]").hide();
		$(".radio").show();
		$("#type > .radio").click(function(){
			$("#type > .radio").removeClass("selected");
			$(this).addClass("selected");
			var target = $(this).attr("for");
			$("#" + target).prop("checked", true);
		});
		$("#servings > .radio").click(function(){
			$("#servings > .radio").removeClass("selected");
			$(this).addClass("selected");
			var target = $(this).attr("for");
			$("#" + target).prop("checked", true);
		});
	});
</script>
</body>
</html>
