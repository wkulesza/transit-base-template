<?php
/*
 * Trip Planner Form
 * Requires Google API key for Autocomplete to work
 */
?>
    <div id="planner-header">
		<h1><span class="icon-location icon-med"></span>Plan Your Trip</h1>
	</div>
	<div id="planner-content" class="clearfix">
        <!--TODO: change the form action to not go to trillium -->
		<form name="f" action="http://jump.trilliumtransit.com/redirect.php">
            <input type="hidden" name="sort" value="walk"/>
			
			<div class="form-row">
                <div class="err-msg" tabindex="-1">Please enter a valid starting address.</div>
				<label for="saddr" class="screen-reader-text">Starting Location</label>
				<input type="text" name="saddr" id="saddr" placeholder="Starting Location" required="required">
			</div>
			<div class="form-row">
                <div class="err-msg" tabindex="-1">Please enter a valid destination address.</div>
				<label for="daddr" class="screen-reader-text">Destination</label>
				<input type="text" name="daddr" id="daddr" placeholder="Destination" required="required">
			</div>
			<div class="form-row">
				<label for="dep">Depart at</label>
				<input id="dep" type="radio" name="ttype" value="dep" checked="checked">
				<span class="small">or</span>
				<label for="arr">Arrive by</label>
				<input id="arr" type="radio" name="ttype" value="arr">
			</div>
			<div class="form-row">
                <div class="err-msg" tabindex="-1">Please enter a valid time.</div>
				<label for="ftime" class="obscure screen-reader-text">Time</label>
				<input type="text" id="ftime" name="time" value="">
				<label for="fdate" class="obscure screen-reader-text">Date</label>
				<input type="text" id="fdate" name="date" value="">
			</div>

			<button type="submit" value="Get Directions" class="btn btn-default">Get Directions</button>
		</form>
	</div>