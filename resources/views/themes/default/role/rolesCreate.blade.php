@extends('componentInjection::modalform')

@section('modalForm')
    @parent
    <label class="control-label col-md-12 col-sm-12 col-xs-12"></label>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rolekey"> Role Key </label>
        <input type="text" id="newKey" name="key" class="col-md-6 col-sm-6 col-xs-12" value=""/>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rolekey"><span class="star">*</span> Role Name </label>
        <input type="text" id="newName" name="name" class="col-md-6 col-sm-6 col-xs-12" value=""/>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="roledesc"><span class="star">*</span> Description</label>
        <textarea id="newDesc" name="description" class="col-md-6 col-sm-6 col-xs-12" rows="10"></textarea> &nbsp;
        <button id="addrole" type="button" class="btn btn-info btn-xs">Add This</button>
    </div>
@endsection

@section('modalHidden')
    <input type="hidden" id="saveRoledata" name="savedata" />
@endsection

@section('additional')
    <!-- New record show zone -->
    <div id="newRolelist">
        <div id="listZoneBase"></div>
    </div>
    <!-- New record temporary zone -->
    <div id="recordStack"></div>
    <script>
        // Close submit button
        modalBtnToggle('save','hide');

        // To show submit button according to list content
        $('#newRolelist').on('DOMSubtreeModified', function(){
            var ctrl = ( $('#newRolelist > div').last().attr('id') === 'listZoneBase' ) ? 'hide':'show';
            modalBtnToggle('save', ctrl);
        });

        // deal with event that click addrole button
        $('#addrole').on('click', function(){
            var el = ['Key','Name','Desc'];
            var error = '';
            var getUrl = '{{ route('component.dataRecord',['roleRecord']) }}';

            // input required detect
            if( $('#newKey').val().length==0 ){
                error = error + "Role key can not empty\n";
            }
            if( $('#newName').val().length==0 ){
                error = error + "Role name can not empty\n";
            }
            if( error.length > 0 ){
                alert(error);
                return false;
            }

            // ajax load data record element
            $('#recordStack').load(getUrl,function(){
                // 同步表單值到 Record Element 並清空表單值
                el.forEach(function(id) {
                    var selector = '#new'+id;
                    $('#recordStack').find('#stack'+id).each(function(){
                        $(this).html( $(selector).val() );
                        $(selector).val('');
                    });
                });

                // 將 Record Element 移往清單並移除暫存區資料
                $('#newRolelist > div').last().after( $('#recordStack').html()  );
                $('#recordStack').html('');

                // Json Transfer
                var dataset = new Array();
                var data = new Object;
                $('#newRolelist > div').each(function(){
                    var item = $(this);
                    if( item.attr('id') !== 'listZoneBase' ){
                        el.forEach(function(id) {
                            var selector = '#stack'+id;
                            item.find(selector).each(function(){
                                if(id==='Key') data.key = $(this).html();
                                if(id==='Name') data.name = $(this).html();
                                if(id==='Desc') data.desc = $(this).html();
                            });
                        });
                        dataset = dataset.concat(data);
                        data = new Object;
                    }
                });
                $('#saveRoledata').val(JSON.stringify(dataset));
            });
        });
    </script>
@endsection