<?php

$dbhost_ora = 'sisga.uniandes.edu.co:1521';
$dbuser_ora = 'INTEGRACION';
$dbpass_ora = 'opzn290lh';
$dbport_ora = 1521;
$dbsid_ora = 'nife';



$conn = oci_connect($dbuser_ora, $dbpass_ora, "$dbhost_ora/$dbsid_ora");
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, "SELECT * FROM UA_PROYECTO_HORARIOS PH WHERE (PH.DESC_DEPTO LIKE '%ISIS%' OR PH.DEPARTAMENTO LIKE '%ISIS%' OR PH.TITLE LIKE '%ISIS%' OR PH.PRIMARY_INSTRUCTOR_LAST_NAME LIKE '%ISIS%' OR PH.PRIMARY_INSTRUCTOR_FIRST_NAME LIKE '%ISIS%' OR PH.PRIMARY_INSTRUCTOR_LAST_NAME2 LIKE '%ISIS%' OR PH.PRIMARY_INSTRUCTOR_FIRST_NAME2 LIKE '%ISIS%' OR PH.PRIMARY_INSTRUCTOR_LAST_NAME3 LIKE '%ISIS%' OR PH.PRIMARY_INSTRUCTOR_FIRST_NAME3 LIKE '%ISIS%' OR PH.CRN_KEY LIKE '%ISIS%' OR PH.SUBJ_CODE LIKE '%ISIS%' OR PH.CRSE_NUMBER LIKE '%ISIS%' ) ");
oci_execute($stid);

echo "<table border='1'>\n";

$ncols = oci_num_fields($stid);
echo "<tr>\n";

for ($i = 1; $i <= $ncols; $i++) {
    $column_name  = oci_field_name($stid, $i);

    echo "<td><b>$column_name</b></td>\n";
}
echo "</tr>\n";

while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";


?>