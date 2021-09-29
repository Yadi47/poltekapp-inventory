<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade " id="oapq" role="tabpanel" aria-labelledby="oapq-tab">
        <div class="row">
            @for ($i = 0; $i < 16; $i++) <div class="col-xl-3">
                <a href="https://demooee.grootech.id/machine-overview/detail/1" data-toggle="tooltip"
                    data-placement="top" title="" data-original-title="Detail MACHINE 1">
                    <div class="card_box position-relative mb_30 white_bg card__one shadow bd-0 rounded-20  ">
                        <div class="white_box_tittle     " style="padding:10px">
                            <div class="main-title2 ">
                                <h6 class="mb-2 nowrap ">Machine 1</h6>
                            </div>
                        </div>

                        <div class="card-body  text-center" style="padding:15px">
                            <span class="tags-overview text-center">OEE</span>
                            <div style="text-align: center;">
                                <div class="chart chart-oee machine-{{$i}}-oee mb_20" data-percent="">
                                    <span class="percent machine-{{$i}}-percent-oee">- %</span>
                                    <p class="percent-simbol">%</p>
                                    <canvas height="200" width="200"></canvas>
                                </div>
                                <div class="progress-group">
                                    <span class="tags-overview">Availability</span>
                                    <span class="tags-percent-a float-right" id="avail-machine-{{$i}}-index">- %</span>
                                    <div class="progress a mb_10">
                                        <div class="progress-bar progress-bar-a" aria-valuenow="0" aria-valuemin="0"  id="avail-machine-{{$i}}"
                                            role="progressbar">
                                        </div>
                                    </div>


                                    <span class="tags-overview">Performance</span>
                                    <span class="tags-percent-p float-right" id="perform-machine-{{$i}}-index">- %</span>
                                    <div class="progress p mb_10">
                                        <div class="progress-bar progress-bar-p " id="perform-machine-{{$i}}"
                                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 0">
                                         </div>
                                    </div>


                                    <span class="tags-overview">Quality</span>
                                    <span class="tags-percent-q float-right" id="quality-machine-{{$i}}-index">- %</span>
                                    <div class="progress q mb_10">
                                        <div class="progress-bar progress-bar-q " id="quality-machine-{{$i}}"
                                            role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"
                                            style="width: 0">
                                         </div>
                                    </div>

                                </div>

                            </div>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </a>
        </div>
        @endfor
    </div>
</div>