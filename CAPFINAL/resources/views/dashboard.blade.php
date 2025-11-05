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
</x-app-layout>
