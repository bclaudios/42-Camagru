(function()	{
	const video = document.getElementById("video"),
			vendorUrl = window.URL || window.webkitURL;

	navigator.getMedia =	navigator.GetUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mowGetUserMedia ||
							navigator.msGetUserMedia;
	navigator.getMedia ({
		video : true,
		audio : false
	}, function (stream)	{
		video.src = vendorUrl.createObjectUrl(stream);
		video.play();
	}, function (error)	{
		//error
	});
})();