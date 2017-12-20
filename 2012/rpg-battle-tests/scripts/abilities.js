// Define global ability index array
var mmrpgAbilities = [];

// Define the object class for abilities
var mmrpgAbility = function(data){
  this.id = data.id;
  this.name = data.name;
  this.token = data.token;
  this.damage = data.damage;
  }

// Define the object prototype for abilities
mmrpgAbility.prototype = {
  id: 0,
  name: 'Ability',
  token: 'ability',
  damage: 0
  };

// Define global function for appending to the ability index arrays
function mmrpgIndexAbility(data){ mmrpgAbilities[data.id] = new mmrpgAbility(data); }

// Define all the robot objects for this game
mmrpgIndexAbility({
  id: 1,
  name: 'Mega Buster',
  token: 'mega-buster',
  damage: 10
  });
mmrpgIndexAbility({
  id: 2,
  name: 'Super Punch',
  token: 'super-punch',
  damage: 10
  });
mmrpgIndexAbility({
  id: 3,
  name: 'Rolling Cutter',
  token: 'rolling-cutter',
  damage: 10
  });
mmrpgIndexAbility({
  id: 4,
  name: 'Proto Buster',
  token: 'proto-buster',
  damage: 30
  });
mmrpgIndexAbility({
  id: 5,
  name: 'Metal Blade',
  token: 'metal-blade',
  damage: 50
  });
mmrpgIndexAbility({
  id: 6,
  name: 'Air Shooter',
  token: 'air-shooter',
  damage: 15
  });
mmrpgIndexAbility({
  id: 7,
  name: 'Shadow Blade',
  token: 'shadow-blade',
  damage: 50
  });
mmrpgIndexAbility({
  id: 8,
  name: 'Search Snake',
  token: 'search-snake',
  damage: 15
  });
mmrpgIndexAbility({
  id: 9,
  name: 'Gemini Laser',
  token: 'gemini-laser',
  damage: 20
  });
mmrpgIndexAbility({
  id: 10,
  name: 'Needle Cannon',
  token: 'needle-cannon',
  damage: 10
  });
mmrpgIndexAbility({
  id: 100,
  name: 'Buster Shot',
  token: 'buster-shot',
  damage: 5
  });
mmrpgIndexAbility({
  id: 101,
  name: 'Defend',
  token: 'defend',
  damage: 0
  });