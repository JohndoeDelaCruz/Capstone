<x-app-layout>
    <style>
        .stat-card:hover {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">
                            Dashboard
                        </h1>
                        <p class="text-gray-600">
                            Welcome back, <span class="font-semibold text-gray-900">{{ Auth::user()->name }}</span>
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ now()->format('l') }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ now()->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Top 5 Crops Chart Section -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 md:mb-0">Top 5 Crops by Production</h3>
                        <div class="flex items-center space-x-2">
                            <label for="municipalitySelect" class="text-sm text-gray-600">Municipality:</label>
                            <select id="municipalitySelect" class="border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 text-sm">
                                <option value="LATRINIDAD">La Trinidad</option>
                                <option value="BAGUIO">Baguio City</option>
                                <option value="ITOGON">Itogon</option>
                                <option value="SABLAN">Sablan</option>
                                <option value="TUBA">Tuba</option>
                                <option value="TUBLAY">Tublay</option>
                                <option value="ATOK">Atok</option>
                                <option value="BAKUN">Bakun</option>
                                <option value="BOKOD">Bokod</option>
                                <option value="BUGUIAS">Buguias</option>
                                <option value="KABAYAN">Kabayan</option>
                                <option value="KAPANGAN">Kapangan</option>
                                <option value="KIBUNGAN">Kibungan</option>
                                <option value="MANKAYAN">Mankayan</option>
                            </select>
                        </div>
                    </div>
                    <div id="chartLoading" class="text-center py-8">
                        <svg class="inline-block animate-spin h-8 w-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600 mt-2 text-sm">Loading chart data...</p>
                    </div>
                    <div id="chartContainer" class="hidden">
                        <canvas id="topCropsChart" class="w-full" style="max-height: 400px;"></canvas>
                        <div class="mt-4 text-xs text-gray-500 border-t border-gray-200 pt-3">
                            <p><strong>Historical (2015-2024):</strong> Average annual production from actual data</p>
                            <p><strong>Predicted:</strong> Current year forecast using ML models. <a href="{{ route('predictions.predict.form') }}" class="text-blue-600 hover:underline">View multi-year trends →</a></p>
                        </div>
                    </div>
                    <div id="chartError" class="hidden text-center py-8 text-red-600">
                        <svg class="inline-block h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-sm">Failed to load chart data. Please try again.</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Grid -->
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Records Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-50 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Crop Records</p>
                            <p class="text-xl font-bold text-gray-900">{{ number_format($totalRecords) }}</p>
                            <p class="text-xs text-gray-500">Historical data points</p>
                        </div>
                    </div>
                </div>

                <!-- Municipalities Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-50 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Municipalities</p>
                            <p class="text-xl font-bold text-gray-900">{{ $municipalitiesCount }}</p>
                            <p class="text-xs text-gray-500">Covered areas</p>
                        </div>
                    </div>
                </div>

                <!-- Crop Types Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="bg-amber-50 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Crop Types</p>
                            <p class="text-xl font-bold text-gray-900">{{ $cropTypesCount }}</p>
                            <p class="text-xs text-gray-500">Different varieties</p>
                        </div>
                    </div>
                </div>

                <!-- Predictions Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-3">
                        <div class="bg-purple-50 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Predictions Made</p>
                            <p class="text-xl font-bold text-gray-900">{{ $predictionsCount }}</p>
                            <p class="text-xs text-purple-600 hover:underline cursor-pointer">View history →</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Interactive Map -->
                <a href="{{ route('map.index') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Interactive Map</h3>
                            <p class="text-sm text-gray-600 mb-3">Visualize crop production data across Benguet municipalities</p>
                            <span class="text-blue-600 text-sm font-medium hover:underline">View map →</span>
                        </div>
                    </div>
                </a>

                <!-- Manage Crop Data -->
                <a href="{{ route('crop-data.index') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="bg-green-50 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Crop Data Management</h3>
                            <p class="text-sm text-gray-600 mb-3">Import, view, and manage agricultural production records</p>
                            <span class="text-green-600 text-sm font-medium hover:underline">Manage data →</span>
                        </div>
                    </div>
                </a>

                <!-- Make Predictions -->
                <a href="{{ route('predictions.predict.form') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md">
                    <div class="flex items-start gap-4">
                        <div class="bg-purple-50 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Crop Predictions</h3>
                            <p class="text-sm text-gray-600 mb-3">Use machine learning to forecast crop production</p>
                            <span class="text-purple-600 text-sm font-medium hover:underline">Make prediction →</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tips Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">System Guidelines</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-green-600 rounded-full mt-2"></div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Data Accuracy</h4>
                            <p class="text-sm text-gray-600">Keep your crop data updated for accurate predictions and insights</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Seasonal Planning</h4>
                            <p class="text-sm text-gray-600">Use historical trends to optimize your planting schedules</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-purple-600 rounded-full mt-2"></div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Track Progress</h4>
                            <p class="text-sm text-gray-600">Compare predictions with actual yields to improve planning</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        let topCropsChart = null;

        // Load chart data for selected municipality
        async function loadTopCropsChart(municipality) {
            const loadingEl = document.getElementById('chartLoading');
            const containerEl = document.getElementById('chartContainer');
            const errorEl = document.getElementById('chartError');

            // Show loading state
            loadingEl.classList.remove('hidden');
            containerEl.classList.add('hidden');
            errorEl.classList.add('hidden');

            try {
                const response = await fetch('http://127.0.0.1:5000/api/top-crops', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ MUNICIPALITY: municipality })
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }

                const data = await response.json();

                if (!data.success) {
                    throw new Error('API returned error');
                }

                // Prepare chart data
                const crops = data.historical_top5.crops.map(crop => crop.crop);
                // Convert historical monthly average to yearly average for fair comparison
                const historicalData = data.historical_top5.crops.map(crop => crop.yearly_data.average);
                
                // Get only the current year's prediction (or next year if past December)
                const currentYear = new Date().getFullYear();
                const predictedData = data.predicted_top5.crops.map(crop => {
                    // Find the forecast for current year
                    const currentYearForecast = crop.forecasts.find(f => f.year === currentYear);
                    return currentYearForecast ? currentYearForecast.production : 0;
                });

                // Destroy existing chart if any
                if (topCropsChart) {
                    topCropsChart.destroy();
                }

                // Create new chart
                const ctx = document.getElementById('topCropsChart').getContext('2d');
                topCropsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: crops,
                        datasets: [
                            {
                                label: 'Historical Avg (2015-2024)',
                                data: historicalData,
                                backgroundColor: 'rgba(34, 197, 94, 0.7)',
                                borderColor: 'rgba(34, 197, 94, 1)',
                                borderWidth: 2
                            },
                            {
                                label: `Predicted (${currentYear})`,
                                data: predictedData,
                                backgroundColor: 'rgba(59, 130, 246, 0.7)',
                                borderColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            title: {
                                display: true,
                                text: `Top 5 Crops in ${municipality.charAt(0) + municipality.slice(1).toLowerCase().replace('trinidad', ' Trinidad')}`,
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            },
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + ' MT';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Average Production (MT)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value.toFixed(0);
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Crop Type'
                                }
                            }
                        }
                    }
                });

                // Hide loading, show chart
                loadingEl.classList.add('hidden');
                containerEl.classList.remove('hidden');

            } catch (error) {
                console.error('Error loading chart:', error);
                loadingEl.classList.add('hidden');
                errorEl.classList.remove('hidden');
            }
        }

        // Initialize chart on page load
        document.addEventListener('DOMContentLoaded', function() {
            const municipalitySelect = document.getElementById('municipalitySelect');
            
            // Load initial chart
            loadTopCropsChart(municipalitySelect.value);

            // Update chart when municipality changes
            municipalitySelect.addEventListener('change', function() {
                loadTopCropsChart(this.value);
            });
        });
    </script>
</x-app-layout>
