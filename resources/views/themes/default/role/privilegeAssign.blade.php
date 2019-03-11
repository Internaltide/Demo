@extends('componentInjection::modalform')

@section('modalForm')
    @parent
    <label class="col-md-12 col-sm-12 col-xs-12">
        <h4>請指定該角色群組的授權項目，隸屬該角色群組的成員將擁有指定的授權操作</h4>
    </label>
    @foreach ($all->chunk(4) as $chunk)
        <div class="col-md-12 col-sm-12 col-xs-12">
            @foreach ($chunk as $p)
                <span class="col-md-3">
                    @if( in_array($p->privilege_name, $assigned) )
                        <input type="checkbox" class="flat" name="privileges[]" value="{{ $p->privilege_name }}" checked />
                    @else
                        <input type="checkbox" class="flat" name="privileges[]" value="{{ $p->privilege_name }}" />
                    @endif
                    {{  $p->label }}
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