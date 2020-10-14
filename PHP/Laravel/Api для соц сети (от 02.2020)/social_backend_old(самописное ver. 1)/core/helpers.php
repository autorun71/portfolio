<?php
function asset($asset_link){
    $asset_link = trim($asset_link, "/");
    return "/$asset_link";
}