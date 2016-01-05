/* 

This code is a direct copy/paste from Blixt (http://stackoverflow.com/users/119081/blixt) answer
to a related question on Stackoverflow (http://stackoverflow.com/a/985733/1265207)

First value should be as close to 0 or 1000 as possible (any other value shows how "off the spot" the timing of the trigger was.) Second value is number of times the code has been triggered, and third value is how many times the could should have been triggered.

*/

var start = +new Date();
var count = 0;
setInterval(function () {
    console.log((new Date() - start) % 1000,
    ++count,
    Math.round((new Date() - start)/1000))
}, 1000);