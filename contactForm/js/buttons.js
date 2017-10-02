
// Toggle between adding and removing the responsive class to topnav when the user clicks.
  function openClose () {
    var x = document.getElementById("myTopNav");  //Places myTopNav into the variable x
    // IF myTopNav class is of equal value and type to the topNav add the class responsive to myTopNav.
    // ELSE set the classname of myTopNav to TopNav
    if (x.className === "topNav") {
      x.className += " responsive";
    } else {
      x.className = "topNav";
    }
  }
