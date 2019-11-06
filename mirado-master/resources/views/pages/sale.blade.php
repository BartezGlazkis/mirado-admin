@extends('layouts.default')
@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-9">
                    <div class="box box-danger text-center">
                        <div class="box-body box-profile">
                            <span class="big-red">При оплате картой - общие скидки уменьшать на 5% !</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-9">
                    <!-- Profile Image -->
                    <div class="box box-warning text-center">
                        <div class="box-body box-profile">
                            <span>Скидок нет на :  <strong>VIBO,   стразы,  Dorwell</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <!-- Profile Image -->
                    <div class="box box-warning text-center">
                        <div class="box-body box-profile">
                            <span>Заказы на сумму до <b>30 000</b> руб. оплачиваются <b>100%</b></span>
                        </div>
                        <div class="box-body">Сборка изделия стоимость которого менее <b>15 000</b>р. (мин. Сборка) = 1500 руб.
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 text-center">
                    <div class="box box-primary text-center">
                        <div class="box-body box-profile">
                            Скидки на все, кроме:<strong>Реджио, SOFT и компланара</strong>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr class="text-center sale-header-table">
                                    <th style="width: 100px">Категория  заказа</th>
                                    <th>Общая сумма заказа без скидки, руб.</th>
                                    <th style="width: 40px">Скидка</th>
                                </tr>
                                <tr>
                                    <td>0</td>
                                    <td>до 30 000</td>
                                    <td><span class="badge bg-green">15%</span></td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>31 000  -  50 000</td>
                                    <td><span class="badge bg-light-blue ">20%</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>51 000  - 100 000</td>
                                    <td><span class="badge bg-yellow">25%</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>свыше 100 000</td>
                                    <td><span class="badge bg-red">30%</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 text-center">
                    <div class="box box-primary text-center">
                        <div class="box-body box-profile">Скидки на:<strong>системы SOFT и компланарную</strong></div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr class="text-center sale-header-table">
                                    <th style="width: 100px">Категория  заказа</th>
                                    <th>Общая сумма заказа без скидки, руб.</th>
                                    <th style="width: 40px">Скидка</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>от 100 000 до 150 000</td>
                                    <td><span class="badge bg-green">15%</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>от 151 000</td>
                                    <td><span class="badge bg-light-blue ">20%</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 text-center">
                        <div class="box box-primary text-center">
                            <div class="box-body box-profile">
                                Скидки на:
                                <strong>РЕДЖИО</strong>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr class="text-center sale-header-table">
                                        <th style="width: 100px">Категория  заказа</th>
                                        <th>Общая сумма заказа без скидки, руб.</th>
                                        <th style="width: 40px">Скидка</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><span class="badge bg-green">10%</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
    </div>
@stop