<?php

// TODO: classes
$mesh_order["mechanical"] = 2;
$mesh_order["heat_conduction"] = 1;

$problem_name["mechanical"] = "mechanical";
$problem_name["heat_conduction"] = "thermal";

$primary_field["mechanical"] = "displacements";
$primary_field["heat_conduction"] = "T";

$default_bc["mechanical"] = "fixed";
$default_bc["heat_conduction"] = "adiabatic";



function problem_hash() {
  global $username, $id;
  if (file_exists("case.fee")) {
    return md5_file("case.fee");
  } else {
    return md5_file("../data/{$username}/cases/{$id}/case.fee");
  }
}

function update_mesh_in_fee() {
  global $username;
  global $id;
  global $mesh_hash;
  global $problem;
  global $mesh_order;
  $real_mesh_hash = mesh_hash();
  if ($real_mesh_hash != $mesh_hash) {
    // TODO: lock
    $current = fopen("../data/{$username}/cases/{$id}/case.fee", "r");
    $new = fopen("../data/{$username}/cases/{$id}/new.fee", "w");
    if ($current && $new) {
      while (($line = fgets($current)) !== false) {
        if (strncmp("READ_MESH", $line, 9) == 0) {
          if ($mesh_order[$problem] == 1) {
            fwrite($new, "READ_MESH meshes/{$real_mesh_hash}.msh\n");
          } else {
            fwrite($new, "READ_MESH meshes/{$real_mesh_hash}-{$mesh_order[$problem]}.msh\n");
          }
        } else {
          fwrite($new, $line);
        }
      }
      fclose($current);
      fclose($new);

      if (rename("../data/{$username}/cases/{$id}/new.fee", "../data/{$username}/cases/{$id}/case.fee") !== true) {
        return_error_json("Cannot update fee");
      }
    } else {
      return_error_json("cannot open case.fee");
    }
  }
}


?>
