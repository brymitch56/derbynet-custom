<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
<title>Print Debug</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(function() {
  console.log("Document ready");
  
  // Test Ajax for design awards
  $.ajax("action.php", {
    type: 'GET',
    data: {
      query: "award.design-list"
    },
    success: function(data) {
      console.log("Design awards loaded:", data);
      var html = "<h3>Design Awards:</h3><ul>";
      if (data.awards && data.awards.length > 0) {
        for (var i = 0; i < data.awards.length; i++) {
          html += "<li>" + data.awards[i].awardname + " (ID: " + data.awards[i].awardid + ")</li>";
        }
      } else {
        html += "<li>No design awards found</li>";
      }
      html += "</ul>";
      $("#results").html(html);
    },
    error: function(xhr, status, error) {
      console.error("Error loading design awards:", status, error);
      $("#results").html("<p>Error loading design awards: " + error + "</p>");
    }
  });
});
</script>
</head>
<body>
<h1>Print Debug</h1>
<div id="results">Loading...</div>
</body>
</html>
