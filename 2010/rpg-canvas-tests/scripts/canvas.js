/*
 * MEGA MAN RPG CANVAS
 */

// Define the Mega Man RPG canvas class
function mmrpgCanvas(data){
  // Define public internal variables based on args
  this.html;
  this.id = data.id != undefined ? data.id : '00';
  this.size = data.size != undefined ? data.size : {};
  this.size.width = this.size.width != undefined ? this.size.width : 600;
  this.size.height = this.size.height != undefined ? this.size.height : 200;
  // Automatically generate the canvas's HTML properties
  this.generateHTML();
  // Add this canvas to the index
  canvasIndex['canvas_'+this.id] = this;
}

// Define the Mega Man RPG canvas class's HTML generation method
mmrpgCanvas.prototype.generateHTML = function(){
  // Generate the sprite object's html properties
  this.html = $('<div></div>');
  this.html.attr('id', 'canvas_'+this.id);
  this.html.addClass('canvas');
  this.html.css({
    width:this.size.width+'px',
    height:this.size.height+'px'
    });
}

// Define the Mega Man RPG canvas class's sprite drawing method
mmrpgCanvas.prototype.drawSprite = function(id){
  // Append the new sprite span to the canvas
  var sprite = spriteIndex['sprite_'+id];
  sprite.parent = this;
  sprite.html.css({opacity:0});
  this.html.append(sprite.html);
  sprite.html.animate({opacity:1},{duration:300,easing:'linear',queue:false});
};

// Define the Mega Man RPG canvas class's sprite redrawing method
mmrpgCanvas.prototype.redrawSprite = function(id){
  // Append the new sprite span to the canvas
  var sprite = spriteIndex['sprite_'+id];
  this.eraseSprite(sprite.id);
  sprite.generateHTML();
  this.drawSprite(sprite.id);
};

// Define the Mega Man RPG canvas class's sprite erasing method
mmrpgCanvas.prototype.eraseSprite = function(id){
  // Remove the requested sprite from the canvas
  var sprite = spriteIndex['sprite_'+id];
  sprite.parent = undefined;
  sprite.html.animate({opacity:0},{duration:300,easing:'linear',queue:false,complete:function(){ $(this).remove(); }});
};