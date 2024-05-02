<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="<?php echo URLROOT?>/css/home/calendar.css" />
    <title>Calendar with Events</title>
  </head>
  <body>
    <div class="container">
      <div class="left">
        <div class="calendar">
          <div class="month">
            <img class="fas fa-angle-left prev" width="24" height="24" src="https://img.icons8.com/plumpy/24/left--v2.png" alt="left--v2"/>
            <div class="date">december 2015</div>
            <img class="fas fa-angle-right next" width="24" height="24" src="https://img.icons8.com/plumpy/24/right--v2.png" alt="right--v2"/>
          </div>
          <div class="weekdays">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
          </div>
          <div class="days"></div>
          <div class="goto-today">
            <div class="goto">
              <input type="text" placeholder="mm/yyyy" class="date-input" />
              <button class="goto-btn">Go</button>
            </div>
            <button class="today-btn">Today</button>
          </div>
        </div>
      </div>
      <div class="right">
        <div class="today-date">
          <div class="event-day">wed</div>
          <div class="event-date">12th december 2022</div>
        </div>
        <div class="events"></div>
        <!-- start of popup -->
        <div class="add-event-wrapper">
          <div class="add-event-header">
            <div class="title">Make a Book</div>
            <i class="fas fa-times close"></i>
          </div>          
            <div class="btn-group">
              <button onclick="location.href='<?php echo URLROOT?>/home/formC'";>With Coaches</button>
              <button onclick="location.href='<?php echo URLROOT?>/home/formCE'";>With Coaches & Equipments</button>
              <button onclick="location.href='<?php echo URLROOT?>/home/formE'";>Only net</button>
            </div>
        </div>
        <!-- end of popup -->
      </div>
      <button class="add-event">
        Click here to add a booking
      </button>
    </div>
    <script src="<?php echo URLROOT?>/js/home/calendar.js"></script>
  </body>
</html>
