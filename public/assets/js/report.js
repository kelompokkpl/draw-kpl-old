new Vue({
	el: '#root',
	data: {
		event_selected: '',
		events: [],
		row: {
			id: '',
			name: '',
			created_at: '',
			status: '',
			date_start: '',
			date_end: ''
		},

		categories: [],
		category: {
			name: '',
			is_draw: '',
			total_winner: ''
		},

		details: [],
		detail: {
			event_id: '',
			event_name: '',
			winners: []
		},
		winner: {
			id: '',
			name: '',
			phone: '',
			email: ''
		}
	},
	created() { 
	},
	computed: {
		isDisabled: function() {
			return !this.events.length;
		}
	},
	methods: {
		eventOnChange() {
			axios.get(basepath+"/detail_event/"+this.event_selected)
				.then(response => (this.events = response.data));
			axios.get(basepath+"/category_by_event/"+this.event_selected)
				.then(response => (this.categories = response.data));				
		},

	}
});