<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Stocks</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo"></script>
    <script>
        Pusher.logToConsole = true;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('PUSHER_APP_KEY') }}',
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        const chart = Highcharts.chart('container', {
            chart: { type: 'column' },
            title: { text: 'Stock en temps réel' },
            xAxis: { categories: [] },
            yAxis: { title: { text: 'Quantité' } },
            series: [{ name: 'Produits', data: [] }]
        });

        function updateChart() {
            fetch('/api/stocks')
                .then(res => res.json())
                .then(data => {
                    chart.xAxis[0].setCategories(data.map(stock => stock.product_name));
                    chart.series[0].setData(data.map(stock => stock.quantity));
                });
        }

        window.Echo.channel('stocks-channel')
            .listen('.StockUpdated', (e) => {
                updateChart();
            });

        updateChart();
    </script>
</head>
<body>
    <h1>Suivi des Stocks</h1>
    <div id="container" style="width:100%; height:400px;"></div>
</body>
</html>
