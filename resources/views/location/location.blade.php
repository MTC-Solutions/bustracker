@extends('adminlte::page')

@section('title', 'All Drivers')

@section('content_header')
@stop

@section('content')
    <div class="box">
        <form action="" method="post">
          <input type="hidden" id="getUrl" value="{{route("getLocation")}}">
          <input type="hidden" id="postUrl" value="{{route("postLocation")}}">
          @if (Auth::user()->hasRole("ROLE_DRIVER") && $driver->bus)
            <input type="hidden" id="busID" value="{{$driver->bus->id}}">
          @endif
        </form>
        <div id="map"></div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@if (Auth::user()->hasRole("ROLE_DRIVER") && $driver->bus)

    <script>

      function initMap(){

          var url = document.getElementById("postUrl").value;
          var busID = document.getElementById("busID").value;
          var map;

          var markers = []

          //First posting of datar
          if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {

              //Plot the center
              map = new google.maps.Map(document.getElementById('map'), {
                          center: {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)},
                          mapTypeId: google.maps.MapTypeId.ROADMAP,
                          zoom: 18
                  });

              //Post location data, Plot the center of the map
              axios.post(url, {
                  lat: position.coords.latitude,
                  lon: position.coords.longitude
                })
                .then(function (response) {
                  //Create markers

                  response.data.locations.forEach(location => {
                    var marker = new google.maps.Marker({
                      position: {lat: parseFloat(location.lat), lng: parseFloat(location.lon)},
                        animation: google.maps.Animation.DROP,
                        map: map,
                      });  

                    marker.set("id", location.bus_id);

                    var infoWindow
                    console.log(response.data)
                    response.data.trips.forEach(trip => {
                          response.data.buses.forEach(bus => {
                            if(trip.bus_id == bus.id){
                              tripDetail = trip.origin + " - "+ trip.destination+", "+bus.numberPlate
                          infoWindow = new google.maps.InfoWindow({content:  tripDetail, position: {lat: parseFloat(location.lat), lng: parseFloat(location.lon)}});
                            }
                          });
                        });
                            
                      infoWindow.open(map,marker);

                      markers.push(marker)
                  });

                  //Update driver's location in realtime

                  setInterval(() => {
                    if(navigator.geolocation){
                      navigator.geolocation.getCurrentPosition(function(pos){

                        //Post Data in real time
                        axios.post(url, {
                          lat: position.coords.latitude,
                          lon: position.coords.longitude
                        }).then(function (response) {
                          response.data.locations.forEach(location => {
                            markers.forEach(marker => {
                              var latLong = new google.maps.LatLng(location.lat, location.lon)
                              marker.setPosition(latLong)
                            })
                          })
                        })
                      })
                    }
                  }, 1000);
                  
                })
                .catch(function (error) {
                  alert(error);
                });
              });
          } else {
              alert("Sorry, your browser does not support HTML5 geolocation.");
          }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuvs_5dwexuPTGHE7HIZCM0a5V8OwY2og&callback=initMap" async defer></script> 
@else
    <script>
      var map;
      function initMap() {
        var url = document.getElementById("getUrl").value;

        var markers = []

        if(navigator.geolocation){
          navigator.geolocation.getCurrentPosition((position) => {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)},
                animation: google.maps.Animation.DROP,
                zoom: 15
              });
            }) 
          }

          axios.get(url)
            .then((response) => {
                    response.data.locations.forEach(location => {

                      console.log(location)
                      var marker = new google.maps.Marker({
                        position: {lat: parseFloat(location.lat), lng: parseFloat(location.lon)},
                          animation: google.maps.Animation.DROP,
                        });  

                        marker.set("id", location.bus_id);

                        console.log(response)

                        var infoWindow
                        response.data.trips.forEach(trip => {
                          response.data.buses.forEach(bus => {
                            if(trip.bus_id == bus.id){
                              tripDetail = trip.origin + " - "+ trip.destination+", "+bus.numberPlate
                          infoWindow = new google.maps.InfoWindow({content:  tripDetail, position: {lat: parseFloat(location.lat), lng: parseFloat(location.lon)}});
                            }
                          });
                        });
                            
                        infoWindow.open(map,marker);

                        markers.push(marker);
                        marker.setMap(null)
                        console.log("Hello 1")
                  });
              })
            .catch(function (error) {
              // handle error
              alert(error)
            }) 

            setInterval(() => {
              axios.get(url).then((response)=>{
                response.data.locations.forEach(location => {
                  markers.forEach(marker => {
                    if (marker.get("id") == location.bus_id) {
                      var latLong = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lon))
                      marker.setPosition(latLong)
                      marker.setMap(map)
                    }
                  });
                });
              })
            }, 1000);

        }    
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuvs_5dwexuPTGHE7HIZCM0a5V8OwY2og&callback=initMap" async defer></script> 
@endif

@stop