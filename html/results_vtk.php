<?php
// This file is part of SunCAE.
// SunCAE is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
// SunCAE is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

include("../conf.php");
include("../auths/{$auth}/auth.php");
include("common.php");
include("case.php");

$hash = $_GET["hash"];

$vtk_path = "{$case_dir}/run/{$hash}.vtk";
if (file_exists($vtk_path)) {
  header("Content-Description: File Transfer");
  header("Content-Type: application/octet-stream");
  header("Content-Disposition: attachment; filename={$hash}.vtk");
  header("Content-Length: " . filesize($vtk_path));
  ob_clean();
  flush();
  readfile($vtk_path);
}
