# Future Production Forecast - Chart Comparison Feature

## Summary
Added a side-by-side comparison chart to the Future Production Forecast page that displays Historical Data on the left and Predicted Data on the right, similar to the Interactive Map chart design.

## Changes Made

### 1. Added Chart.js Library
- **File**: `resources/views/farmers/predictions/index.blade.php`
- **Change**: Added Chart.js CDN link before the closing `</x-app-layout>` tag
- **Library**: Chart.js v4.4.0

### 2. Added Chart Section
- **Location**: After the "Forecast Summary" section
- **Structure**: 
  - Two-column grid layout (responsive)
  - Left column: Historical Data chart (blue theme)
  - Right column: Predicted Data chart (green theme)
  - Each chart has its own canvas element

### 3. Chart Rendering Function
- **Function**: `renderComparisonCharts(historicalData, forecastData)`
- **Features**:
  - **Historical Chart**: 
    - Line chart with blue color scheme
    - Displays past production data
    - Solid line with filled area
  - **Forecast Chart**:
    - Line chart with green color scheme
    - Displays future predictions
    - Dashed line to indicate predictions
    - Filled area for visual clarity

### 4. Chart Styling
- **Historical Chart (Left)**:
  - Blue color scheme (#3B82F6)
  - Title: "Past Performance"
  - Icon: 📊 Historical Data (Past Years)
  - Background: Blue gradient
  
- **Forecast Chart (Right)**:
  - Green color scheme (#22C55E)
  - Title: "Future Forecast"
  - Icon: 🔮 Predicted Data (Future Years)
  - Background: Green gradient
  - Dashed border line for predictions

## Technical Implementation

### Data Flow
1. User selects Municipality, Crop, and Forecast Period
2. Form submits to `predictions.forecast` route
3. Controller calls `CropPredictionService::forecast()`
4. Service fetches data from ML API at `/api/forecast`
5. Response includes:
   - `forecast`: Array of future predictions
   - `historical`: Historical data (average, last_production, yearly_data)
   - `trend`: Growth rate and direction
   - `metadata`: Additional information

### Chart Initialization
```javascript
// After forecast results are displayed:
setTimeout(() => {
    renderComparisonCharts(historical, forecast);
}, 100);
```

### Chart Configuration
- **Chart Type**: Line chart
- **Responsive**: Yes
- **Aspect Ratio**: Maintained
- **Animation**: Smooth transitions
- **Tooltips**: Custom formatting with MT units
- **Axes**: Y-axis shows MT (Metric Tons), X-axis shows years

## Expected API Response Structure

The forecast API should return data in this format:

```json
{
  "success": true,
  "municipality": "ATOK",
  "crop": "BROCCOLI",
  "forecast": [
    { "year": 2025, "production": 1014.95 },
    { "year": 2026, "production": 955.69 },
    { "year": 2027, "production": 1013.50 },
    // ... more years
  ],
  "historical": {
    "average": 1200.45,
    "last_production": 1100.23,
    "last_year": 2024,
    "years_available": 10,
    "yearly_data": [
      { "year": 2020, "production": 1050.00 },
      { "year": 2021, "production": 1100.00 },
      { "year": 2022, "production": 1150.00 },
      { "year": 2023, "production": 1080.00 },
      { "year": 2024, "production": 1100.23 }
    ]
  },
  "trend": {
    "direction": "decreasing",
    "growth_rate_percent": -0.63,
    "slope": -7.25
  },
  "metadata": {
    "requested_years": 6,
    "api_response_time_ms": 245
  }
}
```

## Fallback Behavior

If `historical.yearly_data` is not available, the chart will use the historical average and create dummy data points for the last 5 years using that average value.

## Visual Design

```
┌─────────────────────────────────────────────────────────────────┐
│  Historical vs Predicted Production Comparison                  │
├──────────────────────────────┬──────────────────────────────────┤
│  📊 Historical Data          │  🔮 Predicted Data               │
│  (Past Years)                │  (Future Years)                  │
│                              │                                  │
│  [Blue Line Chart]           │  [Green Dashed Line Chart]       │
│  - Solid line                │  - Dashed line                   │
│  - Blue theme                │  - Green theme                   │
│  - Past performance          │  - Future forecast               │
│                              │                                  │
└──────────────────────────────┴──────────────────────────────────┘
```

## Files Modified

1. **resources/views/farmers/predictions/index.blade.php**
   - Added Chart.js library
   - Added chart HTML structure
   - Added `renderComparisonCharts()` function
   - Added global chart variables (historicalChart, forecastChart)

## Testing Instructions

1. Navigate to: `http://localhost/capstone/CAPFINAL/public/predictions/predict`
2. Click on the **"Future Production Forecast"** tab
3. Select:
   - Municipality: ATOK
   - Crop: BROCCOLI
   - Forecast Period: 6 Years (2025-2030)
4. Click **"Generate Forecast"** button
5. Verify that two charts appear side by side:
   - Left: Historical data in blue
   - Right: Predicted data in green

## Notes

- The charts are responsive and will stack vertically on mobile devices
- Chart instances are properly destroyed before re-rendering to prevent memory leaks
- Tooltips show values in MT (Metric Tons) format
- Y-axis automatically scales to fit the data range
- Both charts maintain consistent styling with the rest of the application

## Future Enhancements

Potential improvements:
1. Add a combined chart showing both historical and forecast in one view
2. Add confidence intervals to forecast predictions
3. Add export functionality (PNG, PDF, CSV)
4. Add comparison between multiple municipalities
5. Add year-over-year growth indicators on the charts
6. Add zoom/pan functionality for detailed analysis
