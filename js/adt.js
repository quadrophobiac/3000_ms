// data type for the array of questions which is presented to the user to guess

function forEachIn(object, action) {
  for (var property in object) {
  if (Object.prototype.hasOwnProperty.call(object, property))
    action(property, object[property]);
  }
}
function forEach(array, action) {
  for (var i = 0; i < array.length; i++)
    action(array[i]);
}
function shuffle(array) {
  var tmp, current, top = array.length;
  if(top) while(--top) {
    current = Math.floor(Math.random() * (top + 1));
    tmp = array[current];
    array[current] = array[top];
    array[top] = tmp;
  }
  return array;
}

function evenSpread(){
  isEven = false;
  return isEven;
}
sortDesc = function(aList){
  // aList will typically will be the returned array from count
  topics = []; // empty topics necessary so that an array of objects is not returned
  //console.log("within TopicPool "+typeof aList);
  if (evenSpread(aList)) {
    //console.log("no need to prioritise!");
  } else {
    nuOrder = aList.sort(function(a,b){return a.contents - b.contents});
  }
  nuOrder = nuOrder.reverse(); // we are interested in the highest counts, so the reverse method is requisite
  forEach(nuOrder, function(a){
    topics.push(a.ref);
  });
  return topics;
}


function QuizContent(qs) {
  this.questions = qs;
}

// below maybe needs inclusion

// QuizContent.prototype.evenSpread = function(){
//   isEven = false;
//   return isEven;
// }

QuizContent.prototype.count = function(subjects) {
  // returns a hash object of statement number : number of entitites in array
  var totalTopics = Object.keys(this.questions).length;
  var cnt = [];
  forEachIn(this.questions, function(k,v){
    var obj = {};
    l=v.length;
    obj.contents = l;
    obj.ref = parseInt(k);
    cnt.push(obj);
  });
  return cnt;
}

QuizContent.prototype.chooseFive = function(topic) {
    var object = this.questions; // a copy should suffice given changes not made until remove
    var genObj = {};
    for (var c = 0; c < topic.length; c++){
      var l = (object[topic[c]].length)-1;
      // fetch the length of the array from which a random element is to be chosen
      genObj[topic[c]] = Math.floor((Math.random() * l));
    }
    return genObj;
};
QuizContent.prototype.presentStatements = function(microObject, divMap) {
  // microObject will the object returned by chooseFive function
  // divMap is an array of objects with name : #divId key values, to which a new key value pairing is appended
  var object = this.questions; // a copy should suffice given changes not made until remove
  nuArray = [];
  forEachIn(microObject, function(k,v){ // create an array of names
    nuArray.push(object[k][v]);
  });
  for(var x=0; x<divMap.length; x++){
    divMap[x].value = nuArray[x];
  }
  return divMap;
};

QuizContent.prototype.remove = function(microObject) {
  forEachIn(microObject, function(k,v){
    this.questions[k].splice(v, 1);
  });
};

// somewhere between above and below needs to be the edge case of No Statements Left!
