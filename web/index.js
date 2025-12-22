const button = document.getElementById("przycisk");

let clickCount = 0;

function addElement(link) {
  const reflink = document.createElement("a");
  let text = document.createTextNode("Najbliższy sklep!");

  reflink.appendChild(text);

  reflink.href = link;
  reflink.target = "_blank";

  document.getElementById("wyszukaj").appendChild(reflink);

  $(function() {
    const popup = document.getElementById("test");
    popup.appendChild(reflink);
    popup.classList.add("pop_up")


    $( "#test").dialog();


});


}

const footerP = document.getElementById("footer-p");

// footerP.classList.add("footer_p");

function getLocation(callback) {
  if (!navigator.geolocation) {
    console.log("geolokalizacja nie możliwa");
    return;
  }
  navigator.geolocation.getCurrentPosition(
    (pos) => callback(pos.coords),
    (err) => console.log(err.message)
  );
}

function showPos(position) {
  lat = position.coords.latitude;
  lon = position.coords.longitude;

  return lat, lon;
}

function showErr(err) {
  console.log("Error: " + err.message);
}

async function getNearbyShopsLocation(lat, lng) {
  const query = `
        [out:json];
        (
          nwr["shop"~"supermarket|convenience|bakery|butcher"](around:2000, ${lat}, ${lng});
        );
        out center;
    `;
  const res = await fetch("https://overpass-api.de/api/interpreter", {
    method: "POST",
    body: query,
  });

  const data = await res.json();
  return data.elements;
}

const afterClick = async () => {
  console.log("nigger");
  if (clickCount === 0){
  getLocation(async (coords) => {
    
    const response = await getNearbyShopsLocation(
      coords.latitude,
      coords.longitude
    );

    const res_lat = response[0]["lat"];
    const res_lon = response[0]["lon"];
    console.log(response)
    const link = `https://maps.google.com/?q=${res_lat},${res_lon}`;
    addElement(link);
    if (!response || response.length === 0) {}
  });
}
  clickCount += 1;
};
button.addEventListener("click", afterClick);
