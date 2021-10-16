	<table class='table table-bordered table-striped'>
        <tr v-if="events.length == 0">
            <td colspan="4" class="text-center">No Data Available</td>
        </tr>
        <tbody v-for="(row, index) in events">
            <!-- <tr v-for="event in events">
            	
   			</tr> -->
            <tr v-if="index==0">
                <th>Event Name</th>
                <td>@{{row.name}}</td>
            </tr>
            <tr v-if="index==0">
                <th>Event Organizer</th>
                <td>{{ CRUDBooster::myName() }}</td>
            </tr>
            <tr v-if="index==0">
                <th>Event Status</th>
                <td>@{{row.status}}</td>
            </tr>
            <tr v-if="index==0">
                <th>Created Date</th>
                <td>@{{row.created_at}}</td>
            </tr>
            <tr v-if="index==0">
                <th>Held</th>
                <td>@{{row.date_start}} until @{{row.date_end}}</td>
            </tr>
            <tr v-if="index==0">
                <th>Number of Categories</th>
                <td>@{{categories.length}}</td>
            </tr>
        </tbody>
            <tr v-if="events.length != 0">
                <th>Draw Categories</th>
                <td v-if="categories.length != 0">
                    <ul v-for="category in categories">
                        <li v-if="category.is_draw==1">@{{category.name}} &nbsp;&nbsp;<span class="label label-success">(Drawn - @{{category.total_winner}} winners)</span></li>
                        <li v-if="category.is_draw==0">@{{category.name}}</li>
                    </ul>
                </td>
                <td v-if="categories.length == 0"> - </td>
            </tr>
    </table>