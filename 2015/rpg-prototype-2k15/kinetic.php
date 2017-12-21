<?
// Require the application top file
require_once('top.php');

// Require the database top include file
require_once('data/database.php');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Mega Man RPG Prototype | Blank | Last Updated <?= preg_replace('#([0-9]{4})([0-9]{2})([0-9]{2})-([0-9]{2})#', '$1/$2/$3', MMRPG_CONFIG_CACHE_DATE) ?></title>
<base href="<?=MMRPG_CONFIG_ROOTURL?>" />
<meta name="robots" content="noindex,nofollow" />
<meta name="format-detection" content="telephone=no" />
<link type="text/css" href="styles/style.css?<?=MMRPG_CONFIG_CACHE_DATE?>" rel="stylesheet" />
<link type="text/css" href="styles/style.css?<?=MMRPG_CONFIG_CACHE_DATE?>" rel="stylesheet" />
<? if($flag_wap){ ?><link type="text/css" href="styles/style-mobile.css?<?=MMRPG_CONFIG_CACHE_DATE?>" rel="stylesheet" /><? } ?>
<style type="text/css">
#battle {
  height: auto;
}
#testing123 {
  display: block;
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  bottom: 0;
  background-color: rgba(100, 0, 0, 0.1);
  z-index: 100;
}
#testing123 canvas {
  display: block;
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  bottom: 0;
}
</style>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="_ext/kineticjs/kinetic-v4.5.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  
  
  var tempElement = $('#testing123');
  var stageWidth = tempElement.width();
  var stageHeight = tempElement.height();
  
  // Create the canvas stage to draw onto
  var stage = new Kinetic.Stage({
    container: 'testing123',
    width: stageWidth,
    height: stageHeight
    });
  
  // Create a new layer in the canvas to hold objects
  var layer = new Kinetic.Layer();
  
  /*
  // Create a new rectangle object to add to the layer
  var rect = new Kinetic.Rect({
    x: 200,
    y: stageHeight - 80 - 60,
    width: 80,
    height: 80,
    fill: 'blue',
    stroke: 'navy',
    strokeWidth: 1
    });
  
  // Add the shape to the layer
  layer.add(rect);
  */
  
  // Create the robot sprite animation subroutines
  var animations = {
    idle: [{
      x: 0,
      y: 0,
      width: 80,
      height: 80
    }, {
      x: 80,
      y: 0,
      width: 80,
      height: 80
    }, {
      x: 160,
      y: 0,
      width: 80,
      height: 80
    }],
    punch: [{
      x: 240,
      y: 0,
      width: 80,
      height: 80
    }, {
      x: 320,
      y: 0,
      width: 80,
      height: 80
    }]
  };
  
  // Create a quick list of robot sprites and loop through
  var spriteCounter = 0;
  var robotIndex = ['mega-man', 'proto-man', 'cut-man', 'wood-man', 'oil-man', 'bubble-man', 'guts-man', 'flash-man'];
  var robotPatternMatch = /^(?:.*?)\/images\/([-_0-9a-z]+)\/([-_a-z0-9]+)\/sprite_(right|left)_([0-9]+)x(?:[0-9]+)\.([a-z0-9]{3,4})$/i;
  var robotImageIndex = [];
  var robotSpriteIndex = [];
  for (i in robotIndex){
    var robotToken = robotIndex[i];
    
    // Create the robot sprite object and prepare it
    var tempImage = new Image();
    tempImage.onload = function(){
    
      var robotKey = robotSpriteIndex.length;
      var robotToken = this.src.replace(robotPatternMatch, '$2');
      var robotDirection = this.src.replace(robotPatternMatch, '$3');
      var robotSize = this.src.replace(robotPatternMatch, '$4');
      
      // Create the robot sprite animation subroutines
      var robotAnimations = {
        idle: [
          {x: 0, y: 0, width: 80, height: 80},
          {x: 80, y: 0, width: 80, height: 80}
          ],
        punch: [
          {x: 240, y: 0, width: 80, height: 80},
          {x: 320, y: 0, width: 80, height: 80}
          ]
        };
      
      console.log(this.src);
      
      var tempSprite = new Kinetic.Sprite({
        x: 200 - (25 * robotKey),
        y: stageHeight - 80 - 60,
        image: tempImage,
        animation: 'idle',
        animations: robotAnimations,
        frameRate: 10 - Math.floor(robotKey / 2),
        index: 0
      });
      
      robotSpriteIndex.push(tempSprite);
      console.log('sprite loaded for '+robotToken+'.  that makes '+robotSpriteIndex.length);
  
      // add the shape to the layer
      layer.add(tempSprite);
    
      // if all the sprites have completed
      if (robotSpriteIndex.length >= robotIndex.length){
    
        // Add the layer to the stage
        stage.add(layer);
    
        // start sprite animation
        for (j in robotSpriteIndex){ robotSpriteIndex[j].start(); }
        //tempSprite.start();
        
        console.log('starting animation');
      
      }
      
    };
    
    tempImage.src = 'images/robots/'+robotToken+'/sprite_right_80x80.png';
    console.log('loading the sprite for... '+tempImage.src);
    robotImageIndex.push(tempImage);
    
  }
  

  

});
</script>
</head>
<body id="mmrpg" class="battle">

  <div id="battle">
  
    <div id="canvas">
      <div class="wrapper">
        <div class="event sticky" style="z-index: 10;">
          <div class="background" style="background-image: url(images/fields/intro-field/battle-field_background_base.gif); z-index: 0;"></div>
          <div class="foreground" style="background-image: url(images/fields/intro-field/battle-field_foreground_base.png); z-index: 5;"></div>
        
          
          <div id="testing123">
          
          </div>

        </div>
      </div>
    </div>
  
  </div>

<pre style="margin: 20px auto; width: 600px; background-color: rgba(255, 255, 255, 0.1); border-color: rgba(0, 0, 0, 0.1); border-radius: 0.5em; padding: 20px; text-align: left; padding: 20px;">
<?= htmlentities(print_r($_REQUEST, true), ENT_QUOTES, 'UTF-8', true) ?>
</pre>
&nbsp;

</body>
</html>