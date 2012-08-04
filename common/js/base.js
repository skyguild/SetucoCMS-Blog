$(function(){
	rollover();

	function rollover(){
		$(".rollover").each(function(){
			var org_src = $(this).attr("src");
			var position = org_src.lastIndexOf(".");
			var over_src = org_src.substr(0, position) + "_on" + org_src.substring(position);

			var cache = []
			var cacheImage = document.createElement('img');
			cacheImage.src = over_src;
			cache.push(cacheImage);

			$(this).hover(
				function () {
					$(this).attr("src", over_src);
				},
				function () {
					$(this).attr("src", org_src);
				}
			);
		})
	}
});