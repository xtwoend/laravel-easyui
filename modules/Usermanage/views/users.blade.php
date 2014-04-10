<div class="easyui-panel" title="user manager" data-options="collapsible:true">	
	Untuk menambahkan dan mengubah user dan level access menu <% info %>
</div>
<br>

<div class="easyui-layout" style="height:450px">
			<div data-options="region:'west',split:true" style="width:400px;padding:10px">
				<div class="easyui-panel" title="User Form" data-options="fit:true,collapsible:true,tools:'#userformtool'">	
					<form id="userForm">
						<input type="hidden" name="id" id="id">
						<div class="row">
					        <div class="small-3 columns">
					          <label for="first_name" class="left inline">First Name</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="text" id="first_name" name="first_name" class="form-control" data-parsley-required="true">
					        </div>
					      </div>
						<div class="row">
					        <div class="small-3 columns">
					          <label for="last_name" class="left inline">Last Name</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="text" id="last_name" name="last_name" class="form-control">
					        </div>
					    </div>
						<div class="row">
					        <div class="small-3 columns">
					          <label for="email" class="left inline">Email</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="email" id="email" name="email" class="form-control" data-parsley-remote="{{ route('api.users.validate') }}" data-parsley-required="true">
					        </div>
					    </div>
					    <hr>
					    <div class="row">
					        <div class="small-3 columns">
					          <label for="username" class="left inline">Username</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="text" id="username" name="username" class="form-control" data-parsley-remote="{{ route('api.users.validate') }}" data-parsley-required="true">
					        </div>
					    </div>
					    <div class="row">
					        <div class="small-3 columns">
					          <label for="password" class="left inline">Password</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="password" id="password" name="password" class="form-control" data-parsley-required="true">
					        </div>
					    </div>
					    <div class="row">
					        <div class="small-3 columns">
					          <label for="re_password" class="left inline">Re Password</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="password" id="re_password" class="form-control" data-parsley-equalto="#password" data-parsley-required="true">
					        </div>
					    </div>
					    <hr>
					   
					    <div class="row">
					        <div class="small-3 columns">
					          <label for="re_password" class="left inline">Status</label>
					        </div>
					        <div class="small-9 columns">
					          <label><input id="active" type="checkbox" name="active">Active</label>
					        </div>
					    </div>
					    <hr>
					    <div class="row">
					        <div class="small-3 columns">
					          <label for="re_password" class="left inline">Roles</label>
					        </div>
					        <div class="small-9 columns">
					          	@foreach(Role::all() as $role)
									<label><input type="checkbox" name="roles[]" class="roles" id="{{ $role->slug }}" value="{{ $role->id }}"> {{ $role->name }} </label>
					          	@endforeach
					        </div>
					    </div>
					    
					    <div class="row">
						 	<button type="submit" class="tiny right">Save</button>
						</div>
					</form>
				</div>
				<div id="userformtool">
					<a href="javascript:void(0)" onclick="newUser()"><i class="fa fa-plus-square fa-lg"></i></a>
				</div>
			</div>
			<div data-options="region:'center'" style="padding:10px">
				
				<table id="usergrid" title="User Lists" style="width:500px;height:250px"
					data-options="fit:true,
									singleSelect:true,
									pagination:true,
									url:'{{ route('api.users') }}',
									method:'get',
									remoteSort:true,
									striped:true,
									rownumbers:true,
									onDblClickRow: editMenu,
									">
				<thead>
					<tr>
						<th data-options="field:'id',width:60,sortable:true,align:'center'">User ID</th>
						<th data-options="field:'first_name',width:150,sortable:true">Name</th>
						<th data-options="field:'username',width:100,sortable:true">Username</th>
						<th data-options="field:'email',width:160,sortable:true">Email</th>
						<th data-options="field:'last_login',width:130,sortable:true">Last Login</th>
						<th data-options="field:'active',width:40,sortable:true,align:'center'">Active</th>
					</tr>
				</thead>
			</table>
			</div>
</div>
<script>
		$(document).ready(function() {

			$("#active").change(function() {
			    (this.checked)? $(this).val(1) : $(this).val(0);
			});
			// process the form
			$('#userForm').submit(function(e) {
				var $method = ('' == $('input[name=id]').val()) ? 'POST' : 'PUT';
				var $url = ($method == 'POST') ? '{{ route('users.store') }}' : 'users/' + $('input[name=id]').val();
				var $userdata = $('#userForm').serialize();
				// process the form
				$.ajax({
					type 		: $method,
					url 		: $url,
					data 		: $userdata,
					dataType 	: 'json',
					success 	: function(data) {
						if(data.success){
							// log data to the console so we can see
							$('#usergrid').datagrid('reload');
							newUser();
						}
							$.messager.show({
								title:'status message',
								msg: data.message,
								showType:'show'
							});
					}
				});
				// stop the form from submitting and refreshing
				e.preventDefault();
			});
			
			var pager = $('#usergrid').datagrid().datagrid('getPager');	// get the pager of datagrid
			pager.pagination({
				buttons:[{
					iconCls:'fa fa-trash-o',
					handler:function(){
						var row = $('#usergrid').datagrid('getSelected');
						if (row){
							$.messager.confirm('Remove user', 'Are you sure delete this user?', function(r){
								if (r){
									$.ajax({
										type 		: 'DELETE',
										url 		: 'users/'+row.id,
										success 	: function(data) {
											// log data to the console so we can see
											if(data.success){
												$('#usergrid').datagrid('reload');
												$.messager.show({
													title:'status message',
													msg: data.message,
													showType:'show'
												});
											}
										}
									});
								}
							});
						}
					}
				}]
			});	

		});
		function editMenu(i,f){
			//$('form').parsley('destroy');
			$.ajax({
				type 	: 'GET',
				url 	: '{{ route('api.users.getbyid') }}',
				data 	: { id: f.id },
				dataType: 'json',
				success : function(resp){
							//console.log(r);
					if(resp.success){
						var $user = resp.data.user;
						if(1 == $user['active']){
							$('#active').prop('checked', true);
						}else{
							$('#active').prop('checked', false);
						}
				        for(var a in $user){
				            $('#'+a).val($user[a]);
				        }

						$('.roles').prop('checked', false);
						var $roles = resp.data.roles;
						$.each($roles, function(i,v){
							$('#'+v).prop('checked', true);
				        });
				    }
				}
			});
		}

		function newUser(){
			//$('form').parsley('destroy');
			//$('form').parsley();
			$('input[name=id]').val('');
			$('input').prop('checked', false);
		}
	</script>
