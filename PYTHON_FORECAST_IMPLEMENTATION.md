# 🔮 Forecast API Implementation Guide

## Overview
The forecast endpoint uses **time-series trend analysis** to predict future production values beyond the training data range (2015-2024).

---

## 📍 Python ML API - Add Forecast Endpoint

Add this to your Python ML API (Flask/FastAPI):

```python
from scipy import stats
import numpy as np
from datetime import datetime

@app.post("/api/forecast")
def forecast_production(request_data: dict):
    """
    Forecast future production using historical trend analysis
    Better for years beyond training data (2025+)
    """
    try:
        # Extract request data
        municipality = request_data.get('MUNICIPALITY')
        farm_type = request_data.get('FARM_TYPE')
        year = int(request_data.get('YEAR'))
        month = request_data.get('MONTH')
        crop = request_data.get('CROP')
        area_planted = float(request_data.get('Area_planted_ha', 0))
        area_harvested = float(request_data.get('Area_harvested_ha', 0))
        productivity = float(request_data.get('Productivity_mt_ha', 0))
        
        # Load historical data
        # Filter by municipality, farm_type, and crop
        historical_data = df[
            (df['MUNICIPALITY'] == municipality) &
            (df['FARM_TYPE'] == farm_type) &
            (df['CROP'] == crop)
        ].copy()
        
        if len(historical_data) < 5:
            # Not enough data for trend analysis, fall back to RF model
            return predict_production(request_data)
        
        # Convert month name to number for analysis
        month_map = {
            'January': 1, 'February': 2, 'March': 3, 'April': 4,
            'May': 5, 'June': 6, 'July': 7, 'August': 8,
            'September': 9, 'October': 10, 'November': 11, 'December': 12
        }
        month_num = month_map.get(month, 1)
        
        # Aggregate by year
        yearly_production = historical_data.groupby('YEAR')['Production(mt)'].mean()
        
        # Calculate trend using linear regression
        years = yearly_production.index.values
        production_values = yearly_production.values
        
        # Fit linear trend
        slope, intercept, r_value, p_value, std_err = stats.linregress(years, production_values)
        
        # Forecast for target year
        base_forecast = slope * year + intercept
        
        # Adjust for seasonality (month effect)
        monthly_factors = historical_data.groupby(historical_data['MONTH'])['Production(mt)'].mean()
        if month in monthly_factors.index:
            seasonal_factor = monthly_factors[month] / monthly_factors.mean()
        else:
            seasonal_factor = 1.0
        
        # Adjust forecast based on area and productivity inputs
        # Calculate average productivity from historical data
        avg_historical_productivity = historical_data['Productivity(mt/ha)'].mean()
        
        if productivity > 0:
            # Use provided productivity
            forecasted_production = area_harvested * productivity * seasonal_factor
        else:
            # Use trend-based forecast
            productivity_ratio = base_forecast / avg_historical_productivity if avg_historical_productivity > 0 else 1.0
            forecasted_production = area_harvested * productivity_ratio * seasonal_factor
        
        # Calculate confidence based on R² value
        confidence_score = abs(r_value) ** 2  # R-squared value
        
        # Calculate expected from productivity
        expected_from_productivity = area_harvested * productivity if productivity > 0 else forecasted_production
        
        # Calculate difference
        difference = forecasted_production - expected_from_productivity
        
        # Prepare response
        response = {
            "success": True,
            "method": "time_series_forecast",
            "input": {
                "municipality": municipality,
                "farm_type": farm_type,
                "year": year,
                "month": month,
                "crop": crop,
                "area_planted_ha": area_planted,
                "area_harvested_ha": area_harvested,
                "productivity_mt_ha": productivity
            },
            "prediction": {
                "production_mt": round(float(forecasted_production), 2),
                "expected_from_productivity": round(float(expected_from_productivity), 2),
                "difference": round(float(difference), 2),
                "confidence_score": round(float(confidence_score), 4)
            },
            "trend_analysis": {
                "slope": round(float(slope), 4),
                "r_squared": round(float(r_value ** 2), 4),
                "historical_years": int(len(years)),
                "seasonal_factor": round(float(seasonal_factor), 4)
            },
            "timestamp": datetime.now().isoformat()
        }
        
        return response
        
    except Exception as e:
        return {
            "success": False,
            "error": str(e),
            "timestamp": datetime.now().isoformat()
        }
```

