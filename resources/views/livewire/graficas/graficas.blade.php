<div>
    <div
        x-data="{
        chart: null,
        init() {
            this.chart = new Chart(
                this.$refs.ganancias,
                {
                    type: 'bar',
                    data: {
                        labels: @js($chartData['ganancias_labels']),
                        datasets: [{
                            label: 'Ganancias mensuales',
                            data: @js($chartData['ganancias_values']),
                            backgroundColor: '#3B82F6',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            );
        },

        destroy() {
            this.chart?.destroy();
        }
    }"
        wire:ignore
        class="bg-white p-4 rounded-lg shadow"
    >
        <h2 class="text-lg font-semibold mb-4">
            Ganancias mensuales
        </h2>

        <div style="height: 300px">
            <canvas x-ref="ganancias"></canvas>
        </div>
    </div>

    <div class="mt-4"
        x-data="{
        chart: null,
        init() {
            this.chart = new Chart(
                this.$refs.productos,
                {
                    type: 'bar',
                    data: {
                        labels: @js($chartData['productos_labels']),
                        datasets: [{
                            label: 'Top 3 de Productos',
                            data: @js($chartData['productos_values']),
                            backgroundColor: '#3B82F6',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                }
            );
        },

        destroy() {
            this.chart?.destroy();
        }
    }"
        wire:ignore
        class="bg-white p-4 rounded-lg shadow"
    >
        <h2 class="text-lg font-semibold mb-4">
            Top 3 de Productos
        </h2>

        <div style="height: 300px">
            <canvas x-ref="productos"></canvas>
        </div>
    </div>
</div>
