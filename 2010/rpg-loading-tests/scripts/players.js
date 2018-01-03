// Define global player index array
var mmrpgPlayers = [];

// Define the object class for players
var mmrpgPlayer = function(data){
  this.id = data.id;
  this.name = data.name;
  this.token = data.token;
  this.speed = data.speed;
  this.cpu = data.cpu;
  };
  
// Define the object prototype for players
mmrpgPlayer.prototype = {
  id: 0,
  name: 'Player',
  token: 'player',
  speed: 0,
  cpu: false
  };

// Define global function for appending to the player index array
function mmrpgIndexPlayer(data){ 
  mmrpgPlayers[data.id] = new mmrpgPlayer(data); 
}

// Define all the player objects for the game
mmrpgIndexPlayer({
  id: 1,
  name: 'Dr. Light',
  token: 'dr-light',
  speed: 1,
  cpu: false
  });
mmrpgIndexPlayer({
  id: 2,
  name: 'Dr. Wily',
  token: 'dr-wily',
  speed: 0,
  cpu: true
  });