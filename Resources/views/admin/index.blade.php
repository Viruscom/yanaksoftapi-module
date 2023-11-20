@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/shop.css') }}" rel="stylesheet"/>
@endsection

@section('content')
    @include('yanaksoftapi::admin.breadcrumbs')
    @include('admin.notify')

    <form action="{{ route('admin.shop.settings.internal-integrations.yanak.update') }}" method="POST">
        <div class="col-xs-12 p-0">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="bg-grey top-search-bar">
                <div class="action-mass-buttons pull-right">
                    <button type="submit" name="submit" value="submit" class="btn btn-lg save-btn margin-bottom-10"><i class="fas fa-save"></i></button>
                    <a href="{{ route('admin.shop.settings.internal-integrations.index') }}" role="button" class="btn btn-lg back-btn margin-bottom-10"><i class="fa fa-reply"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form form-horizontal">
                    <div class="form-body">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span>{{ __('shop::admin.yanak_soft_api.settings') }}</span>
                                </div>
                            </div>
                            <div class="portlet-body">

                                <div class="form-group">
                                    <label class="control-label col-md-3">EMAIL:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="client_email" value="{{ $settings->client_email }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">USERNAME:</label>
                                    <div class="col-md-6">
                                        <input type="text" name="username" value="{{ $settings->username }}" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
