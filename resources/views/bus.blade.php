<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Szybkiszofer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

<div class="container-lg text-center">
    <div class="row column-gap-7">
        <div class="column" style="width:50%;">
        <h1 class="display-3">TOP10 najszybszych kierowców Szczecina</h1>
        <canvas id="barChart"></canvas>
        </div>
        <div class="column" style="width: 40%;">
        <h1 class="display-3">Porówanie ilości linii nocnych do dziennych</h1>
        <canvas id="ndChart"></canvas>
        </div>
    </div>  
    <div class="row column-gap-7">
        <div class="column" style="width:40%;">
            <h1 class="display-3">Porównanie typów autobusów</h1>
            <canvas id="typeChart"></canvas>
            </div>
            <div class="column" style="width:40%;">
                <h1 class="display-3">TOP10 najbardziej niepunktualnych autobusów</h1>
                <canvas id="punctualityChart"></canvas>
                </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script> 
 var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Prędkość (km/h)',
                    data: @json($velocities),
                    backgroundColor:[ 
                    'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'],
                    borderColor: [
                    'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx2 = document.getElementById('ndChart').getContext('2d');
        var myChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ["Day", "Night"],
                datasets: [{
                    label: 'Typ',
                    data: @json($times),
                    backgroundColor:[ 
                    'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'],
                    borderColor: [
                    'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx3 = document.getElementById('typeChart').getContext('2d');
        var myChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ["Zwykła", "Przyśpieszona", "Pośpieszna", "Zastępcza", "Dodatkowa", "Specjalna", "Turystyczna"],
                datasets: [{
                    label: 'Podtyp',
                    data: [@json($typeData["normal"]), @json($typeData["semi-fast"]), @json($typeData["fast"]), @json($typeData["replacement"]), @json($typeData["additional"]), @json($typeData["special"]), @json($typeData["tourist"])],
                    backgroundColor:[ 
                    'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'],
                    borderColor: [
                    'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctx4 = document.getElementById('punctualityChart').getContext('2d');
        var myChart = new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: @json($punctualityNames),
                datasets: [{
                    label: 'Niepunktualność',
                    data: @json($punctualityValues),
                    backgroundColor:[ 
                    'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'],
                    borderColor: [
                    'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


    </script>
</body>
</html>