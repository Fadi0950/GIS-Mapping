<?php include '_includes/header.php'; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php
  // include_once("opendb.php");
  $lat = array();
  $long = array();
  $query = "SELECT * FROM asetest WHERE longitude NOT IN (0, 1, 2) AND latitude NOT IN (0, 1, 2) ";
  $result = $connection -> query($query) or die("Query error");
  $result2 = $connection -> query($query) or die("Query error");
  
 
?>

<?php include '_includes/navbar.php'; ?>

<?php include '_includes/sidebar.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Map</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Map</li>
            </ol>
          </div> <!-- /.col -->
        </div> <!-- /.row -->
      </div> <!-- /.container-fluid -->
    </div> <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
<!-- _________________________________________________________________________ -->


<script>
  var markers
function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    map.setTilt(50)

        
    // Multiple markers location, latitude, and longitude
    markers = [
        <?php
            foreach($result as $row){
              echo '["'.$row['catg_type'].'", '.$row['latitude'].', '.$row['longitude'].',"'.$row['image'].'"],';
          }
        ?>
    ];
                        
    // Info window content
    var infoWindowContent = [
        <?php 
            foreach($result as $row){ ?>
              
                ['<div class="info_content">' +
               
                '<p><?php echo "Address: [".$row['latitude']." , ".$row['longitude']."]"; ?><br>' +
                
                '<img src="<?php echo $row['image']; ?>" alt="image not found" width="300" height="300"></img><br>' +
                '</div>'

                ],

        <?php 
        }
        ?>
    ];
        
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        var trid = markers[i][0]; 

        
        var color = "";
        color2 = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";    
        color = 'images/icons/electro.png'
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            icon: {
              url: color
            },
            title: markers[i][0]
        });
        

        marker.addListener('click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
                // window.location.href = 'test1.php';
            }
        })(marker, i));

        // marker.addListener('click', (function(marker, i) {
        //     return function() {
        //       link = "transformer_device_dashboard.php?id=";
        //       window.location.href = link.concat(markers[i][0]);
              
        //     }
        // })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }

    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(10);
        google.maps.event.removeListener(boundsListener);
    });
    
}

// Load initialize function
// google.maps.event.addDomListener(window, 'load', initMap);

</script>
 
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGdcSfLwqmDVg_HLbYAJo0qkbElSM5_fc&callback=initMap&v=weekly"></script>
<style type="text/css">
  #mapCanvas {
    width: 100%;
    height: 1000px;
}
</style>

<div id="mapContainer">
      <div id="mapCanvas"></div>
    </div>


<!-- _________________________________________________________________________ -->

      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
  <!-- /.content-wrapper -->
 
<?php include '_includes/table_footer.php'; ?>
