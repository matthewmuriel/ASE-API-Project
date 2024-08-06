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
               <div class="row">
                    <?php
                         include("../functions.php");
                         
                         $devices=equipment_call("list_devices", "");
                         $manufacturers=equipment_call("list_manufacturers", "");

                         if (!isset($_REQUEST['msg']))
                         {
                              redirect("search.php");
                         }
                         
                         //Set up Header for search results
                         if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="Device")
                         {
                              echo '<h2>Search by Device Type('.$devices[$_REQUEST['device']].') Results:</h2><br>';
                         }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="Manufacturer")
                         {
                              echo '<h2>Search by Manufacturer('.$manufacturers[$_REQUEST['manufacturer']].') Results:</h2><br>';
                         }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="Serial"){
                              echo '<h2>Search by Serial Number('.$_REQUEST['serial'].') Results:</h2><br>';
                         }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceManufacturer"){
                              echo '<h2>Search by Device Type('.$devices[$_REQUEST['device']].') and Manufacturer('.$manufacturers[$_REQUEST['manufacturer']].') Results:</h2><br>';
                         }

                         //set up api call based on search criteria
                         if (isset($_REQUEST['msg']) && $_REQUEST['msg']=="Device"){
                              $device = $_REQUEST['device'];
                              $result = view_equipment("query_device", "did=$device");
                        
                         }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="Manufacturer"){
                              $manufacturer = $_REQUEST['manufacturer'];
                              $result = view_equipment("query_manufacturer", "mid=$manufacturer");

                         }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="Serial"){
                              $serial = trim($_REQUEST['serial']);
                              $result = view_equipment("query_serial", "sn=$serial");
                         }elseif (isset($_REQUEST['msg']) && $_REQUEST['msg']=="DeviceManufacturer"){
                              $device = $_REQUEST['device'];
                              $manufacturer = $_REQUEST['manufacturer'];
                              
                              $result = view_equipment("query_device_manufacturer", "did=$device&mid=$manufacturer");
                         }
                    ?>
               </div>
               <table class="table table-hover">
                    <thead>
                         <tr>
                              <?php
                              //build table headers based on search criteria
                                   if (isset($_REQUEST['msg']))
                                   {
                                   echo '<th scope="col">Equipment ID</th>';
                                   }
                                   if (isset($_REQUEST['msg']) && (($_REQUEST['msg'] == "Device" || $_REQUEST['msg'] == "Serial")))
                                   {
                                   echo '<th scope="col">Manufacturer</th>';
                                   }
                                   if (isset($_REQUEST['msg']) && (($_REQUEST['msg'] == "Manufacturer" || $_REQUEST['msg'] == "Serial"))){
                                   echo '<th scope="col">Device Type</th>';
                                   }
                                   if (isset($_REQUEST['msg']))
                                   {
                                   echo '<th scope="col">Serial Number</th>';
                                   }
                              ?>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                            //if not serial search
                            if (isset($_REQUEST['msg']) && $_REQUEST['msg'] != "Serial")
                            {
                                foreach ($result as $data)
                                {
                                     echo '<tr>';
                                     if (isset($_REQUEST['msg']))
                                     {
                                     echo '<td>'.$data['auto_id'].'</td>';
                                     }
                                     if (isset($_REQUEST['msg']) && ($_REQUEST['msg'] == "Device" || $_REQUEST['msg'] == "Serial"))
                                     { 
                                     echo '<td>'.$manufacturers[$data['manufacturer_id']].'</td>';
                                     }
                                     if (isset($_REQUEST['msg']) && ($_REQUEST['msg'] == "Manufacturer" || $_REQUEST['msg'] == "Serial"))
                                     {
                                     echo '<td>'.$devices[$data['device_id']].'</td>';
                                     }
                                     if (isset($_REQUEST['msg']))
                                     { 
                                     echo '<td>'.$data['serial_number'].'</td>';
                                     }
                                     echo '</tr>';
                                }
                            }else{
                                //if serial search
                                echo '<tr>';
                                if (isset($_REQUEST['msg']))
                                {
                                echo '<td>'.$result['auto_id'].'</td>';
                                }
                                if (isset($_REQUEST['msg']) && ($_REQUEST['msg'] == "Device" || $_REQUEST['msg'] == "Serial"))
                                {
                                echo '<td>'.$manufacturers[$result['manufacturer_id']].'</td>';
                                }
                                if (isset($_REQUEST['msg']) && ($_REQUEST['msg'] == "Manufacturer" || $_REQUEST['msg'] == "Serial"))
                                {
                                echo '<td>'.$devices[$result['device_id']].'</td>';
                                }
                                if (isset($_REQUEST['msg']))
                                {
                                echo '<td>'.$result['serial_number'].'</td>';
                                }
                                echo '</tr>';
                            }

                         ?>
                    </tbody>

               </table>
               <tbody></tbody>
          </div>
     </section>
</body>
</html>