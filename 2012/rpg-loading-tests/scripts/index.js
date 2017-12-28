// Define the parent index class
var mmrpgIndex = function(kind){
  this.kind = kind;
  this.index = [];
  return this;
  };
mmrpgIndex.prototype = {
  kind: '',
  index: false,
  insert: function(data){
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
  select: function(id){
    return this.index[id];
    },
  all: function(){
    return this.search();
    },
  search: function(data){
    var value = [];
    for (id in this.index){
      if (typeof data === 'undefined' || !data.length){
          value.push(this.index[id]);
        } else {
          for (field in data){
            if (this.index[id][field].indexOf(data[field]) != -1){
              value.push(this.index[id]);
              }
            }
        }
      }
    return value;
    }
  };