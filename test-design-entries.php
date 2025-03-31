<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('inc/data.inc');

echo "<h1>Design Entries Test</h1>";

// Check if DesignEntries table exists
$stmt = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='DesignEntries'");
$table_exists = ($stmt->fetchColumn() !== false);
echo "<p>DesignEntries table exists: " . ($table_exists ? "YES" : "NO") . "</p>";

if ($table_exists) {
    // Count entries
    $count = $db->query("SELECT COUNT(*) FROM DesignEntries")->fetchColumn();
    echo "<p>Total design entries: $count</p>";
    
    // List all entries
    echo "<h2>All Design Entries</h2>";
    echo "<table border='1'>";
    echo "<tr><th>EntryID</th><th>RacerID</th><th>AwardID</th><th>Racer Name</th><th>Award Name</th></tr>";
    
    $stmt = $db->query("SELECT de.entryid, de.racerid, de.awardid, 
                        r.firstname || ' ' || r.lastname as racer_name,
                        a.awardname
                        FROM DesignEntries de
                        LEFT JOIN RegistrationInfo r ON de.racerid = r.racerid
                        LEFT JOIN Awards a ON de.awardid = a.awardid
                        ORDER BY de.awardid, r.lastname, r.firstname");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['entryid'] . "</td>";
        echo "<td>" . $row['racerid'] . "</td>";
        echo "<td>" . $row['awardid'] . "</td>";
        echo "<td>" . $row['racer_name'] . "</td>";
        echo "<td>" . $row['awardname'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // List design awards
    echo "<h2>Design Awards</h2>";
    echo "<table border='1'>";
    echo "<tr><th>AwardID</th><th>Award Name</th><th>Award Type</th><th>Entry Count</th></tr>";
    
    $stmt = $db->query("SELECT a.awardid, a.awardname, at.awardtype,
                        (SELECT COUNT(*) FROM DesignEntries WHERE awardid = a.awardid) as entry_count
                        FROM Awards a
                        INNER JOIN AwardTypes at ON a.awardtypeid = at.awardtypeid
                        WHERE at.awardtype IN ('Design General', 'Design Trophy')
                        ORDER BY a.awardname");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['awardid'] . "</td>";
        echo "<td>" . $row['awardname'] . "</td>";
        echo "<td>" . $row['awardtype'] . "</td>";
        echo "<td>" . $row['entry_count'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Check award types
    echo "<h2>Award Types</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Type</th><th>Count</th></tr>";
    
    $stmt = $db->query("SELECT awardtypeid, awardtype, 
                       (SELECT COUNT(*) FROM Awards WHERE awardtypeid = AwardTypes.awardtypeid) as count
                       FROM AwardTypes
                       ORDER BY awardtype");
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['awardtypeid'] . "</td>";
        echo "<td>" . $row['awardtype'] . "</td>";
        echo "<td>" . $row['count'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
}
?>
