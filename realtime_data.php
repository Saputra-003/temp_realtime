<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.1.2/howler.core.min.js">
    </script> -->

    <title>Real Time Data</title>
</head>

<body>
    <!-- <h2 style="text-align: center">Monitoring Suhu Real Time</h2> -->
    <div id="chartContainer" class="mt-5" style="height: 350px; max-width: 800px; margin:auto;"></div>
    <center>
        <div class="mt-3" id="temp_status"></div>
    </center>
    <!-- <div class="container" id="chartContainer" style="height: 370px; width: 100%;"></div> -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.1/chart.min.js" integrity="sha512-MC1YbhseV2uYKljGJb7icPOjzF2k6mihfApPyPhEAo3NsLUW0bpgtL4xYWK1B+1OuSrUkfOTfhxrRKCz/Jp3rQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <script>
        function beep() {
            var snd = new Audio("mixkit-censorship-beep-1082.wav");
            snd.play();

        }

        window.onload = function() {
            // console.log("ready!");
            var dps = [];
            var dataLength = 10;
            var updateInterval = 1000;
            var xVal = 0;
            var yVal = 0;


            //inisialisasi Chart
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Temperature Monitoring"
                },
                axisX: {
                    title: "Count",
                },
                axisY: {
                    title: "Temp",
                },
                data: [{
                    type: "line",
                    dataPoints: dps,
                    color: "#6600CC",
                    toolTipContent: "{y} Celcius",
                }]
            });



            var updateChart = function(count) {
                $.getJSON("http://iotsuhu.test/getdata.php", function(data) {
                    var suhu = data.suhu
                    console.log(suhu)

                    if (suhu < 29) {
                        $('#temp_status').text('Suhu : ' + suhu + ' ' + 'Normal : Aman');
                    }
                    if (suhu >= 29 && suhu < 30) {
                        $('#temp_status').text('Suhu : ' + suhu + ' ' + 'Normal : *');
                    }
                    if (suhu >= 30 && suhu < 31) {
                        $('#temp_status').text('Suhu : ' + suhu + ' ' + 'Panas : **');
                        beep();
                    }
                    if (suhu >= 31) {
                        $('#temp_status').text('Suhu : ' + suhu + ' ' + 'Sangat Panas : ***');
                        beep();
                        setTimeout(beep, 300);
                        setTimeout(beep, 600);



                    }

                    yVal = suhu
                    count = count || 1;

                    for (let j = 0; j < count; j++) {
                        dps.push({
                            x: xVal,
                            y: yVal
                        });
                        xVal++;

                    }

                    if (dps.length > dataLength) {
                        dps.shift();
                    }
                });
                chart.render();
            }

            updateChart(dataLength);
            setInterval(function() {
                updateChart()
            }, updateInterval);


        }; //end
    </script>
</body>

</html>