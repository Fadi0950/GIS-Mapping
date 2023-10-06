<?php include '_includes/header.php'; ?>
<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
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
  

//   if(isset($_SESSION['id'])) {
//     $Admin_Id = $_SESSION['id'];
//   }

  $stmt = $connection->prepare("INSERT INTO electrocure (trid, erid, latitude, longitude, type1, capacity, users, comment, image) 
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $stmt->bind_param("ssddsiiss", $trid, $erid, $latitude, $longitude, $type, $capacity, $users, $comment, $image_new_name);
  move_uploaded_file($_FILES['image']['tmp_name'], $target);

  if ($stmt->execute()) {
    echo "<script>alert('Record Added');</script>";
    session_abort();
  } else {
    echo "<script>alert('Failed to add record');</script>";
  }
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
            <h1 class="m-0">Electrocure</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Electrocure</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
<!-- _________________________________________________________________________ -->       

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
              <form role='form' method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                  <!-- <div class="form-group col-md-6">
                  <label for="trid">TR ID</label>
                  <input type="text" class="form-control" id="trid" name="trid" placeholder="Enter TRID" required>
                  
                </div> -->
                <div class="form-group col-md-6">
                  <label for="trid">TR ID</label>
                  <select class="form-control" id="trid" name="trid" required>
                    <option value="">--SELECT ID--</option>
                      <?php
                          // Select the trid values from table1
                          $sql = "SELECT DISTINCT trid FROM table1";
                          $result = mysqli_query($connection, $sql);
                          // Loop through the results and generate the options
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "<option value='" . $row['trid'] . "'>" . $row['trid'] . "</option>";
                          }
                      ?>
                  </select>
              </div>

              <div class="form-group col-md-6">
                  <label for="trid">ER ID</label>
                  <input type="text" class="form-control" id="erid" name="erid" placeholder="Enter ERID" required>
                  
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
                      <option value="Single Phase">Single Phase</option>
                      <option value="2 Phase">2 Phase</option>
                      <option value="3 Phase" >3 Phase</option>
                    </select>
                  </div>
                  
                <div class="form-group col-md-6">
                  <label for="latitude">Latitude</label>
                  <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter Latitude" required>
                  
                </div>


                  <div class="form-group col-md-6">
                    <label for="longitude">Longitude</label>
                    <input type="int" class="form-control" id="longitude" name="longitude" placeholder="Enter Longitude" required>
                  </div>


                <div class="form-group col-md-6">
                <label for="capacity">Capacity/KVA</label>
                <input type="text" class="form-control" id="capacity" name="capacity" placeholder="Current value N/A">
                </div>

                <div class="form-group col-md-6">
                <label for="users">No. of Users</label>
                <input type="number" class="form-control" id="users" name="users" min="0" placeholder="Users">
                </div>

                <div class="form-group col-md-6">
                <label for="comment">Comment</label>
                <input type="text" class="form-control" id="comment" name="comment" placeholder="Write Something" >
                </div>
                
                <div class="form-group col-md-6">
                <label for="image">Image (JPG/PNG only)</label>
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
        <br>

        <div class="row">
          <div class="col-12">

      <!-- table card start -->
      <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Image</th>
                    <th>TR ID</th>
                    <th>ER ID</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Type</th>
                    <th>Capacity/KVA</th>
                    <th>User</th>
                    <th>Comment</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php 
                
               

                  ?>


                  <?php
                  $q = mysqli_query($connection, "select * from electrocure") or die(mysqli_error($connection));
                  while($row = mysqli_fetch_array($q))
                  {
                    echo"<tr>";
                    echo '<td data-dd="'. $row['id'].'">
                        <img src="images/elec/'. htmlspecialchars($row['image']) .'" width="70px"  class="img-circle">
                        </td>';
                    echo"<td>{$row['trid']}</td>";
                    echo"<td>{$row['erid']}</td>";
                    echo"<td>{$row['latitude']}</td>";
                    echo"<td>{$row['longitude']}</td>";
                    echo"<td>{$row['type1']}</td>";
                    if ($row['capacity'] === NULL) {
                      echo "<td>N/A</td>";
                    } else {
                      echo "<td>{$row['capacity']}</td>";
                    }
                    echo"<td>{$row['users']}</td>";
                    echo"<td>{$row['comment']}</td>";
                    echo '<td style="text-align:center">
                    <a href="edit.php?id='.$row['id'].'" class="btn btn-info">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="delete.php" method="post" style="display: inline-block;"
                        onsubmit="return confirmDelete(event);">
                    <input type="hidden" name="id" value="'.$row['id'].'">
                    <button type="submit" class="btn btn-danger">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                  </td>';
                  echo "</tr>";
                  }
                  ?>
                  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                  <script>
                  function confirmDelete(event) {
                    event.preventDefault();
                    Swal.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                      if (result.isConfirmed) {
                        event.target.submit();
                      }
                    });
                  }
                  </script>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Image</th>
                    <th>TR ID</th>
                    <th>ER ID</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Type</th>
                    <th>Capacity/KVA</th>
                    <th>User</th>
                    <th>Comment</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

<!-- _________________________________________________________________________ -->

      </div>
    <!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->
<?php include '_includes/table_footer.php'; ?>
