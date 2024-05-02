<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo URLROOT?>/css/member/session.css">

    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>  <!-- jQuery ready function -->

    <style>
        .editb{

            margin-left: 30px;
            width: 80px;
            border-radius: 5px;
            color: #fff;
            background-color: #6a0602;
            height: 30px;
        }
    </style>
</head>


<body>
    <section id="menu"> 
        <div class="logo">
            <img src="<?php echo URLROOT?>/images/logo.png" alt="">
        </div>

        <div class="items">
            <li><i class="fa fa-user"></i></i><a href="<?php echo URLROOT?>/M_Dashboard">Dashboard</a></li>
            <li><i class="fa fa-th-large"></i><a href="<?php echo URLROOT?>/M_Sessions">Session Management</a></li>
            <li><i class="fa fa-money"></i><a href="<?php echo URLROOT?>/M_Payments">Payments</a></li>
            <li><i class="fa fa-file"></i><a href="<?php echo URLROOT?>/M_Performance">Performance Evaluation</a></li>
            <li><i class="fa fa-thumbs-up"></i><a href="<?php echo URLROOT?>/M_Attendance">Attendance Evaluation</a></li>
            <li><i class="fa fa-check-circle"></i><a href="<?php echo URLROOT?>/M_Profile">My Profile</a></li>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class="logout">
                <a href="<?php echo URLROOT; ?>/logout.php" class="logout-icon">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
            <div class="profile">
                <img src="<?php echo URLROOT?>/images/person.png" alt="">
            </div>
        </div>
        
        <h3 class="i-name">
            Session Management
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa fa-users"></i>
                <div>
                    <h3>Member ID</h3>
                    <span><?php echo $_SESSION["user_id"]; ?></span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa fa-user-plus"></i>
                <div>
                    <h3>Age Group</h3>
                    <span><?php echo $_SESSION["Age_Grp"]; ?></span>
                </div>
            </div>
        </div>

        







        <div class="i-name" style="font-size: 1.2em;">
            <h3>Club Session</h3><br>
            <h5 class="sub_name">Selected Sessions</h5>
        </div>
        <div class="sessions">
        
        <?php if (TRUE) : ?>
            <table width="100%">
                <thead>
                <tr>
                
                    <td>Session ID</td>
                    <td>Age Group</td>
                    <td>Day</td>
                    <td>Start Time</td>
                    <td>End Time</td>
                    
                    
                </tr>
                </thead>

                <tbody>


            
                <?php
                
                while($row = $data[0]->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['session_id']; ?></td>
                        <td><?php echo $row['session_name']; ?></td>
                        <td><?php echo $row['day']; ?></td>
                        <td><?php echo $row['start_time']; ?></td>
                        <td><?php echo $row['end_time']; ?></td>
                    </tr>
                <?php endwhile;?>
            </tbody>

            </table>

                </div>
            <button class="editb" type="button" id="editSessionsBtn" >Edit</button>

            <div class="modal" id="password-change-modal">
            <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3>Edit Sessions</h3>
            </div>

            <div class="modal-body">
               
                
                <div class="col-lg-12 flex-d justify-content-between align-items-center gap-2 flex-md-c">
                    <div class="col-lg-6 col-md-12">
                    <form method="post" action="<?php echo URLROOT ?>/M_Sessions/update_selection">
            
            <table width="100%">
                <thead>
                <tr>
                
                    <td>Session ID</td>
                    <td>Age Group</td>
                    <td>Day</td>
                    <td>Start Time</td>
                    <td>End Time</td>
                    <td></td>
                    
                    
                </tr>
                </thead>

                <tbody>


                
                
                <?php
                
                while($row = $data[1]->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['session_id']; ?></td>
                        <td><?php echo $row['session_name']; ?></td>
                        <td><?php echo $row['day']; ?></td>
                        <td><?php echo $row['start_time']; ?></td>
                        <td><?php echo $row['end_time']; ?></td>
                        
                        
                        <td><input type="checkbox" name="choice[]" value=<?php echo $row['session_id']; ?>> <?php echo $row['session_id']; ?></td>

                       
                      
                    </tr>
                <?php endwhile;?>
            </tbody>

            </table>

            

            <div class="col-lg-12 flex-d justify-content-between align-items-center gap-2">
                    <button class="btn btn-primary" id="password-change-submit" type ="submit" >Save</button>
                </div>
        
     
                    </div>
                    
                </div>


                
                
                

                </form>
            </div>
        </div>
    </div>
            
            

            <?php else : ?>
                <p>Not found.</p>
            <?php endif; ?>

            <script>
  var checkboxes = document.querySelectorAll('input[type=checkbox][name="choice[]"]');
  var limit = 3;

  checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
      var checkedCount = document.querySelectorAll('input[type=checkbox][name="choice[]"]:checked').length;
      if (checkedCount > limit) {
        this.checked = false;
      }
    });
  });
