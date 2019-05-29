// ******** Live Timer function ********
function startCountDown(divID, seconds, totalSec) {
  // convert parameters as needed
  divID = String(divID);
  seconds = Math.floor(seconds);
  totalSec = Math.floor(totalSec)

  let counter = 0; // counter to decrease the seconds parameter
  let timeRemaining = (seconds - counter); // total time remaining

  let timer = document.getElementById(divID); // get the timer Div

  // initial style
  timer.style = "background: rgba(0,0,0,0);"
    + "text-align: center;";

  // check for negative values or NaN
  if (seconds < 0 || isNaN(seconds)) {
    seconds = 0;
  }

  // start displaying remaining time in timer Div
  timer.innerHTML = convertSeconds(timeRemaining);

   // initial progress bar width %
  let width = 100;
  let colorValue = 0;

  // execution interval(1 sec)
  let interval = setInterval(timeInterval, 1000);

  // this function decreases total remaining time
  function timeInterval() {
    counter++;
    timeRemaining = (seconds - counter);

    // check if remaining time is > 0 
    if (timeRemaining > 0) {
      // display the remaining time
      timer.innerHTML = convertSeconds(timeRemaining);
      // compute the actual remaining width
      width = Math.floor(timeRemaining / (totalSec/100)) + 2;

        // set progress bar color
        colorValue = (width / 100); // value from 0 to 1
        timer.style.background = "linear-gradient(" + getColor(colorValue)
          + "," + getColor(colorValue) + ") no-repeat";
        // reduce the size of the progress bar
        timer.style.backgroundSize = width + "%" + " " + "100%";
      
    } else {
      clearInterval(interval); // stop execution if remaining time < 1
      timer.innerHTML = "Done";
      timer.style.background = "red";
      timer.style.backgroundSize = "100% 100%";
      timer.style.textAlign = "center";

      // fade out row
      FX.fadeOut(timer.parentNode.parentNode.parentNode, {
        duration: 3000
      });

      setTimeout( function(){
        timer.parentNode.parentNode.parentNode.style = "display: none";
      }, 2800);

    }
  }

  // HH:MM:SS color => RED-ORANGE-GREEN
  let hue;
  function getColor(value) {
    // value from 0 to 1
    hue = ((value) * 120).toString(10);
    return ["hsl(", hue, ", 100%, 50%)"].join("");
  }

  // convert seconds to HH:MM:SS
  function convertSeconds(seconds) {
    seconds = Number(seconds);

    let hours = Math.floor(seconds / 3600);
    let min = Math.floor((seconds % 3600) / 60);
    let sec = (seconds % 3600) % 60;

    // add zero if hours,min,sec < 10
    hours = hours < 10 ? "0" + hours : hours;
    min = min < 10 ? "0" + min : min;
    sec = sec < 10 ? "0" + sec : sec;

    return (hours + ":" + min + ":" + sec);
  }
}
//****** END Live Timer function ******

// fade out row when time is up
(function() {
    var FX = {
        easing: {
            linear: function(progress) {
                return progress;
            },
            quadratic: function(progress) {
                return Math.pow(progress, 2);
            },
            swing: function(progress) {
                return 0.5 - Math.cos(progress * Math.PI) / 2;
            },
            circ: function(progress) {
                return 1 - Math.sin(Math.acos(progress));
            },
            back: function(progress, x) {
                return Math.pow(progress, 2) * ((x + 1) * progress - x);
            },
            bounce: function(progress) {
                for (var a = 0, b = 1, result; 1; a += b, b /= 2) {
                    if (progress >= (7 - 4 * a) / 11) {
                        return -Math.pow((11 - 6 * a - 11 * progress) / 4, 2) + Math.pow(b, 2);
                    }
                }
            },
            elastic: function(progress, x) {
                return Math.pow(2, 10 * (progress - 1)) * Math.cos(20 * Math.PI * x / 3 * progress);
            }
        },
        animate: function(options) {
            var start = new Date;
            var id = setInterval(function() {
                var timePassed = new Date - start;
                var progress = timePassed / options.duration;
                if (progress > 1) {
                    progress = 1;
                }
                options.progress = progress;
                var delta = options.delta(progress);
                options.step(delta);
                if (progress == 1) {
                    clearInterval(id);
                    options.complete();
                }
            }, options.delay || 10);
        },
        fadeOut: function(element, options) {
            var to = 1;
            this.animate({
                duration: options.duration,
                delta: function(progress) {
                    progress = this.progress;
                    return FX.easing.swing(progress);
                },
                complete: options.complete,
                step: function(delta) {
                    element.style.opacity = to - delta;
                }
            });
        },
        fadeIn: function(element, options) {
            var to = 0;
            this.animate({
                duration: options.duration,
                delta: function(progress) {
                    progress = this.progress;
                    return FX.easing.swing(progress);
                },
                complete: options.complete,
                step: function(delta) {
                    element.style.opacity = to + delta;
                }
            });
        }
    };
    window.FX = FX;
})()
