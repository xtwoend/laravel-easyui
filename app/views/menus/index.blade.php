<div class="easyui-panel" title="info menu" data-options="collapsible:true">	
	Untuk menambahkan dan mengubah menu dan level access menu
</div>
<br>

<div class="easyui-layout" style="height:360px">
			<div data-options="region:'west',split:true" style="width:400px;padding:10px">
				<div class="easyui-panel" title="Menu Form" data-options="collapsible:true">	
					<form id="menuForm">
						<input type="hidden" name="id" id="id">
						<div class="row">
					        <div class="small-3 columns">
					          <label for="title" class="left inline">Title</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="text" id="title" name="title" class="form-control">
					        </div>
					      </div>
						<div class="row">
					        <div class="small-3 columns">
					          <label for="url" class="left inline">Url</label>
					        </div>
					        <div class="small-9 columns">
					          <input type="text" id="url" name="url" class="form-control">
					        </div>
					    </div>
						<div class="row">
					        <div class="small-3 columns">
					          <label for="role_id" class="left inline">Level Access</label>
					        </div>
					        <div class="small-9 columns">
					          {{ Form::select('role_id', Role::lists('name','id'),'', array('id'=>'role_id')) }}
					        </div>
					    </div>
					    <div class="row">
					        <div class="small-3 columns">
					          <label for="parent" class="left inline">Parent</label>
					        </div>
					        <div class="small-9 columns">
					          {{ Form::select('parent', array('0'=>'- root ') + Menu::lists('title','id'),'', array('id'=> 'parent')) }}
					        </div>
					    </div>
					    <div class="row">
						 	&nbsp;
						</div>
					    <div class="row">
						 	<button type="submit" class="tiny right">Save</button>
						</div>
					</form>
				</div>
			</div>
			<div data-options="region:'center'" style="padding:10px">
				
				<table id="menugrid" title="List Menu" style="width:500px;height:250px"
					data-options="fit:true,
									singleSelect:true,
									pagination:true,
									url:'{{ route('api.menus') }}',
									method:'get',
									remoteSort:true,
									striped:true,
									rownumbers:true,
									onDblClickRow: editMenu,
									">
				<thead>
					<tr>
						<th data-options="field:'id',width:60,sortable:true,align:'center'">Menu ID</th>
						<th data-options="field:'title',width:170,sortable:true">Name</th>
						<th data-options="field:'url',width:160">Url</th>
						<th data-options="field:'parent',width:80,sortable:true,align:'center'">Parent</th>
						<th data-options="field:'role_id',width:80,sortable:true">Level Access</th>
					</tr>
				</thead>
			</table>
			</div>
</div>

<script>
		$(document).ready(function() {
			// process the form
			$('#menuForm').submit(function(event) {

				var $method = ('' == $('input[name=id]').val()) ? 'POST' : 'PUT';
				var $url = ($method == 'POST') ? 'menu' : 'menu/' + $('input[name=id]').val();
				
				// get the form data
				var formData = {
					'title' 			: $('input[name=title]').val(),
					'url' 				: $('input[name=url]').val(),
					'role_id' 			: $('select[name=role_id]').val(),
					'parent' 			: $('select[name=parent]').val(),
				};

				// process the form
				$.ajax({
					type 		: $method,
					url 		: $url,
					data 		: formData,
					dataType 	: 'json',
					success 	: function(data) {
						if(data.success){
							// log data to the console so we can see
							$('#menugrid').datagrid('reload');
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
			
			var pager = $('#menugrid').datagrid().datagrid('getPager');	// get the pager of datagrid
			pager.pagination({
				buttons:[{
					iconCls:'fa fa-trash-o',
					handler:function(){
						var row = $('#menugrid').datagrid('getSelected');
						if (row){
							$.messager.confirm('Remove menu', 'Are you sure delete this menu?', function(r){
								if (r){
									$.ajax({
										type 		: 'DELETE',
										url 		: 'menu/'+ row.id,
										success 	: function(data) {
											// log data to the console so we can see
											if(data.success){
												$('#menugrid').datagrid('reload');
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
						url 	: '{{ route('api.menu.getbyid') }}',
						data 	: { id: f.id },
						dataType: 'json',
						success : function(r){
							$('input[name=id]').val(r.id);
							$('input[name=title]').val(r.title);
							$('input[name=url]').val(r.url);
							$('select[name=role_id]').val(r.role_id);
							$('select[name=parent]').val(r.parent);
						}
					});
		}
	</script>
