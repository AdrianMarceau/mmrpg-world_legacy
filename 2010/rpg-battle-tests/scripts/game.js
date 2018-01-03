/*
 * MEGA MAN RPG GAME
 */

// Define the global variables
var canvasIndex = [];
var spriteIndex = [];

// Define the Mega Man RPG game class
function mmrpgGame(){
  // Define public internal variables based on args
  this.html = $('#mmrpg');
}

// Define the Mega Man RPG game class's canvas drawing method
mmrpgGame.prototype.drawCanvas = function(id){
  // Append the new canvas div to the game
  var canvas = canvasIndex['canvas_'+id];
  canvas.parent = this;
  this.html.append(canvas.html);
};

// Define the Mega Man RPG game class's canvas erasing method
mmrpgGame.prototype.eraseCanvas = function(id){
  // Remove the requested canvas from the game
  var canvas = canvasIndex['sprite_'+id];
  canvas.parent = undefined;
  canvas.remove();
};