document.addEventListener("click", function(e)	{
	if (event.target.matches(".stickers"))	{
		const sticker = document.getElementById("sticker");
		if (sticker.firstChild)
			sticker.removeChild(sticker.firstChild);
		const stickerSrc = event.target.src;
		const stickerImg = document.createElement("img");
		stickerImg.src = stickerSrc;
		sticker.appendChild(stickerImg);
	}
})