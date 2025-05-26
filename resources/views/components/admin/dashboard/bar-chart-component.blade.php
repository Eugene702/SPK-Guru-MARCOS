<div class="mt-10" x-data="{
    chartOptions: {
        type: 'bar',
        data: {
            labels: @json($barChartData->keys()),
            datasets: [{
                label: 'Visualisasi Data Penilaian Guru 5 Tahun Terakhir',
                data: @json($barChartData->values()),
                backgroundColor: ['#ffd480'],
                borderColor: ['#e6be73'],
                borderWidth: 2,
                borderRadius: 8,
                maxBarThickness: 80
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 2.2,
            layout: {
                padding: {
                    top: 15,
                    bottom: 15,
                    left: 15,
                    right: 15
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20,
                        color: '#6b7280',
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    grid: {
                        color: 'rgba(107, 114, 128, 0.12)',
                        borderDash: [3, 3]
                    }
                },
                x: {
                    ticks: {
                        color: '#374151',
                        font: {
                            size: 14,
                            weight: '600'
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'center',
                    labels: {
                        font: {
                            size: 13,
                            weight: '500'
                        },
                        color: '#4b5563',
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'rectRounded'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 212, 128, 0.95)',
                    titleColor: '#1f2937',
                    bodyColor: '#1f2937',
                    borderColor: '#ffd480',
                    borderWidth: 2,
                    cornerRadius: 8,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return 'Nilai: ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            }
        }
    },
    colorPalette: [
        '#ffd480',
        '#ffda8a',
        '#ffce70',
        '#ffe094',
        '#ffc966'
    ],
    updateChartColors() {
        const dataLength = this.chartOptions.data.datasets[0].data.length;
        this.chartOptions.data.datasets[0].backgroundColor = this.colorPalette.slice(0, dataLength);
        this.chartOptions.data.datasets[0].borderColor = this.colorPalette.slice(0, dataLength).map(color => {
            return color.replace('#ff', '#e6');
        });
    }
}" x-init="updateChartColors();
new Chart($refs.barChart, chartOptions);">

    <div class="w-full max-w-4xl mx-auto bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 bg-gradient-to-r from-amber-50 via-yellow-50 to-orange-50 border-b border-yellow-200/30">
            <div class="flex items-center justify-center space-x-3">
                <div class="flex space-x-1">
                    <div class="w-4 h-4 bg-blue-500 rounded-sm"></div>
                    <div class="w-4 h-4 bg-green-500 rounded-sm"></div>
                    <div class="w-4 h-4 bg-yellow-500 rounded-sm"></div>
                </div>
                <h2 class="text-xl font-bold text-gray-800">
                    Penilaian Guru
                </h2>
            </div>
            <p class="text-center text-sm text-gray-600 mt-2">
                Visualisasi performa penilaian dalam 5 tahun terakhir
            </p>
        </div>

        <div class="p-6">
            <div class="bg-gray-50/50 rounded-lg p-5 border border-gray-100">
                <canvas x-ref="barChart" class="w-full h-72"></canvas>
            </div>
        </div>
    </div>
</div>
