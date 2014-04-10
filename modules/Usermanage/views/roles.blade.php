<div class="easyui-panel" title="Role Manager" data-options="collapsible:true">	
	Untuk menambahkan dan mengubah Role dan level access menu
</div>
<br>

<div class="easyui-layout" style="height:450px">
			<div data-options="region:'west',split:true" style="width:400px;padding:10px">
				<div class="easyui-panel" title="Role Form" data-options="fit:true,collapsible:true">	
					<form id="roleForm" data-parsley-validate>
						<input type="hidden" name="id" id="id">
						<div class="row">
					        <div class="small-3 columns">
					          <label for="first_name" class="left inline">Name</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="text" id="name" class="form-control" name="name" required>
					        </div>
					      </div>
						<div class="row">
					        <div class="small-3 columns">
					          <label for="slug" class="left inline">Slug</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="text" id="slug" class="form-control" name="slug" required>
					        </div>
					    </div>
					    <div class="row">
						 	<button type="submit" class="tiny right">Save</button>
						</div>
					</form>
				</div>
			</div>
			<div data-options="region:'center'" style="padding:10px">
				
				<table id="rolegrid" title="Role Lists" style="width:500px;height:250px"
					data-options="fit:true,
									singleSelect:true,
									pagination:true,
									url:'{{ route('api.roles') }}',
									method:'get',
									remoteSort:true,
									striped:true,
									rownumbers:true,
									onDblClickRow: editMenu,
									">
				<thead>
					<tr>
						<th data-options="field:'id',width:60,sortable:true,align:'center'">Role ID</th>
						<th data-options="field:'name',width:200,sortable:true">Name</th>
						<th data-options="field:'slug',width:200,sortable:true">Slug</th>
					</tr>
				</thead>
			</table>
			</div>
</div>

<script>
		$(document).ready(function() {

			$('#roleForm').parsley();
			// process the form
			$('#roleForm').submit(function(event) {

				var $method = ('' == $('input[name=id]').val()) ? 'POST' : 'PUT';
				var $url = ($method == 'POST') ? '{{ route('roles.store') }}' : 'roles/' + $('input[name=id]').val();
				var $roledata = $('#roleForm').serialize();
				// process the form
				$.ajax({
					type 		: $method,
					url 		: $url,
					data 		: $roledata,
					dataType 	: 'json',
					success 	: function(data) {
						if(data.success){
							// log data to the console so we can see
							$('#rolegrid').datagrid('reload');
							$('input').val('');
						}
							$.messager.show({
								title:'status message',
								msg: data.message,
								showType:'show'
							});
					}
				});
				// stop the form from submitting and refreshing
				event.preventDefault();
			});
			
			var pager = $('#rolegrid').datagrid().datagrid('getPager');	// get the pager of datagrid
			pager.pagination({
				buttons:[{
					iconCls:'fa fa-trash-o',
					handler:function(){
						var row = $('#rolegrid').datagrid('getSelected');
						if (row){
							$.messager.confirm('Remove user', 'Are you sure delete this role?', function(r){
								if (r){
									$.ajax({
										type 		: 'DELETE',
										url 		: 'roles/'+row.id,
										success 	: function(data) {
											// log data to the console so we can see
											if(data.success){
												$('#rolegrid').datagrid('reload');
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

				$.ajax({
						type 	: 'GET',
						url 	: '{{ route('api.roles.getbyid') }}',
						data 	: { id: f.id },
						dataType: 'json',
						success : function(resp){
							//console.log(r);
							if(resp.success){
								var $user = resp.data;
				                for(var a in $user){
				                    $('#'+a).val($user[a]);
				                }
				            }

						}
				});
		}
	</script>
