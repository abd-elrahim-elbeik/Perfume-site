@extends('layouts.master')
@section('css')
    @toastr_css


@section('title')
    {{ trans('Product_trans.title_page') }}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    {{ trans('Product_trans.title_page') }}
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">



    <div class="col-xl-12 mb-30">
        <h3>{{ trans('main_trans.Product') }}</h3>

        <div class="card card-statistics h-100">

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                    {{ trans('Product_trans.add_Product') }}
                </button>

                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('Product_trans.Name') }}</th>
                                <th>{{ trans('Product_trans.Description') }}</th>
                                <th>{{ trans('Product_trans.Category') }}</th>
                                <th>{{ trans('Product_trans.Sar_price') }}</th>
                                <th>{{ trans('Product_trans.Usd_price') }}</th>
                                <th>{{ trans('Product_trans.Quantity') }}</th>
                                <th>{{ trans('Product_trans.Image') }}</th>
                                <th>{{ trans('Product_trans.Processes') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($products as $product)
                                @php
                                    $images = explode('|', $product->image);
                                @endphp
                                <tr>
                                    <?php $i++; ?>
                                    <td>{{ $i }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->sar_price }}</td>
                                    <td>{{ $product->usd_price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        @foreach ($images as $image)
                                            <img src="{{ URL::to($image) }}" style="width: 80px" alt="">
                                        @endforeach
                                    </td>
                                    {{-- {{ $product->quantity }} --}}
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $product->id }}"
                                            title="{{ trans('Product_trans.Edit') }}"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $product->id }}"
                                            title="{{ trans('Product_trans.Delete') }}"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- edit_modal_product -->
                                <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    {{ trans('Product_trans.edit_Product') }}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- edit_form -->
                                                <form action="{{ route('products.update', $product->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    {{ method_field('patch') }}
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="name"
                                                                class="mr-sm-2">{{ trans('Product_trans.stage_name_ar') }}
                                                                :</label>
                                                            <input id="name" type="text" name="name_ar"
                                                                class="form-control"
                                                                value="{{ $product->getTranslation('name', 'ar') }}"
                                                                required>
                                                            <input id="id" type="hidden" name="id"
                                                                class="form-control" value="{{ $product->id }}">
                                                        </div>
                                                        <div class="col">
                                                            <label for="name_en"
                                                                class="mr-sm-2">{{ trans('Product_trans.stage_name_en') }}
                                                                :</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $product->getTranslation('name', 'en') }}"
                                                                name="name_en" required>
                                                        </div>
                                                    </div><br>
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="name"
                                                                class="mr-sm-2">{{ trans('Product_trans.stage_description_ar') }}
                                                                :</label>
                                                            <input id="name" type="text" name="description_ar"
                                                                class="form-control"
                                                                value="{{ $product->getTranslation('description', 'ar') }}"
                                                                required>
                                                            <input id="id" type="hidden" name="id"
                                                                class="form-control" value="{{ $product->id }}">
                                                        </div>
                                                        <div class="col">
                                                            <label for="name_en"
                                                                class="mr-sm-2">{{ trans('Product_trans.stage_description_en') }}
                                                                :</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $product->getTranslation('description', 'en') }}"
                                                                name="description_en" required>
                                                        </div>
                                                    </div><br>

                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="sar_price"
                                                                class="mr-sm-2">{{ trans('Product_trans.Sar_price') }}
                                                                :</label>
                                                            <input id="name" type="number" name="sar_price"
                                                                value="{{ $product->sar_price }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col">
                                                            <label for="usd_price"
                                                                class="mr-sm-2">{{ trans('Product_trans.Usd_price') }}
                                                                :</label>
                                                            <input type="number" class="form-control"
                                                                name="usd_price" value="{{ $product->usd_price }}">
                                                        </div>
                                                    </div><br>

                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="quantity"
                                                                class="mr-sm-2">{{ trans('Product_trans.Quantity') }}
                                                                :</label>
                                                            <input id="name" type="number" name="quantity"
                                                                value="{{ $product->quantity }}"
                                                                class="form-control">
                                                        </div>

                                                        <div class="col">
                                                            <label for="category_id"
                                                                class="mr-sm-2">{{ trans('Product_trans.Category') }}
                                                                :</label>


                                                            <div class="box">
                                                                <select class="fancyselect" name="category_id">
                                                                    {{-- <option value="{{ $product->category->id }}" selected disabled>
                                                                        {{ $product->category->name }}
                                                                    </option> --}}
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category->id }}" @if ($category->id == $product->category->id) selected @endif>
                                                                            {{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div><br>

                                                    <div class="form-group">
                                                        <label>{{ trans('Product_trans.Image') }}</label>
                                                        <input type="file" name="images[]"
                                                            class="form-control image" accept="image/*" multiple>
                                                    </div><br>
                                                    @foreach ($images as $image)
                                                        <img src="{{ URL::to($image) }}" style="width: 100px" alt="">
                                                    @endforeach

                                                    <br><br>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('Product_trans.Close') }}</button>
                                                        <button type="submit"
                                                            class="btn btn-success">{{ trans('Product_trans.submit') }}</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- delete_modal_Grade -->
                            <div class="modal fade" id="delete{{ $product->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                               <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                       <div class="modal-header">
                                           <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                               id="exampleModalLabel">
                                               {{ trans('Product_trans.delete_Product') }}
                                           </h5>
                                           <button type="button" class="close" data-dismiss="modal"
                                                   aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>
                                       <div class="modal-body">
                                           <form action="{{ route('products.destroy', 'test') }}"
                                                 method="post">
                                               {{ method_field('Delete') }}
                                               @csrf
                                               {{ trans('Product_trans.Warning_Product') }}

                                               <input id="id" type="hidden" name="id" class="form-control"
                                                      value="{{ $product->id }}">
                                               <div class="modal-footer">
                                                   <button type="button" class="btn btn-secondary"
                                                           data-dismiss="modal">{{ trans('Product_trans.Close') }}</button>
                                                   <button type="submit"
                                                           class="btn btn-danger">{{ trans('Product_trans.submit') }}</button>
                                               </div>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
                            @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- add_modal_Product -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        {{ trans('Product_trans.add_Product') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- add_form -->
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="name" class="mr-sm-2">{{ trans('Product_trans.stage_name_ar') }}
                                    :</label>
                                <input id="name" type="text" name="name_ar" class="form-control">
                            </div>
                            <div class="col">
                                <label for="name_en" class="mr-sm-2">{{ trans('Product_trans.stage_name_en') }}
                                    :</label>
                                <input type="text" class="form-control" name="name_en">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col">
                                <label for="name" class="mr-sm-2">{{ trans('Product_trans.stage_description_ar') }}
                                    :</label>
                                <input id="name" type="text" name="description_ar" class="form-control">
                            </div>
                            <div class="col">
                                <label for="name_en" class="mr-sm-2">{{ trans('Product_trans.stage_description_en') }}
                                    :</label>
                                <input type="text" class="form-control" name="description_en">
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col">
                                <label for="name" class="mr-sm-2">{{ trans('Product_trans.Sar_price') }}
                                    :</label>
                                <input id="name" type="number" name="sar_price" class="form-control">
                            </div>
                            <div class="col">
                                <label for="name_en" class="mr-sm-2">{{ trans('Product_trans.Usd_price') }}
                                    :</label>
                                <input type="number" class="form-control" name="usd_price">
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col">
                                <label for="name" class="mr-sm-2">{{ trans('Product_trans.Quantity') }}
                                    :</label>
                                <input id="name" type="number" name="quantity" class="form-control">
                            </div>

                            <div class="col">
                                <label for="name_en" class="mr-sm-2">{{ trans('Product_trans.Category') }}
                                    :</label>

                                <div class="box">
                                    <select class="fancyselect" name="category_id">
                                        <option value="" selected disabled>
                                            {{ trans('Product_trans.Select_Category') }}
                                        </option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div><br>

                        <div class="form-group">
                            <label>{{ trans('Product_trans.Image') }}</label>
                            <input type="file" name="images[]" class="form-control image" accept="image/*"
                                multiple>
                        </div>



                        <br><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('Product_trans.Close') }}</button>
                    <button type="submit" class="btn btn-success">{{ trans('Product_trans.submit') }}</button>
                </div>
                </form>

            </div>
        </div>
    </div>

</div>

<!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render
@endsection
