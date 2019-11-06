@extends('layouts.default')
@section('content')
<div class="row text-center">
    <div class="col">
        <h3>Подкатегории</h3>
    </div>
</div>
<div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Наименование</th>
                <th>Категория</th>
                <th>
                    <a href="#add" role="button" data-toggle="modal"><i class="far fa-plus-circle text-primary"></i></a>
                    <div id="add" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <form action="/settings/add/subcategories" method="POST" id="add">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Наименование</label>
                                            <input required type="text" class="form-control" name='name' id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Категория</label>
                                            <select required class="form-control" id="category" name="category">
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <input type="submit" value="Добавить" class="btn btn-primary" />
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
            @foreach($subCategories as $subCategory)
            <tr>
                <td>{{$subCategory->id}}</td>
                <td>{{$subCategory->name}}</td>
                <td>{{$subCategory->category_name}}</td>
                <td>
                    <div class="row">
                        <div class="col flex-grow-0 pr-0">
                            <a href="#edit{{$subCategory->id}}" role="button" data-toggle="modal"><i class="far fa-pen-square text-primary"></i></a>
                            <div id="edit{{$subCategory->id}}" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="/settings/edit/subcategories" method="POST" id="edit{{$subCategory->id}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$subCategory->id}}">
                                                <div class="form-group">
                                                    <label for="name{{$subCategory->id}}">Наименование</label>
                                                    <input type="text" class="form-control" name='name' id="name{{$subCategory->id}}" value="{{$subCategory->name}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="category{{$subCategory->id}}">Категория</label>
                                                    <select required class="form-control" id="category{{$subCategory->id}}" name="category">
                                                        @foreach($categories as $category)
                                                        @if($category->id == $subCategory->category)
                                                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                                                        @else
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
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
                            <a href="#delete{{$subCategory->id}}" role="button" data-toggle="modal"><i class="far fa-trash text-danger"></i></a>
                            <div id="delete{{$subCategory->id}}" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="/settings/delete/subcategories" method="POST" id="delete{{$subCategory->id}}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{$subCategory->id}}">
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
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop