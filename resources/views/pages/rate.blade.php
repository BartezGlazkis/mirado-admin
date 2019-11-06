@extends('layouts.default')
@section('content')
<!-- Modal -->
<div class="modal fade" id="rate-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Изменить курс</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/rate/add" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="number" name="rate" placeholder="Курс">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<section class="content">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i>Главная</a></li>
                <li class="breadcrumb-item active">Курс</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 mb-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#rate-form">
                Изменить курс
            </button>
        </div>
        <div class="col-xs-12 col-sm-4">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <div class="row row-wrap">
                        <div class="col-sm-12">
                            <h3>История курса</h3>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Курс</th>
                                <th scope="col">Дата изменения</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($rate_values as $value)
                            <tr>
                                <td scope="row">{{$value-> rate_value}}</td>
                                <td>{{$value->created_at}}</td>
                                <td>
                                    <a href="#delete{{$value->id}}" role="button" data-toggle="modal"><i class="far fa-trash text-danger"></i></a>
                                    <div id="delete{{$value->id}}" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <form action="/rate/delete" method="POST" id="delete{{$value->id}}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$value->id}}">
                                                        <p>Удалить?</p>
                                                        <div class="text-center">
                                                            <input type="submit" value="Удалить" class="btn btn-primary" />
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8">
            <rate-chart :ratevalues="{{json_encode($rate_values_chart)}}" />
        </div>
    </div>
</section>

@stop