<!DOCTYPE html>
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

    <main class="container">
        <div class="container text-center" id="step1">

            <div class="container">
                <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
                    <img src="{{URL('/')}}/uploads/thumbnail/{{ $currentOffer->Image }}" alt="{!! $currentOffer->Title !!}" class="img-fluid">
                </div>
            </div>
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
                <a class="btn btn-success btn-lg" id="next">Next >> </a>
            </div>
        </div>

        <div class="container text-center" id="step2" style="display:none">
            @if(!empty($addons))
            @foreach($addons as $prod)
            <div class="row justify-content-center mb-3">
                <div class="col-md-12">
                    <div class="card shadow-0 border rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                    <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                        <img src="{{asset('uploads/products/thumbnail/'.$prod->image)}}" class="w-100">
                                        <a href="#!">
                                            <div class="hover-overlay">
                                                <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <h5>{{$prod->name}}</h5>
                                    <div class="d-flex flex-row">
                                        <div class="text-danger mb-1 me-2">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <span>{{$prod->price}}</span>
                                    </div>
                                    <div class="mt-1 mb-0 text-muted small">
                                        <span>Description</span>
                                    </div>
                                    <p class="text-truncate mb-4 mb-md-0">{{$prod->desciption}}</p>
                                </div>
                                <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                    <div class="d-flex flex-row align-items-center mb-1">
                                        <h4 class="mb-1 me-1">{{$prod->price}}</h4>
                                        <!-- <span class="text-danger"><s>$20.99</s></span> -->
                                    </div>
                                    <h6 class="text-success">Click To Add </h6>
                                    <div class="d-flex flex-column mt-4">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="radio1" name="optradio" value="{{$prod->id}}" data-price="{{$prod->price}}">
                                            <label class="form-check-label" for="radio1"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
            @endif
            <div class="container mt-3">
                <input type="hidden" name="userphone" id="userphone" value="{{$customer->CustomerPhone}}">
                <input type="hidden" name="offerprice" id="offerprice" value="100">
                <input type="hidden" name="discountprice" id="discountprice" value="{{$currentOffer->discount}}">
                <input type="hidden" name="subtotalprice" id="subtotalprice" value="">
                <input type="hidden" name="totalprice" id="totalprice" value="">
                <h2>Review Order</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Offer</th>
                            <th>Discount</th>
                            <th>Add On price</th>
                            <th>Sub Total</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span id="offer">50</span></td>
                            <td><span id="discount">5</span></td>
                            <td><span id="addon">0</span></td>
                            <td><span id="subtotal">0</span></td>
                            <td><span id="total">0</span></td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-sm-4 pt-3"></div>
                <div class="col-sm-2 pt-3">
                    <a class="btn btn-info btn-lg" id="previous">
                        << Previous </a>
                </div>
                <div class="col-sm-2 pt-3">
                    <a class="btn btn-success btn-lg" href="">Avail offer >> </a>
                </div>
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
        $(document).ready(function() {
            $("#next").click(function(e) {
                e.preventDefault();
                $("#step1").hide();

                $("#step2").show();
            });
            $("#previous").click(function(e) {
                e.preventDefault();
                $("#step12").hide();
                $("#step1").show();
            });
            // Add event listener to each radio button
            var offerprice = $('#offerprice').val();
            $('#offer').text(offerprice);
            var discountprice = $('#discountprice').val();
            var subtotalprice = parseFloat(offerprice) - parseFloat(discountprice);
            $('#subtotalprice').val(subtotalprice);
            $('#subtotal').text(subtotalprice);
            $('#totalprice').val(subtotalprice);
            $('#total').text(subtotalprice);
            $('.form-check-input').on('change', function() {
                if ($(this).is(':checked')) {
                    //$('#result').text(`Selected value: ${$(this).val()}`);                    
                    var addon = $(this).data('price');
                    $('#addon').text(addon);
                    var total = parseFloat(subtotalprice) + parseFloat(addon);
                    $('#total').text(total);

                    $('#totalprice').val(total);

                }
            });
        });

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