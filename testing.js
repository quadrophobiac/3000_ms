var num = count(questions); // return count array of objects
console.log(num);

console.log("object questions = "+ typeof questions);
console.log("invoking Object.keys on object questions, returns :."+typeof Object.keys(questions));


// console.log(num[0][0]); // deprecated, was used when I was indexing count with raw int numbers, see below
// count = function(subjects) {
// ...
// 		var obj = {};
//		l=v.length;
//		obj[k] = l;
//

// test how vals and keys have been assigned through count() function
forEachIn(num, function(k,v){
	console.log("key = "+k+" val = "+v);
	console.log("val[key] = "+v[k]);
});

console.log(evenSpread(num)); // return true or false

// access top 5 results from topicPool sorted array of objects

var topFive = topicPool(num).slice(0,5);
console.log(topFive);

// use forEach to access the elements

forEach(topFive, function(a){console.log(a.ref);});