<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration form</title> 
    <link rel="stylesheet" href="<?=URLROOT?>/css/home/forms.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  </head>
  <body>
    <section class="container">
      <header>Registration Form</header>

      <form method="post" class="form">
        
        <div class="input-box">
          <label>Full Name</label>
          <input name="name" type="text" placeholder="Enter full name" required />
        </div>

        <div class="input-box">
          <label>Email Address</label>
          <input name="email" type="email" placeholder="Enter email address" required />
        </div>

        <div class="column">
          <div class="input-box">
            <label>NIC</label>
            <input name="nic" type="text" placeholder="Enter email address" required />
          </div>
          <div class="input-box">
            <label>Contact Number</label>
            <input name="contactNo" type="number" placeholder="Enter contact number" required />
          </div>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Birth Date</label>
            <input name="dob" type="date" placeholder="Enter birth date" required />
          </div>
          <div class="input-box">
          <label>Gender</label>
          <select name="gender" id="gender">
            <option value="">Select an option</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="Other">Prefer not to say</option>
          </select>
        </div>
        </div>

        <div class="input-box">
            <label>Home Address</label>
            <input name="address" type="text" placeholder="Enter home address" required />
        </div>

        <div class="column">
            <div class="input-box">
              <label>School</label>
              <input name="school" type="text" placeholder="Enter school" required />
            </div>
            <div class="input-box">
              <label>Grade</label>
              <input name="grade" type="text" placeholder="Enter grade" required />
            </div>
        </div>

        <div class="input-box">
          <label>Password</label>
          <input name="password" type="password" placeholder="Enter password" required />
        </div>

        <br><br/>

        <div class="topic">
            <label>Parent's details</label>
        </div>

        <div class="input-box">
            <label>Name of the parent</label>
            <input name="pName" type="text" placeholder="Enter parent's name" required />
        </div>

        <div class="column">
            <div class="input-box">
              <label>Relationship to the student</label>
              <input name="pRelationship" type="text" placeholder="Enter the relationship" required />
            </div>
            <div class="input-box">
              <label>Contact Number</label>
              <input name="pContactNo" type="text" placeholder="Enter contact number" required />
            </div>
        </div>      
        <button>Submit</button>
      </form>
    </section>

    <style>
      body {
        background-image: url('<?=URLROOT?>/images/img1.jpg');
      }
    </style>
  </body>
</html>