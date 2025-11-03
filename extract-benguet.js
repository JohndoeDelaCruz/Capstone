const fs = require('fs');

// Read the full Philippines GeoJSON
console.log('Reading Philippines GeoJSON file...');
const fullData = JSON.parse(fs.readFileSync('c:/xampp/htdocs/capstone/gadm41_PHL_2.json', 'utf8'));

console.log('Total features:', fullData.features.length);

// Filter only Benguet municipalities
const benguetFeatures = fullData.features.filter(feature => {
    const province = feature.properties.NAME_1;
    return province === 'Benguet';
});

console.log('Benguet municipalities found:', benguetFeatures.length);

// List all Benguet municipalities
benguetFeatures.forEach(feature => {
    console.log('- ' + feature.properties.NAME_2);
});

// Create new GeoJSON with only Benguet
const benguetGeoJSON = {
    type: 'FeatureCollection',
    features: benguetFeatures.map(feature => ({
        type: 'Feature',
        properties: {
            name: feature.properties.NAME_2.toUpperCase(),
            province: feature.properties.NAME_1,
            country: feature.properties.COUNTRY,
            type: feature.properties.ENGTYPE_2
        },
        geometry: feature.geometry
    }))
};

// Save to project
const outputPath = 'c:/xampp/htdocs/capstone/CAPFINAL/public/data/benguet.geojson';
fs.writeFileSync(outputPath, JSON.stringify(benguetGeoJSON, null, 2));

console.log('\n✅ Benguet GeoJSON saved to:', outputPath);
console.log('File size:', (fs.statSync(outputPath).size / 1024).toFixed(2), 'KB');
