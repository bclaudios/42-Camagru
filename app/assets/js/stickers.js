document.addEventListener("click", function(e)	{
	if (event.target.matches(".stickers"))	{
		const sticker = document.getElementById("sticker");
		if (sticker.firstChild)
			sticker.removeChild(sticker.firstChild);
		const stickerSrc = "app/assets/img/stickers/" + event.target.id;
		const stickerImg = document.createElement("img");
		stickerImg.src = stickerSrc;
		stickerImg.setAttribute("id", event.target.id);
		sticker.appendChild(stickerImg);
	}
})