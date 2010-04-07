var Chain = function(){
	this.position = 0;
    this.stopped = false;
	this.queue = [];
	this.args = {};
	this.running = false;
	var self = this;
	this.next = function(){
        if (!this.stopped){
            if (arguments.length > 0) this.add_args(arguments[0]);
            self.go();
        }
	}
}
Chain.prototype.add = function(func, args){
	this.queue.push([func, args]);
	return this;
}
Chain.prototype.block = function(){
    this.stopped = true;
}
Chain.prototype.unblock = function(){
    this.stopped = false;
}
Chain.prototype.add_chain = function(chain){
	for (fu in chain.queue) this.queue.push(chain.queue[fu]);
	return this;
}
Chain.prototype.go = function(){
	this.running = true;
	if (this.position < this.queue.length){
		var toCall = this.queue[this.position++];
		toCall[0].apply(this, toCall[1]);
	} else {
		this.position = 0;
		this.running = false;
	};
}
Chain.prototype.add_args = function(obj){
	for (attrname in obj) { this.args[attrname] = obj[attrname]; }
	return this;
}