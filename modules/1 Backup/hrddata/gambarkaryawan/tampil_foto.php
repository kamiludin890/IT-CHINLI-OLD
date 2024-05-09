<?php

$nama_gambar_tampilan=$_GET['gambar'];
echo "$nama_gambar_tampilan";

echo "<table>
<tr>
<td><img src='$nama_gambar_tampilan' width='100%'/></td>
</tr>
</table>";

?>
