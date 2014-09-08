function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function play_rnd(id, quantity){
	document.getElementById(id+""+getRandomInt(1, quantity)).play();	
}