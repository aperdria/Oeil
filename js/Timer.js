/*

This code runs the same test as above but replacing setInterval by a custom interval maker : the Timer class.

The results must be read the same way : First value should be as close to 0 or 1000 as possible (any other value shows how "off the spot" the timing of the trigger was.) Second value is number of times the code has been triggered, and third value is how many times the could should have been triggered.

*/

Timer = (function() {

    function Timer(precision, callback) {
      this.precision = precision != null ? precision : 1000;
      this.callback = callback;
      this.started = false;
      this;

    }

    Timer.prototype.start = function() {
      if (this.__handle) {
        return this;
      }
      this.started = true;
      this.__baseline = new Date().getTime();
      this.__setTimeout();
      return this;
    };

    Timer.prototype.stop = function() {
      this.started = false;
      clearTimeout(this.__handle);
      this.__handle = void 0;
      return this;
    };

    Timer.prototype.__setTimeout = function() {
      var cb, nextTimeout, now,
        _this = this;
      now = new Date().getTime();
      nextTimeout = this.precision - now + this.__baseline;
      if (nextTimeout < 0) {
        nextTimeout = 0;
      }
      cb = function() {
        _this.__setTimeout();
        return _this.callback();
      };
      this.__handle = setTimeout(cb, nextTimeout);
      return this.__baseline += this.precision;
    };

    return Timer;

  })();

var start = +new Date();
var count = 0;
var timer = new Timer(1000, function () {
    console.log((new Date() - start) % 1000,
    ++count,
    Math.round((new Date() - start)/1000))
});

timer.start();