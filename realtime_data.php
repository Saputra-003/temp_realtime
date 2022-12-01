<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Real Time Data</title>
</head>

<body>
    <h2 style="text-align: center">Monitoring Suhu Real Time</h2>
    <div id="chartContainer" style="height: 250px; max-width: 520px; margin: Opx auto;"></div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <script>
        $(function() {
            console.log("ready!");
            var dps = [];
            var dataLength = 10;
            var updateInterval = 1000;
            var xVal = 0;
            var yVal = 0;

            //inisialisasi Chart
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Grafik Suhu Realtime"
                },
                data: [{
                    type: "line",
                    dataPoints: dps
                }]
            });

            var updateChart = function(count) {
                $.getJSON("http://iotsuhu.test/getdata.php", function(data) {
                    var suhu = data.suhu
                    console.log(suhu)
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


        }); //end
    </script>
</body>

</html>