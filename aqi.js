function getAQIColorClass(aqi) {
    if (aqi <= 50) return 'aqi-good';
    if (aqi <= 100) return 'aqi-moderate';
    if (aqi <= 150) return 'aqi-unhealthy-sensitive';
    if (aqi <= 200) return 'aqi-unhealthy';
    if (aqi <= 300) return 'aqi-very-unhealthy';
    return 'aqi-hazardous';
  }
  
  
  //Show AQI function with custom cities
  function showAQI(cityList) {
    const container = document.getElementById('aqiContainer');
    const heading = document.getElementById('aqiHeading');
  
    container.innerHTML = '';
    heading.innerHTML = 'AQI of Selected Cities';
  
    cityList.forEach(city => {
        const aqi = Math.floor(Math.random() * 320);
        const colorClass = getAQIColorClass(aqi);
      
        const box = document.createElement('div');
        box.className = `aqi-box ${colorClass}`;
      
        const aqiValue = document.createElement('div');
        aqiValue.className = 'aqi-value';
        aqiValue.textContent = aqi;
      
        const cityName = document.createElement('div');
        cityName.className = 'city-name';
        cityName.textContent = city;
      
        box.appendChild(aqiValue);
        box.appendChild(cityName);
        container.appendChild(box);
      });
  }
  
  // Show initial AQI for all cities
  function showInitialAQI() {
    showAQI(cities);
  }

  function showColor(){
    const selectedColor=document.getElementById("color-picker");
    const box= document.getElementById("box1");
    box.style.backgroundColor =selectedColor.value;
    // console.log(selectedColor);
    // alert(selectedColor);
  }
  
  // Run when page is loaded
  document.addEventListener("DOMContentLoaded", showInitialAQI);
  