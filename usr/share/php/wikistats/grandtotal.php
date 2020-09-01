<?php
# display the "grand total" footer table

$ggood=number_format($ggood, 0, ',', ' ');
$gtotal=number_format($gtotal, 0, ',', ' ');
$gedits=number_format($gedits, 0, ',', ' ');
$gadmins=number_format($gadmins, 0, ',', ' ');
$gusers=number_format($gusers, 0, ',', ' ');
$gausers=number_format($gausers, 0, ',', ' ');
$gimages=number_format($gimages, 0, ',', ' ');

echo <<< GRANDTOTAL
<br />
<table class="table table-striped table-bordered" id="grandtotaltable" cellpadding="0">
 <tr>
    <th colspan="6" class="grand">Grand Total (of current display)</th>
 </tr>
 <tr>
    <th class="grand">Good</th>
    <th class="grand">Total</th>
    <th class="grand">Edits</th>
    <th class="grand">Admins</th>
    <th class="grand">Users</th>
    <th class="grand">Active Users</th>
    <th class="grand">Images</th>
 </tr>
 <tr>
    <td class="grand"> ${ggood} </td>
    <td class="grand"> ${gtotal} </td>
    <td class="grand"> ${gedits} </td>
    <td class="grand"> ${gadmins} </td>
    <td class="grand"> ${gusers} </td>
    <td class="grand"> ${gausers} </td>
    <td class="grand"> ${gimages} </td>
 </tr>
</table>
GRANDTOTAL;
?>
