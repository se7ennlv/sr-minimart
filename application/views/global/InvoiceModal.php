<!-- Invoice Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body p-1" id="invoiceBody">
        <table class="table table-sm table-borderless ml-3 mr-3" style="min-width: 295px; max-width: 300px">
          <thead>
            <tr>
              <td colspan="5" class="text-center">
                <h3>SR Mini Mart</h3>
              </td>
            </tr>
            <tr id="invOffice">
              <td colspan="5" class="text-center">
                <h4 id="billHeader">Guest Check</h4>
              </td>
            </tr>
            <tr>
              <td colspan="5" class="text-center">
                <strong>Bill No: <span id="invDocNo"></span></strong>
              </td>
            </tr>
            <tr>
              <td colspan="4"><strong>Date Time:</strong>&ensp;<span id="invDate"></span></td>
            </tr>
            <tr class="member">
              <td colspan="4" class="text-nowrap"><strong>Member:</strong>&ensp;<span id="invCust"></span></td>
            </tr>
            <tr>
              <td colspan="4"><strong>Cashier:</strong>&ensp;<span id="invSaleBy"></span></td>
            </tr>
            <tr>
              <td colspan="5">
                <hr class="m-0 mt-3">
              </td>
            </tr>
            <tr>
              <td colspan="2"><strong>Items</strong></td>
              <td class="text-right"><strong>Price </strong></td>
              <td class="text-center"><strong>Qty</strong></td>
              <td class="text-right"><strong>Total</strong></td>
            </tr>
            <tr>
              <td colspan="5">
                <hr class="m-0" style="border-top: 3px double #8c8b8b;">
              </td>
            </tr>
          </thead>
          <tbody id="invItems">
            <!-- dynamic data -->
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5">
                <hr class="m-0" style="border-top: 2px dashed #8c8b8b;">
              </td>
            </tr>
            <tr>
              <td colspan="4" class="text-right">Total:</td>
              <td><span id="invTotal">0.00</span></td>
            </tr>
            <tr>
              <td colspan="4" class="text-right">Disc:</td>
              <td><span id="invDisc">0</span>%</td>
            </tr>
            <tr>
              <td colspan="4" class="text-right">Paymt:</td>
              <td><span id="invPaymt">CASH</span></td>
            </tr>
            <tr>
              <td colspan="4" class="text-right text-nowrap"><strong>Grand Total:</strong></td>
              <td><strong><span id="invGrandTotal">0.00</span></strong></td>
            </tr>
            <tr>
              <td colspan="5" class="text-nowrap">
                <strong>Signature:&ensp;_________________________</strong>
              </td>
            </tr>
            <tr>
              <td colspan="5">
                <hr class="m-0" style="border-top: 2px dashed #8c8b8b;">
              </td>
            </tr>
            <tr>
              <td colspan="5" class="text-center"><strong>Thank you.</strong></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>