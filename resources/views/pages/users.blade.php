@extends('layouts.default')
@section('content')
<div class="container">
    <div class="d-flex flex-row-reverse bd-highligh mb-3">
        <a href="{{ route('register') }}" class="btn btn-primary p-2 bd-highlight"><i class="fas fa-fw fa-user-plus mr-3"></i>Добавить пользователя</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Почта</th>
                <th>Дата создания</th>
                <th>Роль</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->role_name}}</td>
                <td>
                    <div class="row">
                        <div class="col flex-grow-0 pr-0">
                            <a href="#edit{{$user->id}}" role="button" data-toggle="modal"><i class="far fa-pen-square text-primary"></i></a>
                            <div id="edit{{$user->id}}" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="/users/edit" method="POST" id="edit{{$user->id}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                <div class="form-group">
                                                    <label for="name{{$user->id}}">Наименование</label>
                                                    <input type="text" class="form-control" name='name' id="name{{$user->id}}" value="{{$user->name}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email{{$user->id}}">Почта</label>
                                                    <input type="text" class="form-control" name='email' id="email{{$user->id}}" value="{{$user->email}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="role">Категория</label>
                                                    <select required class="form-control" id="role" name="role">
                                                        @foreach($roles as $role)
                                                        @if($role->id == $user->role)
                                                        <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                                        @else
                                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="text-center">
                                                    <input type="submit" value="Сохранить" class="btn btn-primary" />
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col flex-grow-0">
                            <a href="#delete{{$user->id}}" role="button" data-toggle="modal"><i class="far fa-trash text-danger"></i></a>
                            <div id="delete{{$user->id}}" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="/users/delete" method="POST" id="delete{{$user->id}}">
                                                @csrf
                                                <input required type="hidden" name="id" value="{{$user->id}}">
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