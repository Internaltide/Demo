@extends('componentInjection::modalform')

@section('modalForm')
    @parent
    <label class="col-md-12 col-sm-12 col-xs-12">
        <h4>請指定要加入該角色群組的使用者，他們將擁有該角色群組的授權操作</h4>
    </label>
    @foreach ($all->chunk(4) as $chunk)
        <div class="col-md-12 col-sm-12 col-xs-12">
            @foreach ($chunk as $u)
                <span class="col-md-3">
                    @if( in_array($u->user_id, $assigned) )
                        <input type="checkbox" class="flat" name="users[]" value="{{ $u->user_id }}" checked />
                    @else
                        <input type="checkbox" class="flat" name="users[]" value="{{ $u->user_id }}" />
                    @endif
                    {{ $u->user_name }}
                </span>
            @endforeach
        </div>
        <label class="col-md-12 col-sm-12 col-xs-12"></label>
    @endforeach
@endsection

@section('modalHidden')
    <input type="hidden" name="role" value="{{ $rolename }}" />
@endsection

@section('additional')
<!-- No Other Elements -->
@endsection