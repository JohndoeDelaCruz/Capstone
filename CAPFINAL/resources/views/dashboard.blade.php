<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Farmer Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Welcome back! Monitor your crop production and predictions</p>
            </div>
            <div class="text-sm text-gray-600">
                {{ now()->format('F d, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg shadow-lg p-8 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}! 🌾</h1>
                        <p class="text-green-100 text-lg">Your comprehensive agricultural data management system</p>
                    </div>
                    <svg class="w-24 h-24 text-green-400 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/>
                    </svg>
                </div>
            </div>

            <!-- Quick Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Crop Data Records -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Crop Data Records</h3>
                        <p class="text-3xl font-bold text-gray-800" id="total-records">{{ number_format(\App\Models\CropProduction::count()) }}</p>
                        <a href="{{ route('crop-data.index') }}" class="text-blue-600 text-sm font-medium hover:underline mt-2 inline-block">View all →</a>
                    </div>
                </div>

                <!-- Municipalities -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Municipalities</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\CropProduction::distinct('municipality')->count() }}</p>
                        <p class="text-gray-500 text-sm mt-2">Across Benguet</p>
                    </div>
                </div>

                <!-- Crop Types -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Crop Types</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\CropProduction::distinct('crop')->count() }}</p>
                        <p class="text-gray-500 text-sm mt-2">Different varieties</p>
                    </div>
                </div>

                <!-- Predictions Made -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-purple-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-gray-600 text-sm font-medium mb-1">Predictions Made</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ number_format(\App\Models\Prediction::count()) }}</p>
                        <a href="{{ route('predictions.history') }}" class="text-purple-600 text-sm font-medium hover:underline mt-2 inline-block">View history →</a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Manage Crop Data -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-green-100 p-4 rounded-lg">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Manage Crop Data</h3>
                                <p class="text-gray-600 mb-4">Import, view, and manage your agricultural production data across all municipalities.</p>
                                <a href="{{ route('crop-data.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium inline-block transition">
                                    Go to Crop Data →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Make Predictions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-blue-100 p-4 rounded-lg">
                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-2">Crop Production Predictions</h3>
                                <p class="text-gray-600 mb-4">Use our ML model to predict crop production based on historical data and conditions.</p>
                                <a href="{{ route('predictions.predict.form') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium inline-block transition">
                                    Make Prediction →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity / Tips -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🌱 Farmer Tips & Guidelines</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-semibold text-gray-800 mb-1">Data Accuracy</h4>
                            <p class="text-sm text-gray-600">Ensure your crop data is up-to-date for more accurate predictions.</p>
                        </div>
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-semibold text-gray-800 mb-1">Seasonal Planning</h4>
                            <p class="text-sm text-gray-600">Use historical data to plan your planting schedules effectively.</p>
                        </div>
                        <div class="border-l-4 border-yellow-500 pl-4">
                            <h4 class="font-semibold text-gray-800 mb-1">Track Progress</h4>
                            <p class="text-sm text-gray-600">Monitor your predictions vs actual yields to improve future planning.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
