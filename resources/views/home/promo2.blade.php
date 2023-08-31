<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown Timer</title>
     <link rel="stylesheet" href="{{URL('/')}}/assets/css/style.css">
</head>

<body>
    <h1> Best deals of the day</h1>
    <h3 id="now_date"></h3>
    <div class="product">
        <img src="{{URL('/')}}/uploads/thumbnail/{{ $currentOffer->Image }}" alt="{!! $currentOffer->Title !!}" +>
        <div class="details">
            <?php //echo date('Y-m-d H:i:s', $end_datetime);exit; 
            ?>
            <h3>🔥{!! $currentOffer->Title !!}🔥</h3>
            <p>{!! $currentOffer->Description !!}🤩
            </p>
            <div class="wrap">
                <h3 class="offer">Offer ends in</h3>
                <div class="timer">
                    <div class="days">
                        <span id="days_left"> 0</span>
                        days
                    </div>
                    <div class="hours">
                        <span id="hours_left"> 0 </span>
                        hours
                    </div>
                    <div class="mins">
                        <span id="mins_left"> 0 </span>
                        mins
                    </div>
                    <div class="secs">
                        <span id="secs_left"> 0 </span>
                        secs
                    </div>
                </div>
            </div>
            <a class="product" href="https://api.whatsapp.com/send?phone={{ $agent->Phone }}" style="display: inline-block; padding:16px; border-radius: 8px; background-color: #25D366; color: #fff; text-decoration: none; font-family: sans-serif; font-size: 16px;margin-top:20px;width: 200px;">Contact us on WhatsApp</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
     <script>
        var offerDate = new Date('<?php echo date('Y-m-d H:i:s', $end_datetime); ?>');
        const today   = new Date();
        const offerEndTime = offerDate - today; 
        var end_datetime = <?php echo $end_datetime;?>;
        // Set the target time for the countdown (in milliseconds)
        const targetTime = new Date().getTime() + offerEndTime; //  minutes in seconds
        // Update the countdown timer every second
        const timerInterval = setInterval(updateTimer, 1000);
        
        function updateTimer() {

            $('#now_date').html(new Date());
            const currentTime = new Date().getTime();
            const timeRemaining = targetTime - currentTime;
            if (timeRemaining <= 0) {
                clearInterval(timerInterval); // Stop the timer
                redirectToNextPage(); // Redirect to the next page
            } else { 
                // 1 sec= 1000 ms
                // 1 min = 60 sec
                // 1 hour = 60 mins
                // 1 day = 24 hours
                const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                const years = Math.floor(days / 365);
                const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                const days_el = document.getElementById("days_left");
                days_el.innerHTML = days;
                const hours_el = document.getElementById("hours_left");
                hours_el.innerHTML = hours;
                const mins_el = document.getElementById("mins_left");
                mins_el.innerHTML = minutes;
                const secs_el = document.getElementById("secs_left");
                secs_el.innerHTML = seconds;

            }
        }

        function redirectToNextPage() {
            // Replace 'next-page.html' with the URL of the next page you want to redirect to
            window.location.reload();
        }
    </script>
</body>

</html>