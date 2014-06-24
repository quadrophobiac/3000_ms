var ALL_QUESTIONS {
[
/*[0]*/topic: [statements[0]...statements[N]],
....
/*[N]*/topic: [statements[0]...statements[N]]
]
};

/*
Interface..
remove(int index){
	//deletes an element from an array while returning that element
}
get(int index){
	// returns an index from an array while preserving that elements place in the array
}

topicCounts( topicArray ){
// returns true if all arrays have even counts, false if not, and some Game Over parameter when all the questions have been exhausted

	if(allTopicArrays.count.equal) {return true;}
	else if (!allTopicArrays.count.equal) {return function chosen5();}
	else if (!allTopicArrays.count == 0) {return gameover=true}
}
chosen5( topicArray ){
// determines the first 5 'topic' arrays, returns their index
// so this is a search algorithm, from ??? class
}
grab5 ( [ arrayIndexes as args ] ){
// remove 1 randomly chosen element for each statement array passed to the function
// basically a deQueue operation, but returns an array? returns the formatted divs?
// does the append in situ? passes an array to a seperate append function
	var thisRound = [];
	var rR = ; // randRange:. need to count the length of each array, and return the lowest ones length here
	forEach(args as i) {
		forEachIn(key, val) {
		var = remove(ALL_QUESTIONS[i].val[rR]);
		// so this could be problematic because of scope
		// might be able to avail of bind, and the remove methods defined earlier
		thisRound.push(q);
		}
	}
}

grabNext5( [ arrayIndexes as args ] ) {
	for (args)
}



 */