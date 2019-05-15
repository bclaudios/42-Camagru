document.addEventListener("click", function(e)	{
	if (event.target.matches(".stickers"))	{
		const overlay = document.getElementById("overlay");
		const sticker = document.getElementById("sticker");
		if (sticker.firstChild) // Delete previous sticker if selected
			sticker.removeChild(sticker.firstChild);
		const stickerSrc = "app/assets/img/stickers/" + event.target.id;
		const stickerImg = document.createElement("img");
		stickerImg.src = stickerSrc;
		stickerImg.setAttribute("id", event.target.id);
		sticker.appendChild(stickerImg);
	}
})