<?php include '_includes/header.php';

$id = $_GET['id'];
$sql = "SELECT * FROM electrocure WHERE id = $id";
$result = mysqli_query($connection, $sql);

if (!$result) {
  die("Database query failed: " . mysqli_error($connection));
}

$row = mysqli_fetch_array($result);

if (!$row) {
  die("Data not found.");
}

if($_POST) {
    
  $trid = $_POST['trid'];
  $erid = $_POST['erid'];

  $image_name = $_FILES['image']['name'];
  $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
  $image_new_name = $erid . '.' . $image_ext;
  $target = 'images/elec/'.basename($image_new_name);

  $latitude = $_POST['latitude'];
  $longitude = $_POST['longitude'];
  $type = $_POST['type'];
  $capacity = $_POST['capacity'] !== '' ? $_POST['capacity'] : null;
  $users = $_POST['users'];
  $comment = $_POST['comment'];
  


    $stmt = $connection->prepare("UPDATE electrocure SET trid=?, erid=?, latitude=?, longitude=?, type1=?, capacity=?, users=?, comment=?, image=? WHERE id=?");


    $stmt->bind_param("ssddsisssi",$trid, $erid, $latitude, $longitude, $type, $capacity, $users, $comment, $image_new_name, $id);

    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    if ($stmt->execute()) {
        echo "<script>alert('Record Updated');</script>";
        session_abort();
    } else {
        echo "<script>alert('Failed to update record');</script>";
    }

    header("Location: index.php");

    }
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
            <h1 class="m-0">Edit</h1>

          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

<!-- sds -->

      <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role='form' method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                  <div class="form-group col-md-6">
                    <label for="trid">TR ID</label>
                    <input type="text" class="form-control" id="trid" name="trid" placeholder="<?php echo $row['trid']; ?>" value="<?php echo $row['trid']; ?>" readonly>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="erid">ER ID</label>
                    <input type="text" class="form-control" id="erid" name="erid" placeholder="<?php echo $row['erid']; ?>" value="<?php echo $row['erid']; ?>" readonly>
                  </div>
                  <!-- <script>
                 const tridInput = document.getElementById("trid");

                            tridInput.addEventListener("input", () => {
                              const tridValue = tridInput.value;

                              if (/^1G1PU\d+$/.test(tridValue)) {
                                tridInput.setCustomValidity("");
                              } else {
                                tridInput.setCustomValidity("TRID must start with '1G1PU' and only contain numbers after the prefix.");
                              }
                            });

                            // Optional: reset the validation message when the form is reset
                            const form = document.querySelector("form");
                            form.addEventListener("reset", () => {
                              tridInput.setCustomValidity("");
                            });

                </script> -->

                  <div class="form-group col-md-6">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="type" required>
                      <option value="">--SELECT--</option>
                      <option value="Single Phase" <?php echo $row['type1'] === 'Single Phase' ? 'selected' : ''; ?>>Single Phase</option>
                      <option value="2 Phase" <?php echo $row['type1'] === '2 Phase' ? 'selected' : ''; ?>>2 Phase</option>
                      <option value="3 Phase" <?php echo $row['type1'] === '3 Phase' ? 'selected' : ''; ?>>3 Phase</option>
                    </select>
                  </div>
                  
                  <div class="form-group col-md-6">
                    <label for="latitude">Latitude</label>
                    <input type="int" class="form-control" id="latitude" name="latitude" placeholder="<?php echo $row['latitude']; ?>" value="<?php echo $row['latitude']; ?>" >
                  </div>

                  <div class="form-group col-md-6">
                    <label for="longitude">Longitude</label>
                    <input type="int" class="form-control" id="longitude" name="longitude" placeholder="<?php echo $row['longitude']; ?>" value="<?php echo $row['longitude']; ?>" >
                  </div>


                  <div class="form-group col-md-6">
                    <label for="capacity">Capacity/KVA</label>
                    <input type="text" class="form-control" id="capacity" name="capacity" placeholder="N/A" value="<?php echo $row['capacity']; ?>" > 
                  </div>

                  <div class="form-group col-md-6">
                    <label for="users">Users</label>
                    <input type="number" class="form-control" id="users" name="users" min="0" placeholder="<?php echo $row['users']; ?>" value="<?php echo $row['users']; ?>" >
                  </div>

                <div class="form-group col-md-6">
                <label for="comment">Comment</label>
                <input type="text" class="form-control" id="comment" name="comment" placeholder="Write Something" >
                </div>

                  <div class="form-group col-md-6">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image" required>
                  </div>


                </div>
                <!-- /.card-body -->
              </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
       
    <!-- _________________________________________________________________________ -->
</div>
    <!-- /.container-fluid -->
    </section>
    </div>
  <!-- /.content-wrapper -->
<?php include '_includes/footer.php'; ?>