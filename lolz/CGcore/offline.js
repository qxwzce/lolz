function network(data) {
	this.opened = false;
	this.online = true;

	this.container = document.createElement("div");
	this.container.classList.add("network");
	document.querySelector("body").appendChild(this.container);

	this.init();
}

network.prototype.init = function() {
	setInterval(() => {
		if (!this.online && navigator.onLine) {
			console.log("Back online");
			this.online = true;
			
			this.container.classList.add('online')
	      this.container.innerHTML = "Back online"
			
			this.toggle()
		} else if (this.online && !navigator.onLine) {
			console.log("No connection");
			this.online = false;
			
			this.container.classList.remove('online')
	      this.container.innerHTML = "No connection"
			
			this.toggle();
		}
	}, 5000);
};

network.prototype.open = function(data) {
	this.opened = true;
	return (this.container.style["transform"] =
		"translateY(-" + this.container.offsetHeight + "px)");
};

network.prototype.close = function() {
	this.opened = false;
	this.container.style["transform"] = "translateY(0)";
};

network.prototype.toggle = function(data) {
	return this.opened ? this.close(data) : this.open(data);
};


// init
new network();