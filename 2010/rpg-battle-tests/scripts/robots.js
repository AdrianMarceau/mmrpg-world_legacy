// Define global robot index array
var mmrpgRobots = [];

// Define the object class for robots
var mmrpgRobot = function(data){
  this.id = data.id;
  this.player = data.player;
  this.name = data.name;
  this.token = data.token;
  this.energy = 100; //data.energy;
  this.attack = 100; //data.attack;
  this.defense = 100; //data.defense;
  this.speed = data.speed;
  this.ability = data.ability;
  }

// Define the object prototype for robots
mmrpgRobot.prototype = {
  id: 0,
  player: 0,
  name: 'Robot',
  token: 'robot',
  energy: 0,
  attack: 0,
  defense: 0,
  speed: 0,
  ability: 0
  };

// Define global function for appending to the robot index array
function mmrpgIndexRobot(data){ mmrpgRobots[data.id] = new mmrpgRobot(data); }

// Define all the robot objects for this game
mmrpgIndexRobot({
  id: 1,
  player: 1,
  name: 'Mega Man',
  token: 'mega-man',
  ability: 1,
  speed: 100
  });
mmrpgIndexRobot({
  id: 2,
  player: 1,
  name: 'Guts Man',
  token: 'guts-man',
  ability: 2,
  speed: 90
  });
mmrpgIndexRobot({
  id: 3,
  player: 1,
  name: 'Cut Man',
  token: 'cut-man',
  ability: 3,
  speed: 105
  });
mmrpgIndexRobot({
  id: 4,
  player: 2,
  name: 'Proto Man',
  token: 'proto-man',
  ability: 4,
  speed: 100
  });
mmrpgIndexRobot({
  id: 5,
  player: 2,
  name: 'Metal Man',
  token: 'metal-man',
  ability: 5,
  speed: 110
  });
mmrpgIndexRobot({
  id: 6,
  player: 2,
  name: 'Air Man',
  token: 'air-man',
  ability: 6,
  speed: 95
  });