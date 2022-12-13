<template>
    <div class="content">
        <div class="container-fluid">
            <card>
                <div class="row">
                    <div class="col-12">
                        <button @click="addMember" data-toggle="modal" class="btn btn-primary">Add Member</button>
                    </div>
                    <div class="col-12">
                        <l-table class="table-hover table-striped" :columns="users.columns" :data="users.data">
                        	<template v-slot="{row}">
                        		<td>{{row.id}}</td>
                        		<td>{{row.name}}</td>
                        		<td>{{row.email}}</td>
                        		<td>{{row.submissions_count || 0 }}</td>
                        		<td>
                        			<a href="javascript:void(0)" @click="">
                        				<i class="material-icons">user</i>
                        			</a>
                        		</td>
                        	</template>
                        </l-table>
                    </div>
                </div>
            </card>
        </div>
        <div class="modal fade" id="add-member-modal" role="dialog">
            <div class="modal-dialog" role="document">
                <ValidationObserver tag="div" v-slot="{handleSubmit}" class="modal-content">
                    <form ref="addMemberForm" @submit.prevent="handleSubmit(save)">
                        <div class="modal-header">
                            <h5 class="modal-title">ADD MEMBER</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <ValidationProvider name="name" tag="div" rules="required" v-slot="{errors}" class="form-group">
                                        <label class="form-label">Name</label>
                                        <input class="form-control" v-model="form.name" type="text">
                                        <span>{{errors[0]}}</span>
                                    </ValidationProvider>
                                    <ValidationProvider name="email" vid="email" tag="div" rules="required|email" v-slot="{errors}" class="form-group">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" v-model="form.email" type="email">
                                        <span>{{errors[0]}}</span>
                                    </ValidationProvider>
                                    <ValidationProvider name="password" tag="div" rules="required" v-slot="{errors}" class="form-group">
                                        <label class="form-label">Password</label>
                                        <input class="form-control" v-model="form.password" type="password">
                                        <span>{{errors[0]}}</span>
                                    </ValidationProvider>
                                    <button type="button" class="btn btn-primary float-right">Generate Password</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-right">ADD</button>
                        </div>
                    </form>
                </ValidationObserver>
            </div>
        </div>
    </div>
</template>
<script>
import LTable from '@/components/Table.vue'
import Card from '@/components/Cards/Card.vue'
const tableColumns = ['Id', 'Name', 'Email', 'Total Submissions', 'Action']
const tableData = []
export default {
    components: {
        LTable,
        Card
    },
    async created(){
    	this.fetch();
    },
    data() {
        return {
            form: {},
            users : {
            	data : [],
            },
            table1: {
                columns: [...tableColumns],
                data: [...tableData]
            },
        }
    },
    methods: {
        addMember() {
        	$('#add-member-modal').modal('show');
        },
        async fetch(page = 1){
        	let { data } = await axios.get('users',{page});
        	this.users = data.users;
        	this.users.columns = [...tableColumns];
        },
        async save(){
        	let fd = new FormData();
        	this.buildFormData(fd,this.form);
        	try {
	        	let { data } = await axios.post('users/',fd );
	        	if( data.status ){
	        		this.$snotify.success( data.message );
	        		this.fetch();
	        		this.form = {};
        			$('#add-member-modal').modal('hide');

	        	}
        		// statements
        	} catch(e) {
        		// statements
        		console.log(e);
        		if(e.response){
        			this.$refs.addMemberResolver.setErrors(e.response.data.errors);
        		}
        	}
        },
    }
}

</script>
