<div class="tab-pane fade " id="chart" role="tabpanel" aria-labelledby="chart-tab">
    <div class="row">
        <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="row">

                        @for ($i = 0; $i < 2; $i++) <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <th colspan="4">Machine 1</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="30%">
                                            <span class="tags-overview text-center">Production Output</span>
                                            <div style="text-align: center;">
                                                <div class="mg-b-20" data-percent="">
                                                    <div id="production_output_machine_{{$i}}"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="30%">
                                            <span class="tags-overview text-center">Defect Rate</span>
                                            <div style="text-align: center;">
                                                <div class="mg-b-20"
                                                    data-percent="">
                                                    <div id="defect_rate_machine_{{$i}}"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="30%">
                                            <span class="tags-overview text-center">Efficiency</span>
                                            <div style="text-align: center;">
                                                <div class="mg-b-20"
                                                    data-percent="">
                                                    <div id="efficiency_machine_{{$i}}"></div>

                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
