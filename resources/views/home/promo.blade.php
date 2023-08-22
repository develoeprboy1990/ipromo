<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Limited Time Offer - Book Your Room Now!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

  <!-- App favicon -->
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.jpeg')}}">
    <style> 

        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .floating-button a {
            display: block;
            width: 100px;
            height: 100px; 
            border-radius: 50%;
            text-align: center;
            line-height: 60px; 
            transition: background-color 0.3s;
        }

        .floating-button a:hover {
            background-color: darkgreen;
        }

        .floating-button img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="floating-button">
        <a href="https://api.whatsapp.com/send?phone={{ $agent->Phone }}" target="_blank">
            <img src="{{asset('assets/images/whatsapp2.png')}}" alt="WhatsApp">
        </a>
    </div>
    <div class="container">
        <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
            <img src="{{URL('/')}}/uploads/{{ $currentOffer->Image }}" alt="{!! $currentOffer->Title !!}" class="img-fluid">
        </div>
    </div>
    <main class="container">
        <div class="container text-center">
            <h1> Best deals of the day</h1>
            <h3 id="now_date"></h3> 

            <h3 class="offer">Offer ends in</h3>
            <div class="row" style="background-color: #ececec;">
                <div class="col-sm-2 p-2"></div>
                <div class="col-sm-2 p-2">
                    <div class="days">
                        <span id="days_left"> 0</span>
                        days
                    </div>
                </div>
                <div class="col-sm-2 p-2">
                    <div class="hours">
                        <span id="hours_left"> 0 </span>
                        hours
                    </div>
                </div>
                <div class="col-sm-2 p-2">
                    <div class="mins">
                        <span id="mins_left"> 0 </span>
                        mins
                    </div>
                </div>
                <div class="col-sm-2 p-2">
                    <div class="secs">
                        <span id="secs_left"> 0 </span>
                        secs
                    </div>
                </div>

            </div>
            <div class="col pt-3">
                <a class="btn btn-success btn-lg" href="https://api.whatsapp.com/send?phone={{ $agent->Phone }}">Book your room now</a>


            </div> 
        </div>

    </main><!-- Container ends here -->


    <footer class="py-5 text-center text-body-secondary bg-body-tertiary">
        <p> </p>
        <p class="mb-0">
            <a href="#"> </a>
        </p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script>
        var offerDate = new Date('<?php echo date('Y-m-d H:i:s', $end_datetime); ?>');
        const today = new Date();
        const offerEndTime = offerDate - today;
        var end_datetime = <?php echo $end_datetime; ?>;
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