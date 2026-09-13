<?php
function fuzzy_tsukamoto($tw, $ds, $tj, $prd) {
    $avg = ($tw + $ds + $tj + $prd) / 4;
    $kategori = ($avg >= 80) ? 'Baik' : (($avg >= 60) ? 'Cukup' : 'Kurang');
    return ['nilai' => round($avg, 2), 'kategori' => $kategori];
}
?>
