@extends('layouts.default')
@section('content')
<div class="row text-center">
    <div class="col">
        <h3>{{$title}}</h3>
    </div>
</div>
<div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Наименование</th>
                <th>
                    <a href="#add" role="button" data-toggle="modal"><i class="far fa-plus-circle text-primary"></i></a>
                    <div id="add" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form action="/settings/add/{{$table}}" method="POST" id="add">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Наименование</label>
                                            <input required type="text" class="form-control" name='name' id="name">
                                        </div>

                                        <div class="text-center">
                                            <input required type="submit" value="Добавить" class="btn btn-primary" />
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($settings as $setting)
            <tr>
                <td>{{$setting->id}}</td>
                <td>{{$setting->name}}</td>
                <td>
                    <div class="row">
                        <div class="col flex-grow-0 pr-0">
                            <a href="#edit{{$setting->id}}" role="button" data-toggle="modal"><i class="far fa-pen-square text-primary"></i></a>
                            <div id="edit{{$setting->id}}" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="/settings/edit/{{$table}}" method="POST" id="edit{{$setting->id}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$setting->id}}">
                                                <div class="form-group">
                                                    <label for="name{{$setting->id}}">Наименование</label>
                                                    <input required type="text" class="form-control" name='name' id="name{{$setting->id}}" value="{{$setting->name}}">
                                                </div>

                                                <div class="text-center">
                                                    <input required type="submit" value="Сохранить" class="btn btn-primary" />
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col flex-grow-0">
                            <a href="#delete{{$setting->id}}" role="button" data-toggle="modal"><i class="far fa-trash text-danger"></i></a>
                            <div id="delete{{$setting->id}}" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="/settings/delete/{{$table}}" method="POST" id="delete{{$setting->id}}">
                                                @csrf
                                                <input required type="hidden" name="id" value="{{$setting->id}}">
                                                <p>Удалить?</p>
                                                <div class="text-center">
                                                    <input required type="submit" value="Удалить" class="btn btn-primary" />
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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

@stop