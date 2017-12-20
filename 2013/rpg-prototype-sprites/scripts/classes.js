/*
 * MMRPG INDEX CLASS
 */

// Define the parent index class
var mmrpgIndex = function(data, kind){
  this.index = data || [];
  this.kind = kind || 'objects';
  //if (data != undefined && data.length){ this.index = data; }
  //if (kind != undefined && kind.length){ this.kind = kind; }
  return this;
  };
mmrpgIndex.prototype = {
  index: false, 
  kind: false,
  get: function(id){
    if (typeof id != 'undefined'){ return jQuery.extend(true, {}, this.index[id]); }
    else { return jQuery.extend(true, {}, this.index); }
    },
  insert: function(data){
    data.kind = this.kind;
    data.flags = {};
    data.counters = {};
    data.values = {};
    this.index[data.id] = data;
    return this;
    },
  update: function(id, data){
    for (field in data){ this.index[id][field] = data[field]; }
    return this;
    },
  remove: function(id){
    delete this.index[id];
    return this;
    },  
  select: function(list){
    var selected = [];
    if (list.length){
      //console.log('Selecting '+list+'...');
      for (key in list){ 
        var id = list[key];
        selected[id] = this.index[list[key]]; 
        //console.log('Selected '+selected[id].name+'!');
        }      
      }
    return new mmrpgIndex(selected, this.kind);
    }, 
  filter: function(data){
    var filtered = [];
    for (id in this.index){  
      for (field in data){
        if (this.index[id][field].indexOf(data[field]) != -1){
          filtered[id] = this.index[id];
          }
        }                
      }
    return new mmrpgIndex(filtered, this.kind);      
    },
  each: function(callback){
    for (id in this.index){
      callback(this.index[id]);
      }
    }
  };


/*
 * MMRPG PLAYER CLASS
 */

var mmrpgEngine = function(data){
  this.players = data.players || [];
  this.flags = data.flags || {};
  this.counters = data.counters || {};
  this.values = data.values || {};
  };
