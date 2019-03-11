@extends('componentInjection::modalform')

@section('modalForm')
    @parent
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rolekey"><span class="star">*</span> Privilege Key </label>
        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-muted"> {{ $privilege->privilege_name }} </label>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rolekey"><span class="star">*</span> Privilege Name </label>
        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-muted"> {{ $privilege->label }} </label>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="roledesc"> Description</label>
        <textarea id="privilegedesc" name="description" class="col-md-6 col-sm-6 col-xs-12" rows="10">{{ $privilege->description }}</textarea>
    </div>
@endsection

@section('modalHidden')
    <input type="hidden" name="privilege" value="{{ $privilege->privilege_name }}" />
@endsection

@section('additional')
<!-- No Other Elements -->
@endsection