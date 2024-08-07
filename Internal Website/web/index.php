<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Advanced Software Engineering</title>
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
                    <a href="#" class="navbar-brand">AES Inventory Database</a>
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
               <div class="row">
                   <?php
                    // Successful addition of equipment
                    if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="EquipmentAdded")
                    {
                        echo '<div class="alert alert-success" role="alert">Equipment successfully added.</div>';
                    }
                    // Successful addition of device type
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceTypeAdded")
                    {
                        echo '<div class="alert alert-success" role="alert">Device type successfully added.</div>';
                    }
                    // Successful addition of manufacturer
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="ManufacturerAdded")
                    {
                        echo '<div class="alert alert-success" role="alert">Manufacturer successfully added.</div>';
                    }
                    // successful modification of device type
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceName")
                    {
                         echo '<div class="alert alert-success" role="alert">Device name successfully modified.</div>';
                    }
                    // successful modification of device status
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceStatus")
                    {
                         echo '<div class="alert alert-success" role="alert">Device status successfully modified.</div>';
                    }
                    // successful modification of device name and status
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceNameDeviceStatus"){
                         echo '<div class="alert alert-success" role="alert">Device name and status successfully modified.</div>';
                    }
                    // successful modification of manufacturer name
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="ManufacturerName")
                    {
                         echo '<div class="alert alert-success" role="alert">Manufacturer name successfully modified.</div>';
                    }
                    // successful modification of manufacturer status
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="ManufacturerStatus")
                    {
                         echo '<div class="alert alert-success" role="alert">Manufacturer status successfully modified.</div>';
                    }
                    // successful modification of manufacturer name and status
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="ManufacturerNameManufacturerStatus")
                    {
                         echo '<div class="alert alert-success" role="alert">Manufacturer name and status successfully modified.</div>';
                    }
                    // successful modification of equipment serial number
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="Serial")
                    {
                         echo '<div class="alert alert-success" role="alert">Equipment serial number name successfully modified.</div>';
                    }
                    // successful modification of equipment device type
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="Device")
                    {
                         echo '<div class="alert alert-success" role="alert">Equipment device type successfully modified.</div>';
                    }
                    // successful modification of equipment manufacturer
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="Manufacturer")
                    {
                         echo '<div class="alert alert-success" role="alert">Equipment manufacturer successfully modified.</div>';
                    }
                    // successful modification of equipment device type and manufacturer
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceManufacturer")
                    {
                         echo '<div class="alert alert-success" role="alert">Equipment device type and manufacturer successfully modified.</div>';
                    }
                    // successful modification of equipment device type and serial number
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="SerialManufacturer")
                    {
                         echo '<div class="alert alert-success" role="alert">Equipment serial number and manufacturer successfully modified.</div>';
                    }
                    // successful modification of equipment device type, manufacturer, and serial number
                    elseif(isset($_REQUEST['msg']) && $_REQUEST['msg']=="SerialDeviceManufacturer")
                    {
                         echo '<div class="alert alert-success" role="alert">Equipment device type, manufacturer, and serial number successfully modified.</div>';
                    }
                    ?>
                        
                    <div class="col-md-4 col-sm-4">
                         <div class="feature-thumb">
                              <h3>Search Equipment</h3>
                              <p>Click here to search the equipment database.</p>
                              <a href="search.php" class="btn btn-default smoothScroll">Discover more</a>
                         </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                         <div class="feature-thumb">
                              <h3>Add Equipment</h3>
                              <p>Click here to add new equipment</p>
                             <a href="add.php" class="btn btn-default smoothScroll">Discover more</a>
                         </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                         <div class="feature-thumb">
                              <h3>Modify Equipment</h3>
                              <p>Click here to modify the equipment database</p>
                             <a href="modify.php" class="btn btn-default smoothScroll">Discover more</a>
                         </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                         <div class="feature-thumb">
                              <h3>View Equipment</h3>
                              <p>Click here to view the equipment database</p>
                             <a href="view.php" class="btn btn-default smoothScroll">Discover more</a>
                         </div>
                    </div>                    
               </div>
          </div>
     </section>
</body>
</html>