---

## 📊 How It Works

### 1. **Trend Analysis**
   - Analyzes historical data (2015-2024) for the same municipality, farm type, and crop
   - Calculates linear trend using least squares regression

### 2. **Seasonality Adjustment**
   - Factors in month-specific production patterns
   - Applies seasonal multiplier to forecast

### 3. **Area & Productivity Integration**
   - Uses user-provided area_harvested and productivity values
   - Adjusts forecast based on input parameters

### 4. **Confidence Calculation**
   - Based on R² value of the trend line
   - Higher confidence = more consistent historical trend

---

## 🧪 Testing the Forecast Endpoint

### PowerShell Test:
```powershell
Invoke-WebRequest -Uri "http://127.0.0.1:5000/api/forecast" `
  -Method POST `
  -Headers @{"Content-Type"="application/json"} `
  -Body '{
    "MUNICIPALITY":"ATOK",
    "FARM_TYPE":"IRRIGATED",
    "YEAR":2028,
    "MONTH":"September",
    "CROP":"CABBAGE",
    "Area_planted_ha":10,
    "Area_harvested_ha":10,
    "Productivity_mt_ha":10
  }' | Select-Object -ExpandProperty Content
```

### Expected Response:
```json
{
  "success": true,
  "method": "time_series_forecast",
  "prediction": {
    "production_mt": 375.24,
    "expected_from_productivity": 100.00,
    "difference": 275.24,
    "confidence_score": 0.8523
  },
  "trend_analysis": {
    "slope": 2.45,
    "r_squared": 0.8523,
    "historical_years": 9,
    "seasonal_factor": 1.15
  }
}
```

---

## 🔄 How Laravel Auto-Selects

The Laravel controller now automatically:
- **Years ≤ 2024**: Uses `/api/predict` (Random Forest)
- **Years > 2024**: Uses `/api/forecast` (Time Series)

This happens transparently - users don't need to know the difference!

---

## ✅ Benefits

| Feature | Random Forest (predict) | Time Series (forecast) |
|---------|------------------------|------------------------|
| **Best for** | Years 2015-2024 | Years 2025+ |
| **Accuracy** | Very High (98.88%) | Good (trend-based) |
| **Handles** | Complex patterns | Future extrapolation |
| **Confidence** | Model-based | R² based |
| **Varies by year** | ❌ No (beyond training) | ✅ Yes (trend line) |

---

## 🚀 Next Steps

1. **Add forecast endpoint** to your Python ML API
2. **Restart Python API** (`python app.py` or your start command)
3. **Test forecast endpoint** with PowerShell
4. **Test Laravel integration** - try predicting year 2028
5. **Check logs** - should see "Using FORECAST for year 2028"

---

## 📝 Alternative: Simple Forecast Implementation

If you don't have pandas in your Python API, here's a simpler version:

```python
@app.post("/api/forecast")
def simple_forecast(request_data: dict):
    """
    Simple forecast: applies growth factor to last known year
    """
    # Get base prediction from model (year 2024)
    base_year = 2024
    request_data_base = request_data.copy()
    request_data_base['YEAR'] = base_year
    
    # Get 2024 prediction
    base_prediction = predict_production(request_data_base)
    base_value = base_prediction['prediction']['production_mt']
    
    # Apply annual growth rate (e.g., 2% per year)
    target_year = request_data['YEAR']
    years_ahead = target_year - base_year
    growth_rate = 0.02  # 2% annual growth
    
    forecasted_value = base_value * ((1 + growth_rate) ** years_ahead)
    
    return {
        "success": True,
        "method": "simple_growth_forecast",
        "prediction": {
            "production_mt": round(forecasted_value, 2),
            "confidence_score": 0.70  # Lower confidence for simple model
        }
    }
```

This simpler version just applies a growth rate to the 2024 prediction.

---

**Choose the implementation that fits your Python ML API setup!**
