new Vue({
	el: '#root',
	data: {
		event_selected: '',
		category_selected: '',
		categories: [],
		category: {
			id: '',
			name: ''
		},

		participants: [],
		participant: {
			participant_id: '',
			name: '',
			email: '',
			phone: '',
			event_id: '',
			event_name: ''
		},
	},
	created() { 
	},
	computed: {
		isDisabled: function() {
			return !this.participants.length;
		}
	},
	methods: {
		eventOnChange() {
			console.log(basepath);
			axios.get(basepath+"/category_by_event/"+this.event_selected)
				.then(response => (this.categories = response.data));
				// this.category_selected = this.categories[0].id;
				this.participants = '';
		},

		categoryOnChange() {
			switch(page){
				case 'category_disabled':
					axios.get(basepath+"/participant_by_event_category/"+this.event_selected+'/'+this.category_selected)
						.then(response => (this.participants = response.data));
					break;
				case 'winner':
					axios.get(basepath+"/winner_by_event_category/"+this.event_selected+'/'+this.category_selected)
						.then(response => (this.participants = response.data));
					break;
			}
			
		}

	}
});

$("#form").submit(function(){
    var checked = $("#form input[type=checkbox]:checked").length > 0;
    if (!checked){
        swal({   
            title: "Warning",   
            text: "Please check list at least one data!",   
            type: "warning",    
            confirmButtonColor: "#ff0000",   
            confirmButtonText: "OK",  
            closeOnConfirm: false 
        });
        return false;
    }
});