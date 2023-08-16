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
        <img src="{{URL('/')}}/uploads/{{ $currentOffer->Image }}" alt="{!! $currentOffer->Title !!}" width="400px" height="300px">
        <div class="details">
            <?php //echo date('Y-m-d H:i:s', $end_datetime);exit; ?>
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
        <a  class="product" href="https://api.whatsapp.com/send?phone={{ $agent->Phone }}" style="display: inline-block; padding:16px; border-radius: 8px; background-color: #25D366; color: #fff; text-decoration: none; font-family: sans-serif; font-size: 16px;margin-top:20px;width: 200px;">Contact us on WhatsApp</a>    
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript">

   // var date = new Date().toISOString().slice(0, 10);

    //alert(date);
    
    //var offerDate = new Date('July 29, 2023');
    var offerDate = new Date('<?php echo date('Y-m-d H:i:s', $end_datetime); ?>');
function countdown() {

    const today = new Date();

    $('#now_date').html(today);

    //If offer ends reset to new value

    if(today.getTime() < offerDate.getTime())
    {
        //console.log("True, currentdate and time are greater");
    }
    else if(today.getTime() > offerDate.getTime())
    {
        //console.log("False, currentdate and time are less");
        offerDate = resetOfferDate();
    }   

    /*if (today === offerDate) {
        //alert(today.getSeconds());
        //alert(offerDate.getSeconds());
        offerDate = resetOfferDate();
    }*/

    //offerTime will have the total millseconds 
    const offerTime = offerDate - today;
    //alert(offerTime);
    // 1 sec= 1000 ms
    // 1 min = 60 sec
    // 1 hour = 60 mins
    // 1 day = 24 hours
    const offerDays = Math.floor(offerTime / (1000 * 60 * 60 * 24));
    const offerHours = Math.floor((offerTime / (1000 * 60 * 60) % 24));
    const offerMins = Math.floor((offerTime / (1000 * 60) % 60));
    const offerSecs = Math.floor((offerTime / 1000) % 60);

    const days_el = document.getElementById("days_left");
    days_el.innerHTML = offerDays;
    const hours_el = document.getElementById("hours_left");
    hours_el.innerHTML = offerHours;
    const mins_el = document.getElementById("mins_left");
    mins_el.innerHTML = offerMins;
    const secs_el = document.getElementById("secs_left");
    secs_el.innerHTML = offerSecs;

}

function resetOfferDate() {
    window.location.reload();
    //alert('hello');
    //const futureDate = new Date();
    //futureDate.setDate(futureDate.getDate() + 5);
    //return futureDate;
}
setInterval(countdown, 1000);
</script>
</body>
</html>