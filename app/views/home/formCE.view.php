<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/home/form.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <title>Responsive Regisration Form </title>
</head>
<body>
    <div class="container">
        <header>Make Your Booking</header>

        <form action="#">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Book with coaches and bowling machines</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" placeholder="Enter your name" required>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="text" placeholder="Enter your email" required>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="number" placeholder="Enter mobile number" required>
                        </div>



                        <div class="input-field">
                            <label>NIC Number</label>
                            <input type="number" placeholder="Enter your ccupation" required>
                        </div>

                        <div class="input-field">
                            <label>Booking Date</label>
                            <input type="date" placeholder="Enter birth date" required>
                        </div>

                        <div class="input-field">
                            <label>Time Slot</label>
                            <select required>
                                <option disabled selected>Select a time slot</option>
                                <option>8.00 - 9.00</option>
                                <option>9.00 - 10.00</option>
                                <option>10.00 - 11.00</option>
                                <option>11.00 - 12.00</option>
                                <option>12.00 - 13.00</option>
                                <option>13.00 - 14.00</option>
                                <option>14.00 - 15.00</option>
                                <option>15.00 - 16.00</option>
                                <option>16.00 - 17.00</option>
                                <option>17.00 - 18.00</option>
                                <option>18.00 - 19.00</option>
                                <option>19.00 - 20.00</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>How many nets?</label>
                            <select required>
                                <option disabled selected>Select number of nets</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>How many Bowling Machines?</label>
                            <select required>
                                <option disabled selected>Select number of Bowling machines</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Whi is the coach?</label>
                            <select required>
                                <option disabled selected>Select the coach</option>
                                <option>Mr. Kamal</option>
                                <option>Mr. Namal</option>
                                <option>Mr. Wimal</option>
                                <option>Mr. Sunil</option>
                                <option>Mr. Nimal</option>
                            </select>
                        </div>


                    </div>
                </div>

                <div class="details ID">
 
                    <button class="nextBtn">
                        <span class="btnText">Submit</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div> 
            </div>
        </form>
    </div>



    <script src="<?php echo URLROOT?>/public/js/home/form.css"></script>
</body>
</html>