mmrpgEngine.prototype = {
  players: false,
  flags: false,
  counters: false,
  values: false,  
  addPlayers: function(players){
    
    // Collect and expand the current player objects
    this.players = $players.select(players).get();
    var pcount = 0;
    for (pid in this.players){
      
      // Define and generate the current player object
      //var thisPlayer = $mmrpg.players[pid];
      this.players[pid] = new mmrpgPlayer(this.players[pid]);
      var thisPlayer = this.players[pid];
      thisPlayer.battle = 1;
      thisPlayer.key = pcount;
      thisPlayer.position = pcount;
      thisPlayer.side = thisPlayer.id == thisPlayerID ? 'left' : 'right';
      thisPlayer.direction = thisPlayer.side == 'left' ? 'right' : 'left';
      thisPlayer.updatePlayer();
      
      // Collect and expand the current robot objects
      //console.log('This player('+thisPlayer.name+') robots?');
      if (thisPlayer.id == thisPlayerID && thisPlayerRobots.length){ thisPlayer.robots = thisPlayerRobots; }
      else if (thisPlayer.id != thisPlayerID && targetPlayerRobots.length){ thisPlayer.robots = targetPlayerRobots; }
      if (thisPlayer.robots.length > 8){ thisPlayer.robots = thisPlayer.robots.slice(0, 8);  }
      thisPlayer.counters.robots = thisPlayer.robots.length;
      thisPlayer.robots = $robots.select(thisPlayer.robots).get();
      var rcount = 0;
      for (rid in thisPlayer.robots){
        
        // Collect the current robot object
        //var thisRobot = thisPlayer.robots[rid];
        thisPlayer.robots[rid] = new mmrpgRobot(thisPlayer.robots[rid]);
        var thisRobot = thisPlayer.robots[rid];
        thisRobot.player = thisPlayer.id;
        thisRobot.key = rcount;
        thisRobot.position = thisPlayer.counters.robots >= 8 ? rcount : rcount + Math.floor((8 - thisPlayer.counters.robots) / 2);
        //alert(thisRobot.name+' : '+thisRobot.position+' : '+thisPlayer.counters.robots);
        thisRobot.side = thisPlayer.side;
        thisRobot.direction = thisPlayer.direction;
        thisRobot.updateRobot();
        thisPlayer.updatePlayer();
        
        // Collect and expand the current ability objects
        //console.log('This player('+thisPlayer.name+') robot('+thisRobot.name+') abilities?');
        if (thisRobot.abilities.length > 8){ thisRobot.abilities = thisRobot.abilities.slice(0, 8);  }
        thisRobot.abilities = $abilities.select(thisRobot.abilities).get();
        var acount = 0;
        for (aid in thisRobot.abilities){
          
          // Collect the current ability object
          //var thisAbility = thisRobot.abilities[aid];
          thisRobot.abilities[aid] = new mmrpgAbility(thisRobot.abilities[aid]);
          var thisAbility = thisRobot.abilities[aid];
          thisAbility.robot = thisRobot.id;
          thisAbility.key = acount;
          thisAbility.position = acount;
          thisAbility.side = thisPlayer.side;
          thisAbility.direction = thisPlayer.direction;
          thisAbility.updateAbility();
          thisRobot.updateRobot();
          thisPlayer.updatePlayer();
          
          // Collect and expand the current type objects
          //console.log('This player('+thisPlayer.name+') robot('+thisRobot.name+') ability('+thisAbility.name+') types?');
          thisAbility.types = $types.select(thisAbility.types).get();
          var tcount = 0;
          for (tid in thisAbility.types){
            
            // Collect the current type object
            var thisType = thisAbility.types[tid];
            thisType.ability = thisAbility.id;
            thisType.key = tcount;
            thisAbility.counters.types++;
            
            // Collect and expand the current ??? object
            //console.log('This player('+thisPlayer.name+') robot('+thisRobot.name+') ability('+thisAbility.name+') type('+thisType.name+')!');
            
            
            // Increment the type count
            tcount++;
            }
            
          // Increment the ability counter
          acount++;
          }
          
        // Collect and expand the current weakness, resistance, affinity, and immunity objects
        var typeMechanics = ['weaknesses', 'resistances', 'affinities', 'immunities'];
        for (mid in typeMechanics){
          
          // Collect the current mechanic object
          var thisMechanic = typeMechanics[mid];
          
          // Collect and expand the current type objects
          //console.log('This player('+thisPlayer.name+') robot('+thisRobot.name+') mechanic('+thisMechanic+') types?');
          thisRobot[thisMechanic] = $types.select(thisRobot[thisMechanic]).get();
          for (tid in thisRobot[thisMechanic]){
            
            // Collect the current type object
            var thisType = thisRobot[thisMechanic][tid];
            thisType.mechanic = thisMechanic;
            
            // Collect and expand the current ??? object
            //console.log('This player('+thisPlayer.name+') robot('+thisRobot.name+') mechanic('+thisMechanic+') type('+thisType.name+')!');
            
            }
        
          }
        
        // Increment the robot counter
        rcount++;
        }
        
      // Increment the player counter
      pcount++;
      }  
  
  
    },
  countPlayers: function(){
    this.counters.players = 0;
    for (id in this.players){ this.counters.players++; }
    return this.counters.players;
    },
  updateCounters: function(){
    this.countPlayers();  
    },
  updateEngine: function(){
    this.updateCounters();  
    }
  };


/*
 * MMRPG PLAYER CLASS
 */

var mmrpgPlayer = function(data){
  this.battle = data.battle || 0;
  this.key = data.key || 0;
  this.position = data.position || 0;
  this.side = data.side || 'left';
  this.direction = data.direction || 'right';
  this.id = data.id || 0;
  this.kind = data.kind || 'players';
  this.name = data.name || 'Player';
  this.token = data.token || 'player';
  this.description = data.description || '';
  this.robots = data.robots || [];
  this.rewards = data.rewards || [];
  this.quotes = data.quotes || function(){};
  this.actions = data.actions || function(){};
  this.flags = data.flags || {};
  this.counters = data.counters || {};
  this.values = data.values || {};
  };
