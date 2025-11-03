<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crop Production Prediction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="predictionForm">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Municipality -->
                            <div>
                                <label for="municipality" class="block text-sm font-medium text-gray-700">Municipality</label>
                                <select id="municipality" name="municipality" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Municipality</option>
                                    @foreach($options['municipalities'] ?? [] as $municipality)
                                        <option value="{{ $municipality }}">{{ $municipality }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Farm Type -->
                            <div>
                                <label for="farm_type" class="block text-sm font-medium text-gray-700">Farm Type</label>
                                <select id="farm_type" name="farm_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Farm Type</option>
                                    @foreach($options['farm_types'] ?? [] as $farm_type)
                                        <option value="{{ $farm_type }}">{{ $farm_type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Year -->
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                                <input type="number" id="year" name="year" min="2020" max="2030" required
                                    value="{{ date('Y') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Month -->
                            <div>
                                <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                                <select id="month" name="month" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Month</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Crop -->
                            <div>
                                <label for="crop" class="block text-sm font-medium text-gray-700">Crop</label>
                                <select id="crop" name="crop" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Crop</option>
                                    @foreach($options['crops'] ?? [] as $crop)
                                        <option value="{{ $crop }}">{{ $crop }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Area Planted -->
                            <div>
                                <label for="area_planted" class="block text-sm font-medium text-gray-700">Area Planted (hectares)</label>
                                <input type="number" id="area_planted" name="area_planted" step="0.01" min="0" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Area Harvested -->
                            <div>
                                <label for="area_harvested" class="block text-sm font-medium text-gray-700">Area Harvested (hectares)</label>
                                <input type="number" id="area_harvested" name="area_harvested" step="0.01" min="0" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Productivity -->
                            <div>
                                <label for="productivity" class="block text-sm font-medium text-gray-700">Productivity (MT/ha)</label>
                                <input type="number" id="productivity" name="productivity" step="0.01" min="0" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50">
                                <span id="btnText">Predict Production</span>
                                <svg id="spinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Results Section -->
                    <div id="results" class="mt-8 hidden">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900">Prediction Results</h3>
                        <div id="resultsContent" class="space-y-4">
                            <!-- Results will be displayed here -->
                        </div>
                    </div>

                    <!-- Error Section -->
                    <div id="errorSection" class="mt-8 hidden">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Error</h3>
                                    <div id="errorMessage" class="mt-2 text-sm text-red-700"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('predictionForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');
            const resultsDiv = document.getElementById('results');
            const resultsContent = document.getElementById('resultsContent');
            const errorSection = document.getElementById('errorSection');
            const errorMessage = document.getElementById('errorMessage');
            
            // Hide previous results/errors
            resultsDiv.classList.add('hidden');
            errorSection.classList.add('hidden');
            
            // Show loading state
            submitBtn.disabled = true;
            btnText.textContent = 'Processing...';
            spinner.classList.remove('hidden');
            
            try {
                const formData = new FormData(this);
                
                const response = await fetch('{{ route('predictions.predict') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        municipality: formData.get('municipality'),
                        farm_type: formData.get('farm_type'),
                        year: formData.get('year'),
                        month: formData.get('month'),
                        crop: formData.get('crop'),
                        area_planted: formData.get('area_planted'),
                        area_harvested: formData.get('area_harvested'),
                        productivity: formData.get('productivity'),
                    })
                });
                
                const result = await response.json();
                
                console.log('API Response:', result); // Debug log
                
                if (result.success || response.ok) {
                    // Handle the nested structure from your API
                    const prediction = result.prediction || result;
                    
                    const productionMt = prediction.production_mt || prediction.Production_mt || 0;
                    const expectedFromProductivity = prediction.expected_from_productivity || prediction.Expected_from_Productivity || 0;
                    const difference = prediction.difference || prediction.Difference || 0;
                    const confidenceScore = prediction.confidence_score || prediction.Confidence_Score || 0;
                    
                    resultsContent.innerHTML = `
                        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-6 rounded-lg border-2 border-indigo-200">
                            <div class="text-center mb-4">
                                <p class="text-sm text-gray-600 mb-1">Predicted Production</p>
                                <p class="text-4xl font-bold text-indigo-700">${parseFloat(productionMt).toFixed(2)} <span class="text-2xl">MT</span></p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Expected from Productivity</p>
                                <p class="text-2xl font-semibold text-gray-800">${parseFloat(expectedFromProductivity).toFixed(2)} <span class="text-sm text-gray-600">MT</span></p>
                            </div>
                            
                            <div class="bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Difference</p>
                                <p class="text-2xl font-semibold ${parseFloat(difference) >= 0 ? 'text-green-600' : 'text-red-600'}">
                                    ${parseFloat(difference) >= 0 ? '+' : ''}${parseFloat(difference).toFixed(2)} <span class="text-sm">MT</span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Model Confidence Score</span>
                                <span class="text-lg font-bold text-blue-700">${parseFloat(confidenceScore).toFixed(4)}</span>
                            </div>
                        </div>
                    `;
                    
                    resultsDiv.classList.remove('hidden');
                    resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else {
                    throw new Error(result.error || 'Prediction failed');
                }
                
            } catch (error) {
                console.error('Error:', error);
                errorMessage.textContent = error.message || 'An unexpected error occurred. Please try again.';
                errorSection.classList.remove('hidden');
                errorSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } finally {
                // Reset button state
                submitBtn.disabled = false;
                btnText.textContent = 'Predict Production';
                spinner.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
