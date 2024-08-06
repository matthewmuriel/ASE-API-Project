<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>External Software Engineering</title>
<link href="../assets/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/font-awesome.min.css">
<link rel="stylesheet" href="../assets/css/owl.carousel.css">
<link rel="stylesheet" href="../assets/css/owl.theme.default.min.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="../assets/css/templatemo-style.css">
</head>
<body>
<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">
               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="#" class="navbar-brand">Search Equipment Database</a>
               </div>
               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-nav-first">
                         <li><a href="index.php" class="smoothScroll">Home</a></li>
                         <li><a href="search.php" class="smoothScroll">Search Equipment</a></li>
                         <li><a href="add.php" class="smoothScroll">Add Equipment</a></li>
                         <li><a href="modify.php" class="smoothScroll">Modify Equipment</a></li>
                    </ul>
               </div>
          </div>
     </section>
 <!-- HOME -->
     <section id="home">
          </div>
     </section>
     <!-- FEATURE -->
     <section id="feature">
          <div class="container">
               <?php
                    include("../functions.php");
                    $devices=equipment_call("list_devices", "");
                    $manufacturers=equipment_call("list_manufacturers", "");

                    if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="NoResults")
                    {
                         echo '<div class="alert alert-danger" role="alert">No results found.</div>';
                    }
               ?>
               <div class="row">
               <h2>Search Criteria:</h2>
               <form method="post" action="">
               <div class="text-center">
               <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary btn-lg" name="device" id="device">Device Type</button>
                    <button type="submit" class="btn btn-primary btn-lg" name="manufacturer" id="manufacturer">Manufacturer</button>
                    <button type="submit" class="btn btn-primary btn-lg" name="device_manufacturer">Device Type and Manufacturer</button>
                    <button type="submit" class="btn btn-primary btn-lg" name="serial">Serial</button>
               </div>
               </div>
               <br>
               </form>
               <?php
                         // if device type is selected display device type dropdown
                         if (isset($_POST['device']))
                         {
                              echo '<form method="post" action="">';
                              echo '<div class="form-group">';
                              echo '<label for="device">Device Type:</label>';
                              echo '<select class="form-control" id="device" name="device">';
                              foreach ($devices as $key=>$value)
                              {
                                   echo '<option value="'.$key.'">'.$value.'</option>';
                              }
                              echo '</select>';
                              echo '</div>';
                              echo '<button type="submit" class="btn btn-primary" name="search_device" id="search_device"">Search</button>';
                         }elseif (isset($_POST['manufacturer']))
                         {
                              echo '<form method="post" action="">';
                              echo '<div class="form-group">';
                              echo '<label for="manufacturer">Manufacturer:</label>';
                              echo '<select class="form-control" id="manufacturer" name="manufacturer">';
                              foreach ($manufacturers as $key=>$value)
                              {
                                   echo '<option value="'.$key.'">'.$value.'</option>';
                              }
                              echo '</select>';
                              echo '</div>';
                              echo '<button type="submit" class="btn btn-primary" name="search_manufacturer">Search</button>';
                         }elseif (isset($_POST['device_manufacturer']))
                         {
                              echo '<form method="post" action="">';
                              echo '<div class="form-group">';
                              echo '<label for="device">Device Type:</label>';
                              echo '<select class="form-control" id="device" name="device">';
                              foreach ($devices as $key=>$value)
                              {
                                   echo '<option value="'.$key.'">'.$value.'</option>';
                              }
                              echo '</select>';
                              echo '</div>';
                              echo '<div class="form-group">';
                              echo '<label for="manufacturer">Manufacturer:</label>';
                              echo '<select class="form-control" id="manufacturer" name="manufacturer">';
                              foreach ($manufacturers as $key=>$value)
                              {
                                   echo '<option value="'.$key.'">'.$value.'</option>';
                              }
                              echo '</select>';
                              echo '</div>';
                              echo '<button type="submit" class="btn btn-primary" name="search_device_manufacturer">Search</button>';
                         }elseif (isset($_POST['serial']))
                         {
                              echo '<form method="post" action="">';
                              echo '<div class="form-group">';
                              echo '<label for="serial">Serial:</label>';
                              echo '<input type="text" class="form-control" id="serial" name="serial">';
                              echo '</div>';
                              echo '<button type="submit" class="btn btn-primary" name="search_serial">Search</button>';
                         }
                    ?>
               </div>
               </div>
          </div>
     </section>

</body>
</html>
<?php
     if (isset($_POST['search_device']))
     {
          $device=$_POST['device'];
          
          $result = search_equipment("query_device", "did=$device");

          switch ($result){
               case "No Entries":
                    redirect("search.php?msg=NoResults");
                    break;
               case "Success":
                    redirect("view.php?msg=Device&device=$device");
                    break;
               case "Error":
                    redirect("search.php?msg=Error");
                    break;
               default:
                    redirect("view.php?msg=Device&device=$device");
          }  

     }elseif (isset($_POST['search_manufacturer']))
     {
          $manufacturer=$_POST['manufacturer'];
          $result = search_equipment("query_manufacturer", "mid=$manufacturer");

          switch ($result){
               case "No Entries":
                    redirect("search.php?msg=NoResults");
                    break;
               case "Success":
                    redirect("view.php?msg=Manufacturer&manufacturer=$manufacturer");
                    break;
               case "Error":
                    redirect("search.php?msg=Error");
                    break;
               default:
                    redirect("view.php?msg=Manufacturer&manufacturer=$manufacturer");
          }

     }elseif (isset($_POST['search_device_manufacturer']))
     {
          $device=$_POST['device'];
          $manufacturer=$_POST['manufacturer'];
          $result = search_equipment("query_device_manufacturer", "did=$device&mid=$manufacturer");

          switch ($result){
               case "No Entries":
                    redirect("search.php?msg=NoResults");
                    break;
               case "Success":
                    redirect("view.php?msg=DeviceManufacturer&device=$device&manufacturer=$manufacturer");
                    break;
               case "Error":
                    redirect("search.php?msg=Error");
                    break;
               default:
                    redirect("view.php?msg=DeviceManufacturer&device=$device&manufacturer=$manufacturer");
          }
     }elseif (isset($_POST['search_serial']))
     {
          $serial=$_POST['serial'];
          
          if (empty($serial))
          {
               redirect("search.php?msg=NoResults");
          }

          $result = search_equipment("query_serial", "sn=$serial");

          switch ($result){
               case "No Entries":
                    redirect("search.php?msg=NoResults");
                    break;
               case "Success":
                    redirect("view.php?msg=Serial&serial=$serial");
                    break;
               case "Error":
                    redirect("search.php?msg=Error");
                    break;
               default:
                    redirect("view.php?msg=Serial&serial=$serial");}
     }
?>