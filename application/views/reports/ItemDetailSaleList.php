<table class="table table-wrapper table-sm" width="100%" cellspacing="0" id="detailTable">
    <thead>
        <tr>
            <th colspan="8">Mini Mart</th>
        </tr>
        <tr>
            <th colspan="8">Item Detail Sales Reports</th>
        </tr>
        <tr>
            <th colspan="8">Date : <span><?= $fDate; ?></span> To <span><?= $tDate; ?></span></th>
        </tr>
        <tr class="bg-gray-400">
            <th class="text-right">Bill No.</th>
            <th class="text-center">Emp ID</th>
            <th class="text-center">Emp Name</th>
            <th class="text-center">Paymt Type</th>
            <th class="text-right">Item Name</th>
            <th class="text-right">Price</th>
            <th class="text-center">Qty</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $grandTotal = 0;
        foreach ($docs as $doc) : ?>
            <tr class="bg-light">
                <td class="text-right"><strong><?= nice_date($doc->TranCreatedAt, 'Y-m-d'); ?> | <?= $doc->TranDocNo; ?></strong></td>
                <td class="text-center"><?= $doc->TranCustID; ?></td>
                <td class="text-center"><?= $doc->TranCustName; ?></td>
                <td class="text-center"><?= $doc->TranPaymentCode; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php
                $subTotal = 0;
                foreach ($datas as $data) :
                    ?>
                <?php if ($doc->TranDocNo === $data->DSDocNo) :
                            $subTotal += $data->DSTotalPrice;
                            ?>
                    <tr class="table-borderless">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
              
                        <td class="text-right"><?= $data->DSItemName; ?></td>
                        <td class="text-nowrap text-right">
                            <?= number_format($data->DSItemPrice, 2, '.', ','); ?>
                        </td>
                        <td class="text-nowrap text-center">
                            <?= number_format($data->DSItemQty); ?>
                        </td>
                        <td class="text-nowrap text-right">
                            <strong><?= number_format($data->DSTotalPrice, 2, '.', ','); ?></strong>
                        </td>
                    </tr>


                <?php endif; ?>
            <?php endforeach; ?>

            <tr>
                <td colspan="6"></td>
                <td class="text-right"><strong>Sub Total</strong></td>
                <td class="text-right"><strong><?= $subTotal; ?></strong></td>
            </tr>

        <?php $grandTotal += $subTotal; endforeach; ?>

        <tr>
            <td colspan="6"></td>
            <td class="text-right"><strong>Grand Total</strong></td>
            <td class="text-right"><strong><?= floatval($grandTotal); ?></strong></td>
        </tr>

    </tbody>
</table>

<script>
    function onExport() {
        $('#detailTable').tableExport({
            type: 'excel',
            exportDataType: 'all',
            exportOptions: {
                fileName: 'Item Detial Sales Reports'
            }
        });
    }
</script>