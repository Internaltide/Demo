@extends('componentInjection::modalform')

@section('modalForm')
    @parent
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rolekey"><span class="star">*</span> Role Key </label>
        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-muted"> {{ $role->role_name }} </label>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rolekey"><span class="star">*</span> Role Name </label>
        <input type="text" id="rolename" name="name" class="col-md-6 col-sm-6 col-xs-12" value="{{ $role->label }}" required />
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="roledesc"> Description</label>
        <textarea id="roledesc" name="description" class="col-md-6 col-sm-6 col-xs-12" rows="10">{{ $role->description }}</textarea>
    </div>
@endsection

@section('modalHidden')
    <input type="hidden" name="role" value="{{ $role->role_name }}" />
@endsection

@section('additional')
<!-- No Other Elements -->
@endsection