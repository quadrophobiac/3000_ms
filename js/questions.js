// pseduo code approach to the data structure required for this game

var questions {
[
/*[0]topic: [statements[0]...statements[N]],*/
'tv':  [ 'sopranos','the wire','breaking bad', 'game of thrones', 'fargo','pokemon','match of the day','community','oz','penny dreadful'],
'movie': ['blade runner', 'godfather','goodfellas', 'king kong', 'star wars', 'star trek', 'serenity', 'primer','blues brothers', 'taxi driver'],
'book': ['we3', 'gravitys rainbow', 'chaos' 'ubiq','sandman','invisibles','transmetropolitan','watchmen','lord of the rings','2666',],
'location': ['dublin', 'london', 'new york', 'brighton', 'glasgow', 'galway','cork','kildare','maynooth', 'goldsmiths'],
'person': ['ronaldo','messi','suarez','pele','andy murray','roy mcelroy','barack obama','sepp blater','david cameron','tony blair'],
'event': ['glastonbury', 'world cup', 'wimbledon', 'election', 'wedding', 'holiday', 'baptism', 'christening','funeral', 'finale']
/*[N]topic: [statements[0]...statements[N]] */
]
};
console.log("hello");
/*
Interface..
remove(int index){
	//deletes an element from an array while returning that element
	https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/splice
}
get(int index){
	// returns value of an index from an array while preserving that elements place in the array
}

topicCounts( topicArray ){
// returns true if all arrays have even counts, false if not, and some Game Over parameter when all the questions have been exhausted
	array.length;
	https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/every
	if(allTopicArrays.count.equal) {return true;}
	else if (!allTopicArrays.count.equal) {return function chosen5();}
	else if (!allTopicArrays.count == 0) {return gameover=true}
}
chosen5( topicArray ){
	// possible that the entire JSON object array could be sorted in place? https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/sort
// determines the first 5 'topic' arrays, returns their index
// so this is a search algorithm, from ??? class
}
grab5 ( [ arrayIndexes as args ] ){
https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/forEach
// remove 1 randomly chosen element for each statement array passed to the function
// basically a deQueue operation, but returns an array? returns the formatted divs?
// does the append in situ? passes an array to a seperate append function
	var thisRound = [];
	var rR = ; // randRange:. need to count the length of each array, and return the lowest ones length here
	forEach(args as i) {
		parArray = ALL_QUESTIONS[i];
		forEachIn(parArray, function (key, val) { thisRound.push(remove(val[rR])) }); 
		// to test this need to see if key val arrays can be accessed in such a manner
	}
}

grabNext5( [ arrayIndexes as args ] ) {
	for (args)
}



 */

// alternative / likely deprecated grab5 logic
	/*forEach(args as i) {
		forEachIn(key, val) {
		var = remove(ALL_QUESTIONS[i].val[rR]);
		// so this could be problematic because of scope
		// might be able to avail of bind, and the remove methods defined earlier
		thisRound.push(q);
	} */