mmrpgPlayer.prototype = {
  battle: false,
  key: false,
  position: false,
  side: false,
  direction: false,
  id: false,
  kind: false,
  name: false,
  token: false,
  description: false,
  robots: false,
  rewards: false,
  quotes: false,
  actions: false,
  flags: false,
  counters: false,
  values: false,
  countRobots: function(){
    this.counters.robots = 0;
    for (id in this.robots){ this.counters.robots++; }
    return this.counters.robots;
    },
  updateCounters: function(){
    this.countRobots();  
    },
  updatePlayer: function(){
    this.updateCounters();  
    },
  getTarget: function(){
    if (this.id == thisPlayerID){ return $mmrpg.players[targetPlayerID];  }
    else if (this.id == targetPlayerID){ return $mmrpg.players[thisPlayerID]; }
    else { return false; }
    }
  };


/*
 * MMRPG ROBOT CLASS
 */

var mmrpgRobot = function(data){
  this.player = data.player || 0;
  this.key = data.key || 0;
  this.position = data.position || 0;
  this.side = data.side || 'left';
  this.direction = data.direction || 'right';
  this.id = data.id || 0;
  this.kind = data.kind || 'robots';
  this.name = data.name || 'Robot';
  this.token = data.token || 'robot';
  this.model = data.model || 'NAN-000';
  this.description = data.description || '';
  this.energy = data.energy || 0;
  this.attack = data.attack || 0;
  this.defense = data.defense || 0;
  this.speed = data.speed || 0;
  this.weaknesses = data.weaknesses || [];
  this.resistances = data.resistances || [];
  this.affinities = data.affinities || [];
  this.immunities = data.immunities || [];
  this.abilities = data.abilities || [];
  this.rewards = data.rewards || [];
  this.quotes = data.quotes || function(){};
  this.actions = data.actions || function(){};
  this.flags = data.flags || {};
  this.counters = data.counters || {};
  this.values = data.values || {};
  };
mmrpgRobot.prototype = {
  player: false,
  key: false,
  position: false,
  side: false,
  direction: false,
  id: false,
  kind: false,
  name: false,
  token: false,
  model: false,
  description: false,
  energy: false,
  attack: false,
  defense: false,
  speed: false,
  weaknesses: false,
  resistances: false,
  affinities: false,
  immunities: false,
  abilities: false,
  rewards: false,
  quotes: false,
  actions: false,
  flags: false,
  counters: false,
  values: false,
  countAbilities: function(){
    this.counters.abilities = 0;
    for (id in this.abilities){ this.counters.abilities++; }
    return this.counters.abilities;
    },
  updateCounters: function(){
    this.countAbilities();  
    },
  updateRobot: function(){
    this.updateCounters();  
    },
  getTarget: function(){
    var targetPlayer = $mmrpg.players[this.player].getTarget();
    for (id in targetPlayer.robots){
      var targetRobot = targetPlayer.robots[id];
      if (targetRobot.position == this.position){ return targetRobot; }
      else { continue; }
      }
    return false;
    }
  };


/*
 * MMRPG ABILITY CLASS
 */

var mmrpgAbility = function(data){
  this.robot = data.robot || 0;
  this.key = data.key || 0;
  this.position = data.position || 0;
  this.side = data.side || 'left';
  this.direction = data.direction || 'right';
  this.id = data.id || 0;
  this.kind = data.kind || 'abilities';
  this.name = data.name || 'Ability';
  this.token = data.token || 'ability';
  this.description = data.description || '';
  this.damage = data.damage || 0;
  this.recovery = data.recovery || 0;
  this.speed = data.speed || 0;
  this.accuracy = data.accuracy || 0;
  this.types = data.types || [];
  this.actions = data.actions || function(){};
  this.flags = data.flags || {};
  this.counters = data.counters || {};
  this.values = data.values || {};
  };
mmrpgAbility.prototype = {
  robot: false,
  key: false,
  position: false,
  side: false,
  direction: false,
  id: false,
  kind: false,
  name: false,
  token: false,
  model: false,
  description: false,
  damage: false,
  recovery: false,
  speed: false,
  accuracy: false,
  types: false,
  actions: false,
  flags: false,
  counters: false,
  values: false,
  countTypes: function(){
    this.counters.types = 0;
    for (id in this.types){ this.counters.types++; }
    return this.counters.types;
    },
  updateCounters: function(){
    this.countTypes();  
    },
  updateAbility: function(){
    this.updateCounters();  
    }
  };


/*
 * MMRPG WINDOW CLASS
 */


/*
 * MMRPG CANVAS CLASS
 */


/*
 * MMRPG SPRITE CLASS
 */

