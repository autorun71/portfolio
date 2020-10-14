<?php


if (!empty($data['angular_patch_dir'])){
    $path =  '../' . $data['angular_patch_dir'];
    if (file_exists($path))
    require $path;


}
