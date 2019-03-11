@extends('themes.default.layouts.app')

@section('pagecss')
<!-- No Custom Css -->
@endsection

@section('overrideCss')
    @parent
@endsection

@section('content')
<div class="row">

    <!-- Role List -->
    @inject('presenter', 'App\Helpers\PresenterHelper')
    @accordionPanel(['expend'=>'open', 'titleColor'=>'blue','panelTitle'=>'角色列表','panelDescript'=>''])
        @slot('panelContent')
            <button type="button" class="btn btn-success btn-xs pull-right" onclick="modalPopup('Roles Create','form','modal-xs','{{ route('perm.ajxform',['batch','createRoles']) }}',[modalDecorate])">
                <i class="fa fa-group"></i> 批次創建角色
            </button>
            <form id="actionFrm" method="post">
                <table id="rolelist" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th data-priority="2">Role name</th>
                            <th data-priority="5">Role key</th>
                            <th data-priority="3">Role type</th>
                            <th data-priority="4">Description</th>
                            <th data-priority="1">Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rolelist as $role)
                        <tr>
                            <td>{{ $role->label }}</td>
                            <td>{{ $role->role_name }}</td>
                            <td>{{ $role->role_type_label }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                            @if( $presenter->showPermbtn($role->role_type) )
                                <button type="button" class="btn btn-primary btn-xs" onclick="modalPopup('Users Assign','form','modal-xs','{{ route('perm.ajxform',[$role->role_name,'assignUser']) }}',[modalDecorate])">Assign users</button>
                                <button type="button" class="btn btn-primary btn-xs" onclick="modalPopup('Privilege Assign','form','modal-lg','{{ route('perm.ajxform',[$role->role_name,'assignPrivilege']) }}',[modalDecorate])">Assign privileges</button>
                                <button type="button" class="btn btn-primary btn-xs" onclick="modalPopup('Role Update','form','modal-xs','{{ route('perm.ajxform',[$role->role_name,'updateRole']) }}',[modalDecorate])">Update</button>
                                <button type="button" class="btn btn-primary btn-xs" onclick="javascript:deleteRole('{{ $role->role_type }}', '{{ $role->role_name }}');">Delete</button>
                            @endif
                            </td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ csrf_field() }}
                <input type="hidden" id="{{ $form->roletype }}" name="{{ $form->roletype }}" />
                <input type="hidden" id="{{ $form->rolekey }}" name="{{ $form->rolekey }}" />
            </form>
        @endslot
    @endaccordionPanel

    <!-- Privilege List -->
    @accordionPanel(['expend'=>'close', 'titleColor'=>'blue','panelTitle'=>'權限項目列表','panelDescript'=>''])
        @slot('panelContent')
            <table id="privilegelist" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th data-priority="2">Privilege name</th>
                        <th data-priority="4">Privilege key</th>
                        <th data-priority="3">Description</th>
                        <th data-priority="1">Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($privilegelist as $privilege)
                    <tr>
                        <td>{{ $privilege->label }}</td>
                        <td>{{ $privilege->privilege_name }}</td>
                        <td>{{ $privilege->description }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-xs" onclick="modalPopup('Privilege Update','form','modal-xs','{{ route('perm.ajxform',[$privilege->privilege_name,'updatePrivilege']) }}')">Update</button>
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endslot
    @endaccordionPanel

</div>

<!-- Modal Define -->
{!! Component::create('Modal@frame') !!}

@endsection

@section('pagejs')
    @parent
    deleteRole = function(type, name){
        var frm = $('form[id="actionFrm"]');

        $('#roletype').val(type);
        $('#rolekey').val(name);
        frm.attr('action', '{{ route("perm.delRoles") }}');
        frm.submit();
    }

    smartTools.Plugin.newResponsiveDatatable('#rolelist', 5, [ 2, 'asc' ], 5);
    smartTools.Plugin.newResponsiveDatatable('#privilegelist', 10, [ 0, 'asc' ], 4);
@endsection