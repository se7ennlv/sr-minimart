<div class="container text-center">
    <div id="paymentModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="payments" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title md-numer-title font-weight-bold text-primary" id="payments">Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="p-3">
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-primary"><i class="fas fa-hand-holding-usd fa-2x"></i></span>
                            </div>
                            <select name="paymt" id="paymt" class="form-control form-control-lg" onchange="paymtOnChange($(this).val());">
                                <!-- dynamic data -->
                            </select>
                        </div>
                    </div>
                    <div>
                        <table class="table table-bordered hand mb-0" id="tbNumeral">
                            <tbody>
                                <tr>
                                    <td colspan="4" class="bg-gray-200 text-right text-black-50 font-weight-bold money-screen" style="height: 3rem; vertical-align: middle; font-size: 3rem"></td>
                                </tr>
                                <tr>
                                    <td class="money-clicked p-0 disabled" data-val="7" data-money="0" aria-disabled="true">
                                        <button class="btn btn-light btn-number">
                                            <h4>7</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked p-0" data-val="8" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>8</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked p-0" data-val="9" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>9</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked text-center" data-val="1000" data-money="1">
                                        <button class="btn btn-number text-primary font-weight-bold">1,000</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="money-clicked p-0" data-val="4" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>4</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked p-0" data-val="5" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>5</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked p-0" data-val="6" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>6</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked text-center p-0" data-val="500" data-money="1">
                                        <button class="btn btn-number text-primary font-weight-bold">500</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="money-clicked p-0" data-val="1" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>1</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked p-0" data-val="2" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>2</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked p-0" data-val="3" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>3</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked text-center p-0" data-val="100" data-money="1">
                                        <button class="btn btn-number text-primary font-weight-bold">100</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="money-clicked p-0" data-val="c" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>C</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked p-0" data-val="0" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <h4>0</h4>
                                        </button>
                                    </td>
                                    <td class="money-clicked p-0" data-val="Backspace" data-money="0">
                                        <button class="btn btn-light btn-number">
                                            <i class="fas fa-backspace fa-2x"></i>
                                        </button>
                                    </td>
                                    <td class="money-clicked text-center p-0" data-val="full" data-money="0">
                                        <button class="btn btn-number text-primary font-weight-bold">Full</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="p-3">
                    <button onclick="submitPayment();" type="button" id="btnSubmit" class="btn btn-primary btn-lg btn-block p-3">
                        <h3>Submit</h3>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>