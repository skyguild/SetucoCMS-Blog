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
		});
	}

	$(".heightLine").each(function(){
		var _this = $(this);
		var target = _this.find(".heightLineList");
		var maxHeight = 0;
		var row = 0;

		target.each(function(){
			if($(this).height() > maxHeight) maxHeight = $(this).height();
			$(this).addClass("row");

			if(row >= 2){
				row = 0;
				_this.find(".row").height(maxHeight).removeClass('row');
				maxHeight = 0;
			} else{
				row++;
			};

			_this.find(".row").height(maxHeight).removeClass('row');
		});

	});

	$("div.entryBody a[target='_blank']").each(function(){
		$(this).addClass("blank_link");
		var entryTitle = $(this).closest(".entryBody").siblings(".entryHead").find("h2 span").text();
		var entryID = $(this).closest(".entryBody").attr("class").replace("entryBody ", "");

		var referrer = entryTitle + "[" + entryID + "]";
		var linked = $(this).text() + "[" + $(this).attr("href") + "]" ;
		$(this).attr("onclick", "_gaq.push(['_trackEvent', '外部サイト', 'リンク元：" + referrer + "', 'リンク先：" + linked + "']);");
	});

	$(".blank_link img").parent().removeClass("blank_link");

});