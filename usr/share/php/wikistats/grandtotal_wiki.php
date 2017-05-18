=== Grand Total ===
{| border="1" cellpadding="2" cellspacing="0" style="width:75%; background: #f9f9f9; border: 1px solid #aaaaaa; border-collapse: collapse; white-space: nowrap;"
<?php
$ggood=number_format($ggood, 0, ',', ' ');
$gtotal=number_format($gtotal, 0, ',', ' ');
$gedits=number_format($gedits, 0, ',', ' ');
$gadmins=number_format($gadmins, 0, ',', ' ');
$gusers=number_format($gusers, 0, ',', ' ');
$gimages=number_format($gimages, 0, ',', ' ');

echo"|-
! Articles
! Total
! Edits
! Admins
! Users
! Images
|- style=\"text-align: right;\"
|'''$ggood'''
|'''$gtotal'''
|'''$gedits'''
|'''$gadmins'''
|'''$gusers'''
|'''$gimages'''";
?>

|}