</script>
        </div>

<div class="i-name" style="font-size: 1.2em;">
            <h3>Private Sessions</h3><br>
            <h5 class="sub_name">Upcoming private bookings</h5>
        </div>
        </div>
        
        <div class="people">
            <table width="100%">
                <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Coach(s)</th>
                    <th>Date</th>
                    <th>Time</th>
                    
                </tr>
                </thead>
                <tbody>
                    <?php while($row = $data[2]->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['booking_id']; ?></td>
                            <td><?php echo $row['coach_names']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            
                            
                            <td><?php $time_slot= $row['slot_id']; 
                            switch ($time_slot) {
                                case 1:
                                  echo "9-10 AM";
                                  break;
                                  case 2:
                                    echo "10-11 AM";
                                    break;
                                    case 3:
                                      echo "11-12 AM";
                                      break;
                                      case 4:
                                        echo "12-1 PM";
                                        break;
                                        case 5:
                                          echo "1-2 PM";
                                          break;
                                          case 6:
                                            echo "2-3 PM";
                                            break;
                                            case 7:
                                              echo "3-4 PM";
                                              break;
                                              case 8:
                                                echo "4-5 PM";
                                                break;
                                                case 9:
                                                  echo "5-6 PM";
                                                  break;
                                                  case 10:
                                                    echo "6-7 PM";
                                                    break;
                                                    case 11:
                                                      echo "7-8 PM";
                                                      break;
                                                      case 12:
                                                        echo "8-9AM";
                                                        break;
                                  
                                default:
                                echo "wrong time slot";
                              }
                                              
                            ?></td>
                           
                        </tr>
                    <?php endwhile;?>
            </tbody>
            </table>
        </div>
    
    </section>

    
</body>

<script>
        $(document).ready(function() {
            $(document).on('click', '#editSessionsBtn', function() {
                
        // Show the modal or perform any other actions
        var today = new Date();
    var dayOfMonth = today.getDate();

    if (dayOfMonth > 50) {
        alert("You have to update your session in the first week of the month!");
    }
    else{          $('#password-change-modal').show(); }


                });
            });

            $(document).on('click', '.close', function() {
            var modal = $(this).closest('.modal');
            console.log("modal-close");

        modal.hide();
    });

    // close or modal-close both 
    $(document).on('click', '.modal-close', function() {
        var modal = $(this).closest('.modal');
        console.log("modal-close");

        modal.hide();
    });

    </script>

    <style>
        .modal {
    display: none;
    position: fixed;
    z-index: 100;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.8);
}

.modal-content {
    background-color: #ffffff;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #cccccc;
    width: 80%;
    max-width: 800px;
    position: relative;
    border-radius: 4px;

    /* mobile */
    @media screen and (max-width: 768px) {
        margin: 20% auto;
        width: 100%;
        padding: 10px;
    }
}

.modal-content .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.modal-content .close:hover,
.modal-content .close:focus {
    color: #333333;
    text-decoration: none;
    cursor: pointer;
}

.modal-content .map-canvas {
    width: 100%;
    height: 300px;
    border-radius: 4px;
    position: fixed;
}

.logout-icon {
    color: black; /* Changes icon color to black */
    font-size: 16px; /* Smaller icon size */
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none; /* Ensures no underline appears */
}

.logout-icon:hover {
    color: rgb(80, 0, 0); /* Changes hover color to grey */
}
.logout {
    margin-left: 1100px; /* This will push the logout icon to the far right */
}

.i2-name{
    color: #444a53;
    padding: 30px 30px 0 30px;
    font-size: 20px;
    font-weight: 700;
    margin-top: 10px;
}

.people {
    width: 94%;
    margin: 30px 0 30px 30px;
    overflow: auto;
    background: #fff;
    border-radius: 8px;
    display: inline-block;
    height: 400px; /* height of the table body*/
}

.people h5{
    font-weight: 600;
    font-size: 14px;
}

.people p{
    font-weight: 400;
    font-size: 13px;
    color: #787d8d;
}

table{
    border-collapse: collapse;
}

tr{
    border-bottom: 1px solid #eef0f3;
}

thead th{
    position: -webkit-sticky;
    position: sticky;
    top: 0;
    font-size: 15px;
    text-transform: uppercase;
    font-weight: 400;
    background: #d0d0d0;
    text-align: center;
    padding: 15px;
}

tbody tr td{
    font-size: 14px;
    padding: 10px 15px;

}



        </style>
    
</html>