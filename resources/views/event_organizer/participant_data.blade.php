	<table class='table table-bordered table-striped'>
        <thead>
            <tr>
                <th style="width: 30px"></th>
                <th>ID Participant</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        	<tr v-if="!participants.length">
        		<td colspan="4" class="text-center">No Data Available</td>
        	</tr>
            <tr v-for="participant in participants">
            	<td><input type="checkbox" name="selected_id[]" :value="participant.id"></td>
            	<td>@{{participant.participant_id}}</td>
            	<td>@{{participant.name}}</td>
            	<td>@{{participant.email}}</td>
   			</tr>
        </tbody>
    </table>