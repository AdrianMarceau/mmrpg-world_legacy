/*
 * MEGA MAN RPG SPRITE
 */

// Define the Mega Man RPG sprite class
function mmrpgSprite(data){
  // Define public internal variables based on args
  this.html;
  this.id = data.id != undefined ? data.id : '00';
  this.type = data.type != undefined ? data.type : 'sprite';
  this.path = data.path != undefined ? data.path : 'sprites';
  this.image = data.image != undefined ? data.image : 'sprite';
  this.size = data.size != undefined ? data.size : {};
  this.size.width = this.size.width != undefined ? this.size.width : 40;
  this.size.height = this.size.height != undefined ? this.size.height : 40;
  this.offset = data.offset != undefined ? data.offset : {};
  this.offset.x = this.offset.x != undefined ? this.offset.x : 1;
  this.offset.y = this.offset.y != undefined ? this.offset.y : 1;
  this.offset.z = this.offset.z != undefined ? this.offset.z : 1;
  this.frame = data.frame != undefined ? data.frame : '00';
  this.side = data.side != undefined ? data.side : 'left';
  this.direction = data.direction != undefined ? data.direction : (this.side == 'left' ? 'right' : 'left');
  this.extension = data.extension != undefined ? data.exension : 'png';
  // Automatically generate the sprite's HTML properties
  this.generateHTML();
  // Add this sprite to the index
  spriteIndex['sprite_'+this.id] = this;
}

// Define the Mega Man RPG sprite class's HTML generation method
mmrpgSprite.prototype.generateHTML = function(){
  // Generate the sprite object's html properties
  this.html = $('<span></span>');
  this.html.attr('id', 'sprite_'+this.id);
  this.html.addClass('sprite');
  this.html.addClass('sprite_'+this.size.width+'x'+this.size.height);
  this.html.addClass('sprite_'+this.size.width+'x'+this.size.height+'_'+this.frame);
  this.html.css(this.side, this.offset.x);
  this.html.css('bottom', this.offset.y);
  this.html.css('z-index', this.offset.z);
  this.html.css('background-image', 'url(images/'+this.path+'/'+this.image+'/'+this.type+'_'+this.direction+'_'+this.size.width+'x'+this.size.height+'.'+this.extension+')');
  this.html.html(this.image);
}