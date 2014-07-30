// an interface to the  jQuery timer class, which is Copyright (c) 2011 Jason Chavannes <jason.chavannes@gmail.com>

function pad(number, length) {
    var str = '' + number;
    while (str.length < length) {str = '0' + str;}
    return str;
}
function formatTime(time) {
    // this function can be rewritten per the parameters desired to be achieved
    var min = parseInt(time / 6000),
        sec = parseInt(time / 100) - (min * 60),
        hundredths = pad(time - (sec * 100) - (min * 6000), 2);
    return (min > 0 ? pad(min, 2) : "00") + ":" + pad(sec, 2) + ":" + hundredths;
}

var ThurtySeconds = new function() { // I have here amended from self invoking, and called init() outside
    var $countdown,
        $form, // Form used to change the countdown time
        incrementTime = 70,
        currentTime = 3000,
        updateTimer = function() {
            $countdown.html(formatTime(currentTime)); // this function is purely for visual feedback
            if (currentTime == 0) {
                ThurtySeconds.Timer.stop();
                timerComplete();
                resetClock(); // this is better placed here than in subsequent resetCountdown function
                ThurtySeconds.resetCountdown();
                return;
            }
            // the below handles the business of counting down
            currentTime -= incrementTime / 10;
            if (currentTime < 0) currentTime = 0;
        },
        timerComplete = function() {
            // .css(style="pointer-events:none;opacity:0.2") <-- not correct jQuery syntax, but the desired effect
            alert('YOUR TURNS OVER! SCORE = ');
            // goof place for the remove flip logic
        };
        this.init = function() {
            //console.log("the countdown = "+$countdown);
            $countdown = $('#countdown');
            //console.log($countdown);
            ThurtySeconds.Timer = $.timer(updateTimer, incrementTime, false);
            $form = $('#ctrlButtons'); // its not fussy about what element it is bound to apparently
            // however I will need to be fussy because this makes any button press reset the timer
            $form.bind('submit', function() {
                //ThurtySeconds.resetCountdown();
                return false; // prevent resubmission of page behaviour default
            });

        };
    this.resetCountdown = function() {

        var newTime = 3000; // 3000 = 30 seconds
        console.log(newTime);
        if (newTime > 0) {currentTime = newTime;}
        this.Timer.stop().once();
    };
};
