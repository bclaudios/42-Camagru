const video = document.getElementById("video");

const constraints = {
	audio: false,
	video: {
		width: 800,
		height: 600
	}
}
async function Stream() {
	const stream = await navigator.mediaDevices.getUserMedia(constraints);
	window.stream = stream;
	video.srcObject = stream;
}
Stream();